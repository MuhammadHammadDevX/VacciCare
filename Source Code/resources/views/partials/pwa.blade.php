<!-- Progressive Web App (PWA) Assets -->
<link rel="manifest" href="{{ asset('manifest.json') }}">
<meta name="theme-color" content="#0284c7">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="default">
<meta name="apple-mobile-web-app-title" content="VacciCare">
<link rel="apple-touch-icon" href="{{ asset('images/pwa/icon.svg') }}">

<!-- Floating PWA Install Banner -->
<div id="pwaInstallBanner" style="display:none; position:fixed; bottom:20px; right:20px; z-index:99999; background:#ffffff; border:1px solid #0284c7; box-shadow:0 12px 28px rgba(2,132,199,0.22); border-radius:14px; padding:12px 16px; max-width:340px; font-family:'Plus Jakarta Sans',sans-serif; animation:slideUp 0.3s ease;">
    <div style="display:flex; align-items:center; gap:12px;">
        <img src="{{ asset('images/pwa/icon.svg') }}" style="width:40px; height:40px; border-radius:8px;" alt="VacciCare App">
        <div style="flex:1;">
            <strong style="display:block; font-size:13px; color:#0f172a;">Install VacciCare App</strong>
            <span style="font-size:11px; color:#64748b; line-height:1.2; display:block;">Fast access &amp; instant vaccination reminders on your device.</span>
        </div>
        <button type="button" id="pwaCloseBtn" style="background:none; border:none; color:#94a3b8; font-size:16px; cursor:pointer; padding:2px;">&times;</button>
    </div>
    <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px;">
        <button type="button" id="pwaDismissBtn" style="background:#f1f5f9; border:none; border-radius:6px; padding:5px 12px; font-size:11px; font-weight:600; color:#475569; cursor:pointer;">Not Now</button>
        <button type="button" id="pwaInstallBtn" style="background:#0284c7; border:none; border-radius:6px; padding:5px 14px; font-size:11px; font-weight:700; color:#ffffff; cursor:pointer; display:inline-flex; align-items:center; gap:4px;">
            <i class="bi bi-download"></i> Install App
        </button>
    </div>
</div>

<script>
if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(reg) {
            // Service worker registered
        }).catch(function(err) {
            console.log('SW registration failed: ', err);
        });
    });
}

(function() {
    var deferredPrompt;
    var banner = document.getElementById('pwaInstallBanner');
    var installBtn = document.getElementById('pwaInstallBtn');
    var dismissBtn = document.getElementById('pwaDismissBtn');
    var closeBtn = document.getElementById('pwaCloseBtn');

    if (sessionStorage.getItem('pwa_dismissed') === '1') {
        return;
    }

    window.addEventListener('beforeinstallprompt', function(e) {
        e.preventDefault();
        deferredPrompt = e;
        if (banner) {
            banner.style.display = 'block';
        }
    });

    if (installBtn) {
        installBtn.addEventListener('click', function() {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then(function(choice) {
                    deferredPrompt = null;
                    if (banner) banner.style.display = 'none';
                });
            }
        });
    }

    function dismissBanner() {
        if (banner) banner.style.display = 'none';
        sessionStorage.setItem('pwa_dismissed', '1');
    }

    if (dismissBtn) dismissBtn.addEventListener('click', dismissBanner);
    if (closeBtn) closeBtn.addEventListener('click', dismissBanner);
})();
</script>
