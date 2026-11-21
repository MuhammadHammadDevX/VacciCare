document.addEventListener("DOMContentLoaded", function () {

    const hospitalSelect = document.getElementById("hospital_id");
    const vaccineSelect = document.getElementById("hospital_vaccine_id");

    const dateInput = document.getElementById("request_date");

    const form = document.getElementById("hospitalRequestForm");
    const submitButton = document.getElementById("submitRequestBtn");


    /* =====================================================
       AVAILABLE VACCINES FROM PHP
    ===================================================== */

    const vaccines = window.hospitalVaccines || [];


    /* =====================================================
       SET MINIMUM DATE = TODAY
    ===================================================== */

    if (dateInput) {

        const today = new Date();

        const year = today.getFullYear();

        const month = String(
            today.getMonth() + 1
        ).padStart(2, "0");

        const day = String(
            today.getDate()
        ).padStart(2, "0");

        dateInput.min = `${year}-${month}-${day}`;
    }


    /* =====================================================
       HOSPITAL CHANGE
    ===================================================== */

    if (hospitalSelect && vaccineSelect) {

        hospitalSelect.addEventListener("change", function () {

            const hospitalId = this.value;


            vaccineSelect.innerHTML = "";


            if (!hospitalId) {

                vaccineSelect.disabled = true;

                vaccineSelect.innerHTML = `
                    <option value="">
                        Select Hospital First
                    </option>
                `;

                return;
            }


            const defaultOption = document.createElement("option");

            defaultOption.value = "";

            defaultOption.textContent =
                "Select Available Vaccine";

            vaccineSelect.appendChild(defaultOption);


            const hospitalVaccines = vaccines.filter(function (vaccine) {

                return String(vaccine.hospital_id) ===
                    String(hospitalId);

            });


            if (hospitalVaccines.length === 0) {

                vaccineSelect.disabled = true;

                const option = document.createElement("option");

                option.value = "";

                option.textContent =
                    "No vaccines available";

                vaccineSelect.appendChild(option);

                return;
            }


            vaccineSelect.disabled = false;


            hospitalVaccines.forEach(function (vaccine) {

                const option =
                    document.createElement("option");

                option.value = vaccine.id;

                option.textContent =
                    vaccine.vaccine_name;

                vaccineSelect.appendChild(option);

            });

        });

    }


    /* =====================================================
       FORM SUBMIT LOADING
    ===================================================== */

    if (form && submitButton) {

        form.addEventListener("submit", function (event) {

            if (!form.checkValidity()) {

                event.preventDefault();

                form.reportValidity();

                return;
            }


            submitButton.disabled = true;


            submitButton.innerHTML = `
                <i class="bi bi-arrow-repeat"></i>
                Submitting Request...
            `;

        });

    }

});