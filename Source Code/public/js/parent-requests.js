document.addEventListener("DOMContentLoaded", function () {

    const searchInput = document.getElementById("requestSearch");
    const statusFilter = document.getElementById("statusFilter");
    const hospitalFilter = document.getElementById("hospitalFilter");

    const requestRows = document.querySelectorAll(".request-row");
    const noResults = document.getElementById("noResults");


    function filterRequests() {

        const search = searchInput.value
            .toLowerCase()
            .trim();

        const selectedStatus =
            statusFilter.value.toLowerCase();

        const selectedHospital =
            hospitalFilter.value;


        let visible = 0;


        requestRows.forEach(function (row) {

            const rowText =
                row.innerText.toLowerCase();

            const rowStatus =
                row.dataset.status;

            const rowHospital =
                row.dataset.hospital;


            const matchesSearch =
                rowText.includes(search);


            const matchesStatus =
                selectedStatus === "all" ||
                rowStatus === selectedStatus;


            const matchesHospital =
                selectedHospital === "all" ||
                rowHospital === selectedHospital;


            if (
                matchesSearch &&
                matchesStatus &&
                matchesHospital
            ) {

                row.style.display = "";

                visible++;

            } else {

                row.style.display = "none";

            }

        });


        if (visible === 0) {

            noResults.classList.add("show");

        } else {

            noResults.classList.remove("show");

        }

    }


    /* Search */

    if (searchInput) {

        searchInput.addEventListener(
            "input",
            filterRequests
        );

    }


    /* Status Filter */

    if (statusFilter) {

        statusFilter.addEventListener(
            "change",
            filterRequests
        );

    }


    /* Hospital Filter */

    if (hospitalFilter) {

        hospitalFilter.addEventListener(
            "change",
            filterRequests
        );

    }

});