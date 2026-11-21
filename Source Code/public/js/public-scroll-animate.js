/**
 * VacciCare – public site scroll animations
 * Auto-applies reveal effects to headings, text, images, cards, buttons.
 */
(function () {
  "use strict";

  if (window.matchMedia("(prefers-reduced-motion: reduce)").matches) {
    return;
  }

  var SKIP_CLOSEST =
    "nav, .navbar, .top, #ftco-loader, script, style, noscript";

  var TARGETS = [
    "h1",
    "h2",
    "h3",
    "h4",
    "h5",
    ".subheading",
    ".heading-section > *",
    ".bread",
    "p",
    "img",
    ".img",
    ".img-wrap",
    ".block-20",
    ".staff",
    ".hospital-card",
    ".department-wrap",
    ".how-it-works-card",
    ".faq-item",
    ".faq-card",
    ".testimony-wrap",
    ".media.block-6",
    ".counter-wrap",
    ".block-18",
    ".contact-form",
    ".map-container",
    ".appointment-form",
    ".appointment-card",
    ".vaccine-detail-card",
    ".dbox",
    ".btn",
    ".ftco-footer-widget",
    ".form-group",
    ".card",
    ".signup-card",
    ".signin-card",
    ".signup-box",
    ".signin-box",
    ".auth-card",
    ".signup-btn",
    ".signin-btn",
    ".benefit",
    ".feature",
    ".form-header",
    ".brand",
  ].join(",");

  function shouldSkip(el) {
    if (!el || el.nodeType !== 1) return true;
    if (el.closest(SKIP_CLOSEST)) return true;
    if (el.classList.contains("vc-reveal")) return true;
    if (el.classList.contains("ftco-animate")) return true;
    if (el.getAttribute("data-vc-no-anim") !== null) return true;
    if (el.matches("p") && (el.textContent || "").trim().length < 2) return true;
    return false;
  }

  function pickEffect(el, index) {
    if (el.matches("img, .img, .img-wrap, .block-20")) return "zoom";
    if (el.matches(".btn")) return "pop";
    if (el.matches("h1, h2, .subheading, .bread")) return "up";
    if (index % 3 === 1) return "left";
    if (index % 3 === 2) return "right";
    return "up";
  }

  function isInView(el) {
    var rect = el.getBoundingClientRect();
    return rect.top < window.innerHeight * 0.94 && rect.bottom > 20;
  }

  function init() {
    var root = document.body;
    var nodes = root.querySelectorAll(TARGETS);
    var observed = [];
    var groupIndex = 0;
    var lastSection = null;

    nodes.forEach(function (el, i) {
      if (shouldSkip(el)) return;

      var section =
        el.closest(
          "section, .ftco-section, .ftco-intro, .ftco-facts, .ftco-footer, footer, .signup-page, .signin-page"
        ) || root;

      if (section !== lastSection) {
        groupIndex = 0;
        lastSection = section;
      }

      var effect = pickEffect(el, i);
      el.classList.add("vc-reveal", "vc-reveal--" + effect);
      el.style.setProperty("--vc-delay", Math.min(groupIndex * 75, 450) + "ms");
      observed.push(el);
      groupIndex += 1;
      if (groupIndex > 7) groupIndex = 0;
    });

    if (!observed.length) return;

    function reveal(el) {
      el.classList.add("vc-reveal-in");
    }

    if (!("IntersectionObserver" in window)) {
      observed.forEach(reveal);
      return;
    }

    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          reveal(entry.target);
          io.unobserve(entry.target);
        });
      },
      {
        threshold: 0.1,
        rootMargin: "0px 0px -6% 0px",
      }
    );

    // Two rAFs so the browser applies opacity:0 before transitioning in
    requestAnimationFrame(function () {
      requestAnimationFrame(function () {
        observed.forEach(function (el) {
          if (isInView(el)) {
            reveal(el);
          } else {
            io.observe(el);
          }
        });
      });
    });
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();
