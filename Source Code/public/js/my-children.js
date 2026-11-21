document.addEventListener("DOMContentLoaded", function () {

    console.log("my-children.js loaded successfully");


    /* =====================================================
       ELEMENTS
    ===================================================== */

    const modal = document.getElementById("childModal");

    const addChildBtn = document.getElementById("addChildBtn");
    const addCardBtn = document.getElementById("addCardBtn");

    const closeModalBtn = document.getElementById("closeModal");
    const cancelModalBtn = document.getElementById("cancelModal");

    const childForm = document.getElementById("childForm");

    const childAction = document.getElementById("childAction");
    const childIdField = document.getElementById("childIdField");

    const childName = document.getElementById("childName");
    const childDob = document.getElementById("childDob");
    const childGender = document.getElementById("childGender");
    const bloodGroup = document.getElementById("bloodGroup");
    const childContact = document.getElementById("childContact");
    const childNotes = document.getElementById("childNotes");

    const modalTitle = document.getElementById("modalTitle");
    const modalDescription = document.getElementById("modalDescription");
    const modalIcon = document.getElementById("modalIcon");

    const saveChildText = document.getElementById("saveChildText");
    const saveChildIcon = document.getElementById("saveChildIcon");

    const deleteChildForm = document.getElementById("deleteChildForm");
    const deleteChildId = document.getElementById("deleteChildId");


    /* =====================================================
       BASIC CHECK
    ===================================================== */

    if (!modal) {
        console.error("childModal not found.");
        return;
    }

    if (!childForm) {
        console.error("childForm not found.");
        return;
    }


    /* =====================================================
       OPEN ADD CHILD MODAL
    ===================================================== */

    function openAddModal() {

        console.log("Opening Add Child modal");

        // Reset form
        childForm.reset();

        // Set action to ADD
        if (childAction) {
            childAction.value = "add";
        }

        // Clear child ID
        if (childIdField) {
            childIdField.value = "";
        }

        // Change modal title
        if (modalTitle) {
            modalTitle.textContent = "Add New Child";
        }

        if (modalDescription) {
            modalDescription.textContent =
                "Enter your child's basic information";
        }

        // Change button text
        if (saveChildText) {
            saveChildText.textContent = "Add Child";
        }

        // Change icon
        if (saveChildIcon) {
            saveChildIcon.className = "bi bi-check-lg";
        }

        if (modalIcon) {
            modalIcon.className = "bi bi-person-plus-fill";
        }

        // Show modal
        modal.classList.add("show");

        document.body.style.overflow = "hidden";

        // Focus name field
        setTimeout(function () {

            if (childName) {
                childName.focus();
            }

        }, 150);
    }


    /* =====================================================
       OPEN EDIT CHILD MODAL
    ===================================================== */

    function openEditModal(button) {

        console.log("Opening Edit Child modal");

        if (!button) {
            return;
        }


        /* =================================================
           GET DATA FROM EDIT BUTTON
        ================================================= */

        const id =
            button.getAttribute("data-child-id") || "";

        const name =
            button.getAttribute("data-child-name") || "";

        const dob =
            button.getAttribute("data-child-dob") || "";

        const gender =
            button.getAttribute("data-child-gender") || "";

        const blood =
            button.getAttribute("data-child-blood") || "";

        const contact =
            button.getAttribute("data-child-contact") || "";

        const notes =
            button.getAttribute("data-child-notes") || "";


        console.log("Editing child ID:", id);


        /* =================================================
           CHECK CHILD ID
        ================================================= */

        if (!id) {

            alert(
                "Child ID is missing. Please refresh the page and try again."
            );

            return;
        }


        /* =================================================
           SET ACTION = UPDATE
        ================================================= */

        if (childAction) {
            childAction.value = "update";
        }


        /* =================================================
           SET CHILD ID
        ================================================= */

        if (childIdField) {
            childIdField.value = id;
        }


        /* =================================================
           PUT CHILD DATA INTO FORM
        ================================================= */

        if (childName) {
            childName.value = name;
        }

        if (childDob) {
            childDob.value = dob;
        }

        if (childGender) {
            childGender.value = gender;
        }

        if (bloodGroup) {
            bloodGroup.value = blood;
        }

        if (childContact) {
            childContact.value = contact;
        }

        if (childNotes) {
            childNotes.value = notes;
        }


        /* =================================================
           CHANGE MODAL CONTENT
        ================================================= */

        if (modalTitle) {
            modalTitle.textContent = "Edit Child Details";
        }

        if (modalDescription) {
            modalDescription.textContent =
                "Update your child's information";
        }

        if (saveChildText) {
            saveChildText.textContent = "Update Child";
        }

        if (saveChildIcon) {
            saveChildIcon.className = "bi bi-check-lg";
        }

        if (modalIcon) {
            modalIcon.className = "bi bi-pencil-square";
        }


        /* =================================================
           SHOW MODAL
        ================================================= */

        modal.classList.add("show");

        document.body.style.overflow = "hidden";


        /* =================================================
           FOCUS NAME FIELD
        ================================================= */

        setTimeout(function () {

            if (childName) {
                childName.focus();
            }

        }, 150);
    }


    /* =====================================================
       CLOSE MODAL
    ===================================================== */

    function closeChildModal() {

        console.log("Closing child modal");

        modal.classList.remove("show");

        document.body.style.overflow = "";

        childForm.reset();

        // Default action back to ADD
        if (childAction) {
            childAction.value = "add";
        }

        // Clear child ID
        if (childIdField) {
            childIdField.value = "";
        }
    }


    /* =====================================================
       ADD CHILD TOP BUTTON
    ===================================================== */

    if (addChildBtn) {

        addChildBtn.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                openAddModal();

            }
        );
    }


    /* =====================================================
       ADD CHILD CARD BUTTON
    ===================================================== */

    if (addCardBtn) {

        addCardBtn.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                openAddModal();

            }
        );
    }


    /* =====================================================
       EDIT BUTTON
    ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const editButton =
                event.target.closest(".edit-child-btn");


            if (!editButton) {
                return;
            }


            event.preventDefault();

            openEditModal(editButton);

        }
    );


    /* =====================================================
       DELETE BUTTON
    ===================================================== */

    document.addEventListener(
        "click",
        function (event) {

            const deleteButton =
                event.target.closest(".delete-child-btn");


            if (!deleteButton) {
                return;
            }


            event.preventDefault();


            const id =
                deleteButton.getAttribute(
                    "data-child-id"
                ) || "";


            const name =
                deleteButton.getAttribute(
                    "data-child-name"
                ) || "this child";


            /* ---------------------------------------------
               CHECK ID
            --------------------------------------------- */

            if (!id) {

                alert(
                    "Invalid child. Please refresh the page and try again."
                );

                return;
            }


            /* ---------------------------------------------
               CONFIRM DELETE
            --------------------------------------------- */

            const confirmDelete =
                confirm(
                    'Are you sure you want to delete "' +
                    name +
                    '"?'
                );


            if (!confirmDelete) {
                return;
            }


            /* ---------------------------------------------
               SET CHILD ID
            --------------------------------------------- */

            if (deleteChildId) {
                deleteChildId.value = id;
            }


            /* ---------------------------------------------
               SUBMIT DELETE FORM
            --------------------------------------------- */

            if (deleteChildForm) {
                deleteChildForm.submit();
            }

        }
    );


    /* =====================================================
       CLOSE BUTTON
    ===================================================== */

    if (closeModalBtn) {

        closeModalBtn.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                closeChildModal();

            }
        );
    }


    /* =====================================================
       CANCEL BUTTON
    ===================================================== */

    if (cancelModalBtn) {

        cancelModalBtn.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                closeChildModal();

            }
        );
    }


    /* =====================================================
       CLICK OUTSIDE MODAL
    ===================================================== */

    modal.addEventListener(
        "click",
        function (event) {

            if (event.target === modal) {

                closeChildModal();

            }

        }
    );


    /* =====================================================
       ESC KEY
    ===================================================== */

    document.addEventListener(
        "keydown",
        function (event) {

            if (
                event.key === "Escape" &&
                modal.classList.contains("show")
            ) {

                closeChildModal();

            }

        }
    );


    /* =====================================================
       FORM SUBMIT VALIDATION
       
       IMPORTANT:
       JS DATABASE UPDATE NAHI KARTA.
       
       JS:
       - validation karega
       - form PHP ko submit karega
       
       PHP:
       ADD    -> INSERT
       UPDATE -> UPDATE
    ===================================================== */

    childForm.addEventListener(
        "submit",
        function (event) {


            /* ---------------------------------------------
               GET FORM VALUES
            --------------------------------------------- */

            const name =
                childName
                    ? childName.value.trim()
                    : "";


            const dob =
                childDob
                    ? childDob.value
                    : "";


            const gender =
                childGender
                    ? childGender.value
                    : "";


            const contact =
                childContact
                    ? childContact.value.trim()
                    : "";


            const action =
                childAction
                    ? childAction.value
                    : "add";


            const childId =
                childIdField
                    ? childIdField.value
                    : "";


            /* ---------------------------------------------
               REQUIRED FIELDS
            --------------------------------------------- */

            if (!name || !dob || !gender) {

                event.preventDefault();

                alert(
                    "Please fill in all required fields."
                );

                return;
            }


            /* ---------------------------------------------
               UPDATE MUST HAVE CHILD ID
            --------------------------------------------- */

            if (
                action === "update" &&
                !childId
            ) {

                event.preventDefault();

                alert(
                    "Child ID is missing. Please open Edit again."
                );

                return;
            }


            /* ---------------------------------------------
               DATE VALIDATION
            --------------------------------------------- */

            const selectedDate =
                new Date(dob + "T00:00:00");


            const today =
                new Date();


            today.setHours(
                0,
                0,
                0,
                0
            );


            if (selectedDate > today) {

                event.preventDefault();

                alert(
                    "Date of birth cannot be in the future."
                );

                return;
            }


            /* ---------------------------------------------
               CONTACT VALIDATION
            --------------------------------------------- */

            if (contact !== "") {

                const contactPattern =
                    /^[0-9+\-\s()]+$/;


                if (
                    !contactPattern.test(contact)
                ) {

                    event.preventDefault();

                    alert(
                        "Please enter a valid contact number."
                    );

                    return;
                }
            }


            /* ---------------------------------------------
               IMPORTANT
               
               Yahan preventDefault() nahi hai.
               
               Isliye form normally PHP ko submit hoga.
               
               ADD:
               child_action = add
               
               UPDATE:
               child_action = update
               child_id = selected child ID
            --------------------------------------------- */

            console.log(
                "Form submitting to PHP:",
                action
            );

        }
    );


    /* =====================================================
       INITIALIZED
    ===================================================== */

    console.log(
        "My Children page JavaScript initialized successfully."
    );

});