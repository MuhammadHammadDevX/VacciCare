/**
 * VacciCare - Premium 3D Animations & Interactive Engine
 * Handles 3D tilt on mousemove, dynamic spotlight glow, smooth scroll reveal, 
 * counter animation, & responsive navbar interactions
 */

(function () {
    "use strict";

    const prefersReducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

    // =========================================================================
    // 1. Interactive 3D Card Tilt & Mouse Spotlight on Mouse Move
    // =========================================================================
    function init3DTiltAndSpotlight() {
        if (prefersReducedMotion || window.innerWidth < 992) return;

        const tiltTargets = document.querySelectorAll(
            ".vc-3d-card, .stat-card, .dashboard-stat-card, .hospital-card, .how-it-works-card, .department-wrap, .staff, .hero-metric-card"
        );

        tiltTargets.forEach((card) => {
            let isHovering = false;

            card.addEventListener("mouseenter", () => {
                isHovering = true;
                card.style.transition = "transform 0.15s ease-out, box-shadow 0.25s ease-out";
            });

            card.addEventListener("mousemove", (e) => {
                if (!isHovering) return;
                const rect = card.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;

                const centerX = rect.width / 2;
                const centerY = rect.height / 2;

                const rotateX = ((y - centerY) / centerY) * -7; // Max 7 deg
                const rotateY = ((x - centerX) / centerX) * 7;

                card.style.transform = `perspective(1000px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateZ(10px) scale3d(1.02, 1.02, 1.02)`;
                
                // Dynamic Spotlight Glow
                card.style.setProperty("--mouse-x", `${x}px`);
                card.style.setProperty("--mouse-y", `${y}px`);
            });

            card.addEventListener("mouseleave", () => {
                isHovering = false;
                card.style.transition = "transform 0.5s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.5s ease";
                card.style.transform = "perspective(1000px) rotateX(0deg) rotateY(0deg) translateZ(0) scale3d(1, 1, 1)";
            });
        });
    }

    // =========================================================================
    // 2. Animated Counter for Stat Numbers
    // =========================================================================
    function initCounterAnimation() {
        const counters = document.querySelectorAll(".number, .stat-number, .stat-value, [data-number]");
        if (!counters.length) return;

        const observer = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const text = el.getAttribute("data-number") || el.textContent.trim();
                if (text.includes("/") || el.classList.contains("no-count")) return;
                const targetNum = parseInt(text.replace(/[^0-9]/g, ""), 10);

                if (isNaN(targetNum) || el.classList.contains("vc-counted")) return;
                el.classList.add("vc-counted");

                const suffix = text.includes("%") ? "%" : text.includes("+") ? "+" : "";
                let start = 0;
                const duration = 1800;
                const startTime = performance.now();

                function updateCount(currentTime) {
                    const elapsed = currentTime - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    const ease = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
                    const currentVal = Math.floor(ease * targetNum);

                    el.textContent = currentVal.toLocaleString() + suffix;

                    if (progress < 1) {
                        requestAnimationFrame(updateCount);
                    } else {
                        el.textContent = targetNum.toLocaleString() + suffix;
                    }
                }

                requestAnimationFrame(updateCount);
                obs.unobserve(el);
            });
        }, { threshold: 0.3 });

        counters.forEach((c) => observer.observe(c));
    }

    // =========================================================================
    // 3. Scroll-Triggered 3D Stagger Entrance
    // =========================================================================
    function initScrollReveal() {
        if (prefersReducedMotion) return;

        const revealCards = document.querySelectorAll(
            ".department-wrap, .how-it-works-card, .staff, .hospital-card, .faq-item, .stat-card, .vc-reveal-3d"
        );

        if (!revealCards.length) return;

        revealCards.forEach((card, idx) => {
            if (!card.classList.contains("vc-reveal-3d")) {
                card.classList.add("vc-reveal-3d");
                const delayMod = (idx % 4) + 1;
                card.classList.add(`vc-delay-${delayMod}`);
            }
        });

        const revealObserver = new IntersectionObserver((entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("vc-in-view");
                    obs.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15, rootMargin: "0px 0px -40px 0px" });

        revealCards.forEach((c) => revealObserver.observe(c));
    }

    // =========================================================================
    // 4. Mobile Navbar Hamburger & Dropdown Engine
    // =========================================================================
    function initMobileNavbar() {
        const toggler = document.querySelector(".vc-hamburger-btn, .navbar-toggler");
        const navCollapse = document.getElementById("ftco-nav");

        if (!toggler || !navCollapse) return;

        toggler.addEventListener("click", function () {
            const isExpanded = this.getAttribute("aria-expanded") === "true";
            this.classList.toggle("active", !isExpanded);
        });

        const navLinks = navCollapse.querySelectorAll(".nav-link:not(.dropdown-toggle)");
        navLinks.forEach((link) => {
            link.addEventListener("click", () => {
                if (window.innerWidth < 992 && $(navCollapse).hasClass("show")) {
                    $(navCollapse).collapse("hide");
                    toggler.classList.remove("active");
                    toggler.setAttribute("aria-expanded", "false");
                }
            });
        });

        document.addEventListener("click", (e) => {
            if (
                window.innerWidth < 992 &&
                $(navCollapse).hasClass("show") &&
                !navCollapse.contains(e.target) &&
                !toggler.contains(e.target)
            ) {
                $(navCollapse).collapse("hide");
                toggler.classList.remove("active");
                toggler.setAttribute("aria-expanded", "false");
            }
        });
    }

    // =========================================================================
    // 5. Dashboard Sidebar Drawer Handler (Parent, Admin, Hospital)
    // =========================================================================
    function initDashboardMobileSidebar() {
        const toggleBtns = document.querySelectorAll("#mobileMenuBtn, #adminSidebarToggle, #sidebarToggle");
        const sidebars = document.querySelectorAll("#dashboardSidebar, #adminSidebar, #hospitalSidebar");
        let overlay = document.getElementById("dashboardOverlay");

        if (!overlay && sidebars.length) {
            overlay = document.createElement("div");
            overlay.className = "dashboard-overlay";
            overlay.id = "dashboardOverlay";
            document.body.appendChild(overlay);
        }

        toggleBtns.forEach((btn) => {
            btn.addEventListener("click", (e) => {
                e.stopPropagation();
                sidebars.forEach((s) => s.classList.toggle("open"));
                if (overlay) overlay.classList.toggle("active");
            });
        });

        if (overlay) {
            overlay.addEventListener("click", () => {
                sidebars.forEach((s) => s.classList.remove("open"));
                overlay.classList.remove("active");
            });
        }
    }

    // Initialize all modules when DOM is ready
    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", () => {
            init3DTiltAndSpotlight();
            initCounterAnimation();
            initScrollReveal();
            initMobileNavbar();
            initDashboardMobileSidebar();
        });
    } else {
        init3DTiltAndSpotlight();
        initCounterAnimation();
        initScrollReveal();
        initMobileNavbar();
        initDashboardMobileSidebar();
    }
})();
