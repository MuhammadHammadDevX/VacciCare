document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       SEARCH HOSPITALS
    ===================================================== */

    const hospitalSearch =
        document.getElementById("hospitalSearch");

    const hospitalItems =
        document.querySelectorAll(".registered-hospital");

    const emptyHospitals =
        document.getElementById("emptyHospitals");


    if (hospitalSearch) {

        hospitalSearch.addEventListener("input", function () {

            const searchValue =
                hospitalSearch.value
                    .toLowerCase()
                    .trim();

            let visibleCount = 0;

            hospitalItems.forEach(function (item) {

                const searchData =
                    item.dataset.search
                        .toLowerCase();

                if (searchData.includes(searchValue)) {

                    item.style.display = "";
                    visibleCount++;

                } else {

                    item.style.display = "none";

                }

            });


            if (emptyHospitals) {

                if (visibleCount === 0) {

                    emptyHospitals.classList.add("show");

                } else {

                    emptyHospitals.classList.remove("show");

                }

            }

        });

    }


    /* =====================================================
       IMPORTANT:
       FORM SUBMIT PHP KO HONE DO
    ===================================================== */

    /*
       Yahan event.preventDefault() NAHI lagana.

       Form directly add-hospital.php par POST hoga
       aur PHP database mein hospital insert karega.
    */


});