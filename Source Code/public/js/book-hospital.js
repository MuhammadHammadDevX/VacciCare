document.addEventListener("DOMContentLoaded", function () {

    /* =====================================================
       ELEMENTS
    ====================================================== */

    const form = document.getElementById("hospitalBookingForm");
    const successBox = document.getElementById("bookingSuccess");
    const closeSuccess = document.getElementById("closeSuccess");
    const appointmentDate = document.getElementById("appointmentDate");
    const hospitalSelect = document.getElementById("hospital");
    const locationSelect = document.getElementById("location");
    const bookButton = document.getElementById("bookAppointmentBtn");


    /* =====================================================
       SET MINIMUM DATE = TODAY
    ====================================================== */

    if (appointmentDate) {

        const today = new Date();

        const year = today.getFullYear();

        const month = String(today.getMonth() + 1).padStart(2, "0");

        const day = String(today.getDate()).padStart(2, "0");

        appointmentDate.min = `${year}-${month}-${day}`;
    }


    /* =====================================================
       HOSPITAL -> LOCATION
       Frontend only
    ====================================================== */

    const hospitalLocations = {

        "Aga Khan University Hospital": "Karachi, Sindh",
        "Indus Hospital & Health Network": "Karachi, Sindh",
        "South City Hospital": "Karachi, Sindh",
        "Liaquat National Hospital": "Karachi, Sindh",
        "Patel Hospital": "Karachi, Sindh",
        "Jinnah Postgraduate Medical Centre": "Karachi, Sindh",
        "Civil Hospital Karachi": "Karachi, Sindh",
        "National Medical Centre": "Karachi, Sindh",
        "Ziauddin Hospital Clifton": "Karachi, Sindh",
        "Ziauddin Hospital North Nazimabad": "Karachi, Sindh",
        "Dow University Hospital": "Karachi, Sindh",
        "Memon Medical Institute Hospital": "Karachi, Sindh",

        "Shaukat Khanum Memorial Cancer Hospital": "Lahore, Punjab",
        "Doctors Hospital & Medical Center": "Lahore, Punjab",
        "Hameed Latif Hospital": "Lahore, Punjab",
        "National Hospital & Medical Centre": "Lahore, Punjab",
        "Ittefaq Hospital": "Lahore, Punjab",
        "Lahore General Hospital": "Lahore, Punjab",
        "Services Hospital Lahore": "Lahore, Punjab",
        "Jinnah Hospital Lahore": "Lahore, Punjab",
        "Fatima Memorial Hospital": "Lahore, Punjab",

        "Shifa International Hospital": "Islamabad, ICT",
        "Pakistan Institute of Medical Sciences (PIMS)": "Islamabad, ICT",
        "Quaid-e-Azam International Hospital": "Islamabad, ICT",
        "Kulsum International Hospital": "Islamabad, ICT",
        "Ali Medical Centre": "Islamabad, ICT",
        "Islamabad Diagnostic Centre": "Islamabad, ICT",
        "Federal Government Polyclinic": "Islamabad, ICT",

        "Benazir Bhutto Hospital": "Rawalpindi, Punjab",
        "Holy Family Hospital": "Rawalpindi, Punjab",
        "Fauji Foundation Hospital": "Rawalpindi, Punjab",
        "Bahria International Hospital Rawalpindi": "Rawalpindi, Punjab",

        "Northwest General Hospital": "Peshawar, Khyber Pakhtunkhwa",
        "Rehman Medical Institute": "Peshawar, Khyber Pakhtunkhwa",
        "Hayatabad Medical Complex": "Peshawar, Khyber Pakhtunkhwa",
        "Lady Reading Hospital": "Peshawar, Khyber Pakhtunkhwa",
        "Khyber Teaching Hospital": "Peshawar, Khyber Pakhtunkhwa",

        "Nishtar Hospital": "Multan, Punjab",
        "Mukhtar A Sheikh Hospital": "Multan, Punjab",
        "Ibn-e-Siena Hospital": "Multan, Punjab",

        "Allied Hospital Faisalabad": "Faisalabad, Punjab",
        "District Headquarters Hospital Faisalabad": "Faisalabad, Punjab",
        "Aziz Fatimah Hospital": "Faisalabad, Punjab",
        "Faisalabad International Hospital": "Faisalabad, Punjab",

        "Liaquat University Hospital": "Hyderabad, Sindh",
        "Isra University Hospital": "Hyderabad, Sindh",

        "Bolan Medical Complex Hospital": "Quetta, Balochistan",
        "Civil Hospital Quetta": "Quetta, Balochistan",
        "Sheikh Khalifa Bin Zayed Hospital": "Quetta, Balochistan",

        "DHQ Hospital Sialkot": "Sialkot, Punjab",
        "DHQ Hospital Gujranwala": "Gujranwala, Punjab",
        "Combined Military Hospital Sialkot": "Sialkot, Punjab",
        "Combined Military Hospital Abbottabad": "Abbottabad, Khyber Pakhtunkhwa",
        "Ayub Teaching Hospital Abbottabad": "Abbottabad, Khyber Pakhtunkhwa",
        "DHQ Hospital Bahawalpur": "Bahawalpur, Punjab",
        "Bahawal Victoria Hospital": "Bahawalpur, Punjab",
        "DHQ Hospital Sargodha": "Sargodha, Punjab"
    };


    if (hospitalSelect && locationSelect) {

        hospitalSelect.addEventListener("change", function () {

            const selectedHospital = this.value;

            const location = hospitalLocations[selectedHospital];

            if (location) {

                locationSelect.value = location;

            }

        });

    }


    /* =====================================================
       FORM SUBMIT
       FRONTEND ONLY
    ====================================================== */

    if (form) {

        form.addEventListener("submit", function (event) {

            event.preventDefault();

            if (!form.checkValidity()) {

                form.classList.add("was-validated");

                return;
            }


            /* Button loading state */

            const originalHTML = bookButton.innerHTML;

            bookButton.disabled = true;

            bookButton.innerHTML = `
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true">
                </span>

                <span>Processing...</span>
            `;


            setTimeout(function () {

                bookButton.disabled = false;

                bookButton.innerHTML = originalHTML;

                successBox.classList.add("show");

                successBox.scrollIntoView({
                    behavior: "smooth",
                    block: "center"
                });

            }, 900);

        });

    }


    /* =====================================================
       CLOSE SUCCESS
    ====================================================== */

    if (closeSuccess) {

        closeSuccess.addEventListener("click", function () {

            successBox.classList.remove("show");

        });

    }


    /* =====================================================
       MOBILE SIDEBAR
    ====================================================== */

    const sidebarToggle = document.getElementById("sidebarToggle");

    const sidebar = document.getElementById("dashboardSidebar");


    if (sidebarToggle && sidebar) {

        sidebarToggle.addEventListener("click", function () {

            sidebar.classList.toggle("active");

        });

    }


    /* =====================================================
       CLOSE SIDEBAR ON OUTSIDE CLICK
    ====================================================== */

    document.addEventListener("click", function (event) {

        if (!sidebar || !sidebar.classList.contains("active")) {
            return;
        }

        if (
            !sidebar.contains(event.target) &&
            !sidebarToggle.contains(event.target)
        ) {

            sidebar.classList.remove("active");

        }

    });

});