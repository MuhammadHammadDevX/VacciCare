/* =========================================================
   VACCARE — PARENT PROFILE JS
========================================================= */

document.addEventListener("DOMContentLoaded", function () {


    /* =====================================================
       MOBILE SIDEBAR
    ====================================================== */

    const mobileMenuBtn =
        document.getElementById("mobileMenuBtn");

    const sidebar =
        document.getElementById("dashboardSidebar");

    const overlay =
        document.getElementById("dashboardOverlay");


    if (mobileMenuBtn && sidebar) {

        mobileMenuBtn.addEventListener("click", function () {

            sidebar.classList.toggle("open");

            if (overlay) {

                overlay.classList.toggle(
                    "active"
                );

            }

        });

    }


    if (overlay && sidebar) {

        overlay.addEventListener("click", function () {

            sidebar.classList.remove("open");

            overlay.classList.remove("active");

        });

    }



    /* =====================================================
       PROFILE IMAGE PREVIEW
    ====================================================== */

    const imageInput =
        document.getElementById("profileImageInput");

    const profilePreview =
        document.getElementById("profilePreview");


    if (imageInput && profilePreview) {

        imageInput.addEventListener(
            "change",
            function (event) {

                const file =
                    event.target.files[0];


                if (!file) {
                    return;
                }


                /* Validate image */

                if (!file.type.startsWith("image/")) {

                    alert(
                        "Please select a valid image file."
                    );

                    imageInput.value = "";

                    return;

                }


                /* File size: maximum 5MB */

                if (file.size > 5 * 1024 * 1024) {

                    alert(
                        "Profile image must be less than 5MB."
                    );

                    imageInput.value = "";

                    return;

                }


                /* Preview */

                const reader =
                    new FileReader();


                reader.onload =
                    function (e) {

                        profilePreview.src =
                            e.target.result;

                    };


                reader.readAsDataURL(file);

            }
        );

    }



    /* =====================================================
       FORM RESET
    ====================================================== */


    if (profileForm) {

        profileForm.addEventListener(
            "reset",
            function () {

                setTimeout(function () {

                    if (profilePreview) {

                        profilePreview.src =
                            profilePreview.dataset.original ||
                            "images/profile/default-profile.png";

                    }

                }, 10);

            }
        );

    }


});








/* =====================================================
   FORM RESET + PASSWORD VALIDATION
===================================================== */

const profileForm =
    document.getElementById("profileForm");

const newPassword =
    document.getElementById("newPassword");

const confirmPassword =
    document.getElementById("confirmPassword");


if (profileForm) {

    profileForm.addEventListener(
        "reset",
        function () {

            setTimeout(function () {

                if (profilePreview) {

                    profilePreview.src =
                        profilePreview.dataset.original ||
                        "images/profile/default-profile.png";

                }

            }, 10);

        }
    );


    /* =================================================
       PASSWORD MATCH
    ================================================== */

    profileForm.addEventListener(
        "submit",
        function (event) {

            if (
                newPassword &&
                confirmPassword &&
                newPassword.value !== ""
            ) {

                if (
                    newPassword.value !==
                    confirmPassword.value
                ) {

                    event.preventDefault();

                    alert(
                        "New password and confirm password do not match."
                    );

                    confirmPassword.focus();

                    return;
                }


                if (
                    newPassword.value.length < 8
                ) {

                    event.preventDefault();

                    alert(
                        "Password must be at least 8 characters."
                    );

                    newPassword.focus();

                    return;
                }

            }

        }
    );

}