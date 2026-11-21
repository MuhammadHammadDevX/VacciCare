/* =========================================================
   VACCICARE ADMIN LOGIN
   Frontend Validation + PHP Backend Authentication
========================================================= */

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("adminLoginForm");

    const emailInput = document.getElementById("adminEmail");
    const passwordInput = document.getElementById("adminPassword");

    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    const passwordToggle = document.getElementById("passwordToggle");
    const eyeIcon = document.getElementById("eyeIcon");


    /* =====================================================
       PASSWORD SHOW / HIDE
    ===================================================== */

    if (passwordToggle && passwordInput && eyeIcon) {

        passwordToggle.addEventListener("click", function () {

            if (passwordInput.type === "password") {

                passwordInput.type = "text";

                passwordToggle.setAttribute(
                    "aria-label",
                    "Hide password"
                );

                eyeIcon.innerHTML = `
                    <path d="M3 3l18 18"/>
                    <path d="M10.6 10.6a2 2 0 0 0 2.8 2.8"/>
                    <path d="M9.9 5.3A10.8 10.8 0 0 1 12 5
                             c6.5 0 10 7 10 7
                             a18.3 18.3 0 0 1-3.1 3.9"/>
                    <path d="M6.6 6.6C3.7 8.4 2 12 2 12
                             s3.5 7 10 7
                             c1.5 0 2.8-.3 4-.8"/>
                `;

            } else {

                passwordInput.type = "password";

                passwordToggle.setAttribute(
                    "aria-label",
                    "Show password"
                );

                eyeIcon.innerHTML = `
                    <path d="M2 12s3.5-6 10-6
                             10 6 10 6-3.5 6-10 6S2 12 2 12z"/>
                    <circle cx="12" cy="12" r="2.5"/>
                `;
            }

        });

    }


    /* =====================================================
       REMOVE EMAIL ERROR WHEN USER TYPES
    ===================================================== */

    if (emailInput) {

        emailInput.addEventListener("input", function () {

            clearError(
                emailInput,
                emailError
            );

        });

    }


    /* =====================================================
       REMOVE PASSWORD ERROR WHEN USER TYPES
    ===================================================== */

    if (passwordInput) {

        passwordInput.addEventListener("input", function () {

            clearError(
                passwordInput,
                passwordError
            );

        });

    }


    /* =====================================================
       FORM VALIDATION
    ===================================================== */

    if (form) {

        form.addEventListener("submit", function (event) {

            let valid = true;

            const email = emailInput.value.trim();
            const password = passwordInput.value;


            /* =================================================
               EMAIL VALIDATION
            ================================================= */

            if (email === "") {

                showError(
                    emailInput,
                    emailError,
                    "Please enter your admin email."
                );

                valid = false;

            } else if (!isValidEmail(email)) {

                showError(
                    emailInput,
                    emailError,
                    "Please enter a valid email address."
                );

                valid = false;

            }


            /* =================================================
               PASSWORD VALIDATION
            ================================================= */

            if (password === "") {

                showError(
                    passwordInput,
                    passwordError,
                    "Please enter your password."
                );

                valid = false;

            } else if (password.length < 6) {

                showError(
                    passwordInput,
                    passwordError,
                    "Password must contain at least 6 characters."
                );

                valid = false;

            }


            /* =================================================
               STOP FORM IF VALIDATION FAILS
            ================================================= */

            if (!valid) {

                event.preventDefault();

                return;

            }


            /* =================================================
               VALIDATION SUCCESSFUL
               
               Form will now submit normally to:
               admin-login.php
            ================================================= */

            const button =
                form.querySelector(".login-button");

            const buttonText =
                button.querySelector("span");


            if (button && buttonText) {

                buttonText.textContent = "Signing In...";

                button.disabled = true;

            }

            /*
             * IMPORTANT:
             * event.preventDefault() is NOT used here.
             *
             * Therefore PHP receives the form data.
             */

        });

    }


    /* =====================================================
       EMAIL VALIDATION FUNCTION
    ===================================================== */

    function isValidEmail(email) {

        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    }


    /* =====================================================
       SHOW ERROR
    ===================================================== */

    function showError(
        input,
        errorElement,
        message
    ) {

        const wrapper =
            input.closest(".input-wrapper");

        if (wrapper) {

            wrapper.classList.add("invalid");

        }

        if (errorElement) {

            errorElement.textContent = message;

        }

    }


    /* =====================================================
       CLEAR ERROR
    ===================================================== */

    function clearError(
        input,
        errorElement
    ) {

        const wrapper =
            input.closest(".input-wrapper");

        if (wrapper) {

            wrapper.classList.remove("invalid");

        }

        if (errorElement) {

            errorElement.textContent = "";

        }

    }

});