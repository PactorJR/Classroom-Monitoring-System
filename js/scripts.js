/*!
    * Start Bootstrap - SB Admin v7.0.7 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2023 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

function toggleSectionInput() {
    var userTypeSelect = document.getElementById("user_type");
    var sectionFieldsDiv = document.getElementById("sectionFields");
    var yearFieldsDiv = document.getElementById("yearFields");
    var sectionFieldsInput = document.getElementById("section");
    var yearFieldsInput = document.getElementById("year");

    if (userTypeSelect.value === "Student") {
        sectionFieldsDiv.style.display = "block";
        yearFieldsDiv.style.display = "block";
        sectionFieldsInput.disabled = false;
        yearFieldsInput.disabled = false;
    } else {
        sectionFieldsDiv.style.display = "none";
        yearFieldsDiv.style.display = "none";
        sectionFieldsInput.value = "";
        sectionFieldsInput.disabled = true;
        yearFieldsInput.value = "";
        yearFieldsInput.disabled = true;
    }
}

function validatePassword() {
    var password = document.getElementById("inputPassword").value;
    var confirmPassword = document.getElementById("inputPasswordConfirm").value;
    var errorMessage = document.getElementById("error-message");

    if (password !== confirmPassword && confirmPassword == "") {
        errorMessage.style.display = "block";
    } else {
        errorMessage.style.display = "none";
    }
}


window.onload = function() {
    toggleSectionInput();
}


