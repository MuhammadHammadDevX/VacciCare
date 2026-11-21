document.addEventListener("DOMContentLoaded", function () {

    const searchInput =
        document.getElementById("hospitalSearch");

    const cityFilter =
        document.getElementById("cityFilter");

    const statusFilter =
        document.getElementById("statusFilter");

    const rows =
        document.querySelectorAll(".hospital-row");

    const emptyState =
        document.getElementById("hospitalEmpty");

    const visibleCount =
        document.getElementById("visibleCount");


    /* =====================================================
       FILTER FUNCTION
    ====================================================== */

    function filterHospitals() {

        const searchValue =
            searchInput.value
                .toLowerCase()
                .trim();

        const selectedCity =
            cityFilter.value;

        const selectedStatus =
            statusFilter.value;

        let count = 0;


        rows.forEach(function (row) {

            const searchData =
                row.dataset.search
                    .toLowerCase();

            const city =
                row.dataset.city;

            const status =
                row.dataset.status;


            const matchesSearch =
                searchValue === "" ||
                searchData.includes(searchValue);


            const matchesCity =
                selectedCity === "" ||
                city === selectedCity;


            const matchesStatus =
                selectedStatus === "" ||
                status === selectedStatus;


            if (
                matchesSearch &&
                matchesCity &&
                matchesStatus
            ) {

                row.style.display = "";

                count++;

            } else {

                row.style.display = "none";

            }

        });


        visibleCount.textContent = count;


        if (count === 0) {

            emptyState.classList.add("show");

        } else {

            emptyState.classList.remove("show");

        }

    }


    /* =====================================================
       SEARCH
    ====================================================== */

    searchInput.addEventListener(
        "input",
        filterHospitals
    );


    /* =====================================================
       CITY FILTER
    ====================================================== */

    cityFilter.addEventListener(
        "change",
        filterHospitals
    );


    /* =====================================================
       STATUS FILTER
    ====================================================== */

    statusFilter.addEventListener(
        "change",
        filterHospitals
    );

});