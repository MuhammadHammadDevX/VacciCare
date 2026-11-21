const puppeteer = require('./node_modules/puppeteer-core');
const { spawn } = require('child_process');
const http = require('http');
const path = require('path');

const BASE_URL = 'http://127.0.0.1:8000';

function waitServer(url, timeout = 15000) {
  const start = Date.now();
  return new Promise((resolve, reject) => {
    const check = () => {
      http.get(url, (res) => resolve()).on('error', (err) => {
        if (Date.now() - start > timeout) return reject(new Error('Server timeout: ' + err.message));
        setTimeout(check, 300);
      });
    };
    check();
  });
}

const auditResults = {
  testedPages: 0,
  pageErrors: [],
  consoleErrors: [],
  overflowIssues: [],
  responsiveTests: []
};

async function testPage(page, url, name, isAuth = false) {
  auditResults.testedPages++;
  const consoleErrs = [];
  const onConsole = msg => {
    if (msg.type() === 'error') {
      const text = msg.text();
      // Ignore innocuous favicon/map tile 404s if any
      if (!text.includes('favicon') && !text.includes('tile.openstreetmap')) {
        consoleErrs.push(text);
      }
    }
  };
  const onPageErr = err => {
    auditResults.pageErrors.push({ url, name, error: err.message });
  };

  page.on('console', onConsole);
  page.on('pageerror', onPageErr);

  try {
    const res = await page.goto(url, { waitUntil: 'networkidle2' });
    const status = res.status();
    if (status >= 400) {
      auditResults.pageErrors.push({ url, name, error: `HTTP Status ${status}` });
    }

    // Check for PHP Fatal / Syntax error in body
    const bodyText = await page.evaluate(() => document.body ? document.body.innerText : '');
    if (bodyText.includes('Fatal error') || bodyText.includes('Parse error') || bodyText.includes('SQLSTATE[')) {
      auditResults.pageErrors.push({ url, name, error: 'Database or PHP Fatal Exception detected in page text' });
    }

    // Test responsive overflows across 3 viewports: Desktop (1440), Tablet (768), Mobile (375)
    const viewports = [
      { name: 'Desktop', width: 1440, height: 900 },
      { name: 'Tablet', width: 768, height: 1024 },
      { name: 'Mobile', width: 375, height: 667 }
    ];

    for (const vp of viewports) {
      await page.setViewport(vp);
      await new Promise(r => setTimeout(r, 200));

      const overflow = await page.evaluate(() => {
        const root = document.documentElement;
        const body = document.body;
        const scrollW = Math.max(root.scrollWidth, body.scrollWidth);
        const clientW = root.clientWidth;
        return {
          hasOverflow: scrollW > clientW + 5, // 5px tolerance
          scrollW,
          clientW
        };
      });

      if (overflow.hasOverflow) {
        auditResults.overflowIssues.push({
          url,
          name,
          viewport: vp.name,
          scrollW: overflow.scrollW,
          clientW: overflow.clientW
        });
      }
    }

    // Reset to Desktop
    await page.setViewport({ width: 1440, height: 900 });

  } catch (err) {
    auditResults.pageErrors.push({ url, name, error: err.message });
  } finally {
    page.off('console', onConsole);
    page.off('pageerror', onPageErr);
  }

  if (consoleErrs.length > 0) {
    auditResults.consoleErrors.push({ url, name, errors: consoleErrs });
  }
}

async function runDeepAudit() {
  console.log('=== STARTING DEEP SYSTEM & RESPONSIVE AUDIT ===\n');

  const phpServer = spawn('php', ['-S', '127.0.0.1:8000', '-t', 'public'], {
    cwd: __dirname,
    stdio: 'ignore'
  });

  try {
    await waitServer(BASE_URL);
    console.log('✔ PHP Live Server connected at ' + BASE_URL);

    const browser = await puppeteer.launch({
      executablePath: 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe',
      headless: true,
      args: ['--no-sandbox', '--disable-setuid-sandbox', '--window-size=1440,900']
    });

    // ----------------------------------------------------
    // 1. PUBLIC PAGES AUDIT
    // ----------------------------------------------------
    console.log('Auditing Public Pages...');
    const pubCtx = await browser.createBrowserContext();
    const pubPage = await pubCtx.newPage();

    const publicUrls = [
      { name: 'Home Landing', url: `${BASE_URL}/` },
      { name: 'Vaccines Catalog', url: `${BASE_URL}/vaccines` },
      { name: 'Public Appointment', url: `${BASE_URL}/appointment` },
      { name: 'Unified Sign In', url: `${BASE_URL}/signin` },
      { name: 'Role Selection', url: `${BASE_URL}/register-select` },
      { name: 'Parent Registration', url: `${BASE_URL}/register` },
      { name: 'Hospital Registration', url: `${BASE_URL}/hospital/register` },
      { name: 'Admin Login', url: `${BASE_URL}/admin/login` },
      { name: 'Hospital Staff Login', url: `${BASE_URL}/hospital/login` },
      { name: 'Certificate Verification', url: `${BASE_URL}/verify-certificate/SqdFUqg49tVE6bdhmko2v47XiHIoBxRl` }
    ];

    for (const p of publicUrls) {
      await testPage(pubPage, p.url, p.name);
    }
    await pubCtx.close();

    // ----------------------------------------------------
    // 2. ADMIN PANEL AUDIT & INTERACTION TESTS
    // ----------------------------------------------------
    console.log('Auditing Admin Panel & Interactive Features...');
    const adminCtx = await browser.createBrowserContext();
    const adminPage = await adminCtx.newPage();

    await adminPage.goto(`${BASE_URL}/admin/login`, { waitUntil: 'networkidle2' });
    await adminPage.type('#adminEmail', 'admin@gmail.com');
    await adminPage.type('#adminPassword', 'admin123');
    await Promise.all([
      adminPage.click('button[type="submit"]'),
      adminPage.waitForNavigation({ waitUntil: 'networkidle2' })
    ]);

    const adminUrls = [
      { name: 'Admin Dashboard', url: `${BASE_URL}/admin/dashboard` },
      { name: 'Admin Profile', url: `${BASE_URL}/admin/profile` },
      { name: 'Admin Edit Profile', url: `${BASE_URL}/admin/edit-profile` },
      { name: 'Admin All Children', url: `${BASE_URL}/admin/children` },
      { name: 'Admin Child Details', url: `${BASE_URL}/admin/child-details/1` },
      { name: 'Admin Vaccination Date & Time', url: `${BASE_URL}/admin/vaccinations-date` },
      { name: 'Admin Reports Overview', url: `${BASE_URL}/admin/vaccination-report` },
      { name: 'Admin Vaccine List', url: `${BASE_URL}/admin/vaccine-list` },
      { name: 'Admin Parent Requests', url: `${BASE_URL}/admin/parent-requests` },
      { name: 'Admin Add Hospital', url: `${BASE_URL}/admin/add-hospital` },
      { name: 'Admin Hospital List', url: `${BASE_URL}/admin/hospitals` },
      { name: 'Admin View Hospital', url: `${BASE_URL}/admin/view-hospital/1` },
      { name: 'Admin Edit Hospital', url: `${BASE_URL}/admin/edit-hospital/1` },
      { name: 'Admin Booking Details', url: `${BASE_URL}/admin/booking-details` }
    ];

    for (const p of adminUrls) {
      await testPage(adminPage, p.url, p.name, true);
    }

    // INTERACTIVE AUDIT: Admin Header Dropdown
    console.log('Testing Admin Header Dropdown...');
    await adminPage.goto(`${BASE_URL}/admin/dashboard`, { waitUntil: 'networkidle2' });
    const profileBtn = await adminPage.$('#headerProfileBtn');
    if (profileBtn) {
      await profileBtn.click();
      await new Promise(r => setTimeout(r, 300));
      const isOpen = await adminPage.evaluate(() => {
        const wrapper = document.getElementById('headerProfileWrapper');
        return wrapper && wrapper.classList.contains('open');
      });
      console.log('  ✔ Admin Profile Dropdown Click Test: ' + (isOpen ? 'PASS' : 'FAIL'));
    }

    // INTERACTIVE AUDIT: Admin Booking Details Live Search
    console.log('Testing Admin Booking Details Live Search...');
    await adminPage.goto(`${BASE_URL}/admin/booking-details`, { waitUntil: 'networkidle2' });
    const searchInput = await adminPage.$('#bookingSearch');
    if (searchInput) {
      await searchInput.type('Zainab');
      await new Promise(r => setTimeout(r, 300));
      const visibleCount = await adminPage.evaluate(() => {
        const rows = Array.from(document.querySelectorAll('#bookingTableBody tr'));
        return rows.filter(r => r.style.display !== 'none').length;
      });
      console.log('  ✔ Booking Details Search Filter Test (found rows): ' + visibleCount);
    }

    // INTERACTIVE AUDIT: Admin Vaccine List Availability Dropdown
    console.log('Testing Admin Vaccine Availability Dropdown...');
    await adminPage.goto(`${BASE_URL}/admin/vaccine-list`, { waitUntil: 'networkidle2' });
    const availBtn = await adminPage.$('.vc-custom-select-trigger');
    if (availBtn) {
      await availBtn.click();
      await new Promise(r => setTimeout(r, 300));
      const menuOpen = await adminPage.evaluate(() => {
        const wrap = document.querySelector('.vc-custom-select-wrapper');
        return wrap && wrap.classList.contains('open');
      });
      console.log('  ✔ Vaccine List Custom Dropdown Click Test: ' + (menuOpen ? 'PASS' : 'FAIL'));
    }

    await adminCtx.close();

    // ----------------------------------------------------
    // 3. HOSPITAL PANEL AUDIT
    // ----------------------------------------------------
    console.log('Auditing Hospital Panel...');
    const hospCtx = await browser.createBrowserContext();
    const hospPage = await hospCtx.newPage();

    await hospPage.goto(`${BASE_URL}/hospital/login`, { waitUntil: 'networkidle2' });
    await hospPage.type('#hospitalEmail', 'agakhan@hospital.com');
    await hospPage.type('#hospitalPassword', 'hospital123');
    await Promise.all([
      hospPage.click('button[type="submit"]'),
      hospPage.waitForNavigation({ waitUntil: 'networkidle2' })
    ]);

    const hospUrls = [
      { name: 'Hospital Dashboard', url: `${BASE_URL}/hospital/dashboard` },
      { name: 'Hospital Profile', url: `${BASE_URL}/hospital/profile` },
      { name: 'Hospital Edit Profile', url: `${BASE_URL}/hospital/edit-profile` },
      { name: 'Hospital Appointments', url: `${BASE_URL}/hospital/appointments` },
      { name: 'Hospital Vaccine Status', url: `${BASE_URL}/hospital/vaccine-status` },
      { name: 'Hospital Add Vaccine', url: `${BASE_URL}/hospital/add-vaccine` },
      { name: 'Hospital All Vaccines', url: `${BASE_URL}/hospital/all-vaccines` },
      { name: 'Hospital Vaccinators', url: `${BASE_URL}/hospital/vaccinators` }
    ];

    for (const p of hospUrls) {
      await testPage(hospPage, p.url, p.name, true);
    }
    await hospCtx.close();

    // ----------------------------------------------------
    // 4. PARENT PANEL AUDIT
    // ----------------------------------------------------
    console.log('Auditing Parent Panel...');
    const parentCtx = await browser.createBrowserContext();
    const parentPage = await parentCtx.newPage();

    await parentPage.goto(`${BASE_URL}/signin`, { waitUntil: 'networkidle2' });
    await parentPage.type('#email', 'faiza@gmail.com');
    await parentPage.type('#password', 'parent123');
    await Promise.all([
      parentPage.click('.signin-btn'),
      parentPage.waitForNavigation({ waitUntil: 'networkidle2' })
    ]);

    const parentUrls = [
      { name: 'Parent Dashboard', url: `${BASE_URL}/parent/dashboard` },
      { name: 'Parent Profile', url: `${BASE_URL}/parent/profile` },
      { name: 'Parent Edit Profile', url: `${BASE_URL}/parent/edit-profile` },
      { name: 'Parent My Children', url: `${BASE_URL}/parent/my-children` },
      { name: 'Parent Edit Child', url: `${BASE_URL}/parent/edit-child/1` },
      { name: 'Parent Vaccination Schedule', url: `${BASE_URL}/parent/vaccination-schedule` },
      { name: 'Parent Book Hospital', url: `${BASE_URL}/parent/book-hospital` },
      { name: 'Parent Request Hospital', url: `${BASE_URL}/parent/request-hospital` },
      { name: 'Parent Vaccination Report', url: `${BASE_URL}/parent/vaccination-report` }
    ];

    for (const p of parentUrls) {
      await testPage(parentPage, p.url, p.name, true);
    }
    await parentCtx.close();

    await browser.close();

    // ----------------------------------------------------
    // AUDIT SUMMARY & REPORTING
    // ----------------------------------------------------
    console.log('\n======================================================');
    console.log('AUDIT REPORT SUMMARY');
    console.log('======================================================');
    console.log(`Total Pages Tested: ${auditResults.testedPages}`);
    console.log(`Page Errors: ${auditResults.pageErrors.length}`);
    console.log(`Console Errors: ${auditResults.consoleErrors.length}`);
    console.log(`Overflow / Layout Issues: ${auditResults.overflowIssues.length}`);

    if (auditResults.pageErrors.length > 0) {
      console.log('\n[!] PAGE ERRORS:');
      console.log(JSON.stringify(auditResults.pageErrors, null, 2));
    }

    if (auditResults.consoleErrors.length > 0) {
      console.log('\n[!] CONSOLE ERRORS:');
      console.log(JSON.stringify(auditResults.consoleErrors, null, 2));
    }

    if (auditResults.overflowIssues.length > 0) {
      console.log('\n[!] OVERFLOW / RESPONSIVE WARNINGS:');
      console.log(JSON.stringify(auditResults.overflowIssues, null, 2));
    }

    if (auditResults.pageErrors.length === 0 && auditResults.overflowIssues.length === 0) {
      console.log('\n⭐⭐⭐ 100% CLEAN BILL OF HEALTH! NO ISSUES FOUND! ⭐⭐⭐');
    }
    console.log('======================================================\n');

  } finally {
    phpServer.kill();
  }
}

runDeepAudit().catch(err => {
  console.error('AUDIT CRITICAL ERROR:', err);
  process.exit(1);
});
