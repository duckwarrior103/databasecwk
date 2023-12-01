function emplopyeeFirstNameForm(event) {
    event.preventDefault();
    alert("Updating employee first name");
}

function employeeMiddleNameForm(event) {
    event.preventDefault();
    alert("Updating employee middle name");
}

function employeeLastNameForm(event) {
    event.preventDefault();
    alert("Updating employee last name");
}

function employeePreferredNameForm(event) {
    event.preventDefault();
    alert("Updating employee preferred name");
}

function employeeDOBForm(event) {
    event.preventDefault();
    alert("Updating employee date of birth");
}

function employeeSalaryForm(event) {
    event.preventDefault();
    var employeeIDvalue = document.getElementById("employeeIDInput").value;
    var formData = new FormData(document.getElementById("employeeSalaryForm"));
    formData.append("employeeIDInput", employeeIDvalue);
    var error = document.getElementById("employeeSalaryFormerror");
    // AJAX code to send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "updateEmployeeSalary.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server
            console.log(xhr.responseText);
            error.innerHTML = xhr.responseText
        }   
    };
    xhr.send(formData);
    alert("Updating employee salary");
}

function employeeNINForm(event) {
    event.preventDefault();
    alert("Updating employee NIN");
}

function employeeStreetNameForm(event) {
    event.preventDefault();
    alert("Updating employee address line 1");
}

function employeePostCodeForm(event) {
    event.preventDefault();
    alert("Updating employee post code");
}

function employeeCityForm(event) {
    event.preventDefault();
    alert("Updating employee city");
}

function employeeCountryForm(event) {
    event.preventDefault();
    alert("Updating employee country");
}

function employeeEmergencyContactFirstNameForm(event) {
    event.preventDefault();
    alert("Updating emergency contact first name");
}

function employeeEmergencyMiddleNameForm(event) {
    event.preventDefault();
    alert("Updating emergency contact middle name");
}

function employeeEmergencyContactLastNameForm(event) {
    event.preventDefault();
    alert("Updating emergency contact last name");
}

function employeeEmergencyContactRelationshipForm(event) {
    event.preventDefault();
    alert("Updating emergency contact relationship");
}
/////
function employeeEmergencyContactPhoneNumberForm(event) {
    event.preventDefault();
    var employeeIDvalue = document.getElementById("employeeIDInput").value;
    var formData = new FormData(document.getElementById("employeeEmergencyContactPhoneNumberForm"));
    formData.append("employeeIDInput", employeeIDvalue);
    var error = document.getElementById("employeeEmergencyContactPhoneNumberFormerror");
    // AJAX code to send data to the server
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "updateEmployeeEmergencyContactPhoneNumber.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            // Handle the response from the server
            console.log(xhr.responseText);
            error.innerHTML = xhr.responseText
        }   
    };
    xhr.send(formData);
    alert("Updating emergency contact phone number");
}

function employeeCategoryForm(event) {
    event.preventDefault();
    alert("Updating employee category");
}

function employeeManagerIDForm(event) {
    event.preventDefault();
    alert("Updating employee manager ID");
}