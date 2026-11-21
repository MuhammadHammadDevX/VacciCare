/* =========================================================
   VACCI CARE
   ADMIN CHILDREN PAGE
   ========================================================= */


/* =========================================================
   DOM READY
   ========================================================= */

document.addEventListener("DOMContentLoaded", function () {


    console.log(
        "Admin Children page loaded successfully."
    );


    /* =====================================================
       VIEW DETAILS BUTTONS
       ===================================================== */

    const viewDetailsButtons =
        document.querySelectorAll(
            ".view-details-btn"
        );


    /*
     * View Details buttons normal <a> links hain.
     *
     * Example:
     *
     * admin-child-details.php?id=12
     *
     * Is liye kisi modal ki zaroorat nahi.
     */


    viewDetailsButtons.forEach(function (button) {


        button.addEventListener(
            "click",
            function (event) {


                const href =
                    button.getAttribute("href");


                /* -----------------------------------------
                   BASIC LINK CHECK
                ----------------------------------------- */

                if (
                    !href ||
                    href.trim() === ""
                ) {

                    event.preventDefault();

                    console.error(
                        "Child details link is missing."
                    );

                    return;

                }


                /*
                 * Normal link ko browser khud open karega.
                 * Yahan preventDefault nahi karna.
                 */


            }
        );


    });


    /* =====================================================
       DELETE / EXTRA MODAL CODE
       NOT REQUIRED ON THIS PAGE
       =====================================================

       Is page par:

       - Add Child modal nahi
       - Edit Child modal nahi
       - Delete functionality nahi
       - Child details modal nahi
       - data-child-name attributes nahi

       Is liye unka JavaScript remove kar diya gaya hai.
    ===================================================== */


    /* =====================================================
       INITIALIZED
       ===================================================== */

    console.log(
        "Admin Children page initialized successfully."
    );


});