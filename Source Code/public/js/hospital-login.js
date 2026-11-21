document.addEventListener("DOMContentLoaded", function () {

    /* =========================================
       PASSWORD SHOW / HIDE
    ========================================= */

    const passwordInput =
        document.getElementById("hospitalPassword");

    const passwordToggle =
        document.getElementById("passwordToggle");

    if (passwordToggle && passwordInput) {

        passwordToggle.addEventListener("click", function () {

            if (passwordInput.type === "password") {

                passwordInput.type = "text";

                passwordToggle.innerHTML =
                    '<i class="bi bi-eye-slash"></i>';

                passwordToggle.setAttribute(
                    "aria-label",
                    "Hide password"
                );

            } else {

                passwordInput.type = "password";

                passwordToggle.innerHTML =
                    '<i class="bi bi-eye"></i>';

                passwordToggle.setAttribute(
                    "aria-label",
                    "Show password"
                );
            }

        });


    }

});