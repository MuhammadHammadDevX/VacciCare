document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("vaccineSearch");
    const statusFilter = document.getElementById("statusFilter");

    const table = document.getElementById("vaccineTable");
    const noResults = document.getElementById("noResults");

    if (!searchInput || !statusFilter || !table || !noResults) {
        return;
    }

    const rows = table.querySelectorAll("tbody tr");

    function filterVaccines() {

        const searchValue = searchInput.value
            .toLowerCase()
            .trim();

        const statusValue = statusFilter.value
            .toLowerCase();

        let visibleRows = 0;


        rows.forEach(function (row) {

            /*
            --------------------------------------------------------
            Ignore the "No vaccines found" PHP row
            --------------------------------------------------------
            */

            if (!row.dataset.status) {
                return;
            }


            const vaccineText = row.innerText.toLowerCase();

            const rowStatus = row.dataset.status;


            /*
            --------------------------------------------------------
            Search
            --------------------------------------------------------
            */

            const matchesSearch =
                vaccineText.includes(searchValue);


            /*
            --------------------------------------------------------
            Status
            --------------------------------------------------------
            */

            const matchesStatus =
                statusValue === "all" ||
                rowStatus === statusValue;


            /*
            --------------------------------------------------------
            Show / Hide
            --------------------------------------------------------
            */

            if (
                matchesSearch &&
                matchesStatus
            ) {

                row.style.display = "";

                visibleRows++;

            } else {

                row.style.display = "none";

            }

        });


        /*
        ------------------------------------------------------------
        No search/filter result
        ------------------------------------------------------------
        */

        if (visibleRows === 0) {

            noResults.classList.add("show");

        } else {

            noResults.classList.remove("show");

        }

    }


    /*
    ------------------------------------------------------------
    Search
    ------------------------------------------------------------
    */

    searchInput.addEventListener(
        "input",
        filterVaccines
    );


    /*
    ------------------------------------------------------------
    Status Filter
    ------------------------------------------------------------
    */

    statusFilter.addEventListener(
        "change",
        filterVaccines
    );

});