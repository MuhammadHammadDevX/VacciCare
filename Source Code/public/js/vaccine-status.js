document.addEventListener("DOMContentLoaded", function () {

    const appointment =
        document.getElementById("appointment");

    const parentName =
        document.getElementById("parentName");

    const childName =
        document.getElementById("childName");

    const vaccineName =
        document.getElementById("vaccineName");

    const appointmentDate =
        document.getElementById("appointmentDate");

    const appointmentTime =
        document.getElementById("appointmentTime");


    function formatDate(value) {

        if (!value) {
            return "";
        }

        const parts = value.split("-");

        if (parts.length !== 3) {
            return value;
        }

        const months = [
            "Jan",
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
            "Nov",
            "Dec"
        ];

        const year = parts[0];
        const month = parseInt(parts[1], 10);
        const day = parts[2];

        return (
            day +
            " " +
            months[month - 1] +
            " " +
            year
        );
    }


    function formatTime(value) {

        if (!value) {
            return "";
        }

        const parts = value.split(":");

        if (parts.length < 2) {
            return value;
        }

        let hour =
            parseInt(parts[0], 10);

        const minute =
            parts[1];

        const period =
            hour >= 12 ? "PM" : "AM";

        hour =
            hour % 12;

        if (hour === 0) {
            hour = 12;
        }

        return (
            String(hour).padStart(2, "0") +
            ":" +
            minute +
            " " +
            period
        );
    }


    function clearFields() {

        parentName.value = "";
        childName.value = "";
        vaccineName.value = "";
        appointmentDate.value = "";
        appointmentTime.value = "";
    }


    if (appointment) {

        appointment.addEventListener(
            "change",
            function () {

                const selected =
                    appointment.options[
                        appointment.selectedIndex
                    ];


                if (
                    !selected ||
                    !selected.value
                ) {

                    clearFields();

                    return;
                }


                parentName.value =
                    selected.dataset.parent || "";

                childName.value =
                    selected.dataset.child || "";

                vaccineName.value =
                    selected.dataset.vaccine || "";

                appointmentDate.value =
                    formatDate(
                        selected.dataset.date || ""
                    );

                appointmentTime.value =
                    formatTime(
                        selected.dataset.time || ""
                    );
            }
        );
    }


    const form =
        document.getElementById("vaccineForm");


    if (form) {

        form.addEventListener(
            "reset",
            function () {

                setTimeout(
                    clearFields,
                    0
                );

            }
        );
    }

});