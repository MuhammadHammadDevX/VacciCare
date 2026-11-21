

form.addEventListener("submit", function (event) {

    clearAllErrors();

    let isValid = true;


    /* Hospital Name */

    if (hospitalName.value.trim() === "") {

        showError(
            hospitalName,
            "hospitalNameError",
            "Please enter hospital name."
        );

        isValid = false;

    } else {

        clearError(
            hospitalName,
            "hospitalNameError"
        );
    }


    /* Hospital Type */

    if (hospitalType.value === "") {

        showError(
            hospitalType,
            "hospitalTypeError",
            "Please select hospital type."
        );

        isValid = false;

    } else {

        clearError(
            hospitalType,
            "hospitalTypeError"
        );
    }


    /* Email */

    if (hospitalEmail.value.trim() === "") {

        showError(
            hospitalEmail,
            "hospitalEmailError",
            "Please enter hospital email."
        );

        isValid = false;

    } else if (!isValidEmail(hospitalEmail.value.trim())) {

        showError(
            hospitalEmail,
            "hospitalEmailError",
            "Please enter a valid email address."
        );

        isValid = false;

    } else {

        clearError(
            hospitalEmail,
            "hospitalEmailError"
        );
    }


    /* Phone */

    if (hospitalPhone.value.trim() === "") {

        showError(
            hospitalPhone,
            "hospitalPhoneError",
            "Please enter phone number."
        );

        isValid = false;

    } else if (!isValidPhone(hospitalPhone.value.trim())) {

        showError(
            hospitalPhone,
            "hospitalPhoneError",
            "Enter a valid Pakistani mobile number."
        );

        isValid = false;

    } else {

        clearError(
            hospitalPhone,
            "hospitalPhoneError"
        );
    }


    /* Address */

    if (hospitalAddress.value.trim() === "") {

        showError(
            hospitalAddress,
            "hospitalAddressError",
            "Please enter hospital address."
        );

        isValid = false;

    } else {

        clearError(
            hospitalAddress,
            "hospitalAddressError"
        );
    }


    /* City */

    if (hospitalCity.value === "") {

        showError(
            hospitalCity,
            "hospitalCityError",
            "Please select city."
        );

        isValid = false;

    } else {

        clearError(
            hospitalCity,
            "hospitalCityError"
        );
    }


    /* Province */

    if (hospitalProvince.value === "") {

        showError(
            hospitalProvince,
            "hospitalProvinceError",
            "Please select province."
        );

        isValid = false;

    } else {

        clearError(
            hospitalProvince,
            "hospitalProvinceError"
        );
    }


    /* Password */

    if (password.value === "") {

        showError(
            password,
            "hospitalPasswordError",
            "Please create a password."
        );

        isValid = false;

    } else if (password.value.length < 8) {

        showError(
            password,
            "hospitalPasswordError",
            "Password must contain at least 8 characters."
        );

        isValid = false;

    } else {

        clearError(
            password,
            "hospitalPasswordError"
        );
    }


    /* Confirm Password */

    if (confirmPassword.value === "") {

        showError(
            confirmPassword,
            "confirmPasswordError",
            "Please confirm your password."
        );

        isValid = false;

    } else if (confirmPassword.value !== password.value) {

        showError(
            confirmPassword,
            "confirmPasswordError",
            "Passwords do not match."
        );

        isValid = false;

    } else {

        clearError(
            confirmPassword,
            "confirmPasswordError"
        );
    }


    /* Terms */

    if (!termsCheck.checked) {

        document.getElementById("termsError").textContent =
            "Please accept the Terms & Conditions.";

        isValid = false;

    } else {

        document.getElementById("termsError").textContent = "";
    }


    /* =====================================
       INVALID FORM
    ===================================== */

    if (!isValid) {

        event.preventDefault();

        const firstError =
            document.querySelector(".input-error");

        if (firstError) {

            firstError.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

            firstError.focus();
        }

        return;
    }


    /* =====================================
       VALID FORM
       ALLOW PHP SUBMISSION
    ===================================== */

    registerBtn.disabled = true;

    registerBtn.innerHTML = `
        <i class="bi bi-hourglass-split"></i>
        Creating Account...
    `;

});