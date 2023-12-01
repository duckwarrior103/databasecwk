<?php

    require_once("config.inc.php");
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        try {
            
            if (isset($_POST['employeeFirstNameInput']) && $_POST['employeeFirstNameInput'] != NULL) {
                $firstName = filter_var($_POST['employeeFirstNameInput'], FILTER_SANITIZE_STRING);
            } 
            else {die("Need to input first name") ;} 
            // Insert into NameEntry and get the lastInsertId
            if (isset($_POST['employeeMiddleNameInput'])) {
                if ($_POST['employeeMiddleNameInput'] != NULL){
                    $middleName = $_POST['employeeMiddleNameInput'];
                }
                else{$middleName = NULL;}
                }  
            if (isset($_POST['employeeLastNameInput']) && $_POST['employeeLastNameInput'] != NULL) {
                $lastName = filter_var($_POST['employeeLastNameInput'], FILTER_SANITIZE_STRING);
            } 
            else {die("Need to input last name") ;} 
            if (isset($_POST['employeePreferredNameInput'])) {
                if ($_POST['employeePreferredNameInput'] != NULL){
                    $preferredName = $_POST['employeePreferredNameInput'];
                }
                else{$preferredName = NULL;}
                }  

            // Create a prepared statement
            $stmt = $conn->prepare("INSERT INTO NameEntry (FirstName, MiddleName, LastName, PreferredName) VALUES (:firstName, :middleName, :lastName, :preferredName)");

            // Bind parameters
            $stmt->bindParam(':firstName', $firstName, PDO::PARAM_STR);  // these are to be treated like a string
            $stmt->bindParam(':middleName', $middleName, PDO::PARAM_STR);
            $stmt->bindParam(':lastName', $lastName, PDO::PARAM_STR);
            $stmt->bindParam(':preferredName', $preferredName, PDO::PARAM_STR);

                // Execute the statement
            $stmt->execute();

            $lastInsertNameEntryId = $conn->lastInsertId();


            // insert into emergency contact details, and also emergency contact name into name entry table 
            if (isset($_POST['employeeEmergencyContactFirstName']) && $_POST['employeeEmergencyContactFirstName'] != NULL) {
                $emergencyContactFirstName = filter_var($_POST['employeeEmergencyContactFirstName'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input first name");} 
            if (isset($_POST['employeeEmergencyMiddleName'])) {
                if ($_POST['employeeEmergencyMiddleName'] != NULL){
                    $emergencyContactMiddleName = $_POST['employeeEmergencyMiddleName'];
                }
                else{$emergencyContactMiddleName = NULL;}
                } 
            else {die( "Need to input middle name");} 
            if (isset($_POST['employeeEmergencyContactLastName']) && $_POST['employeeEmergencyContactLastName'] != NULL) {
                $emergencyContactLastName = filter_var($_POST['employeeEmergencyContactLastName'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input last name");} 


            // Create a prepared statement
            $stmt = $conn->prepare("INSERT INTO NameEntry (FirstName, MiddleName, LastName, PreferredName) VALUES (:emergencyContactFirstName, :emergencyContactMiddleName, :emergencyContactLastName, NULL)");

            // Bind parameters
            $stmt->bindParam(':emergencyContactFirstName', $emergencyContactFirstName, PDO::PARAM_STR);  // these are to be treated like a string
            $stmt->bindParam(':emergencyContactMiddleName', $emergencyContactMiddleName, PDO::PARAM_STR);
            $stmt->bindParam(':emergencyContactLastName', $emergencyContactLastName, PDO::PARAM_STR);

                // Execute the statement
            $stmt->execute();

            $lastInsertEmergencyContactNameEntryId = $conn->lastInsertId();
            
            if (isset($_POST['employeeEmergencyContactRelationship']) && $_POST['employeeEmergencyContactRelationship'] != NULL) {
                $relationship = filter_var($_POST['employeeEmergencyContactRelationship'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input relationship");} 

            if (isset($_POST['employeeEmergencyContactPhoneNumber']) && $_POST['employeeEmergencyContactPhoneNumber'] != NULL) {
                $phoneNumber = $_POST['employeeEmergencyContactPhoneNumber'];
            } 
            else {die( "Need to input phone number");} 
            //$phoneNumber = 999;
            // Create a prepared statement
            $stmt = $conn->prepare("INSERT INTO EmergencyContactEntry (NameEntryID, Relationship, PhoneNumber) VALUES (:lastInsertEmergencyContactNameEntryId, :relationship, :phoneNumber)");
        
            // Bind parameters
            $stmt->bindParam(':lastInsertEmergencyContactNameEntryId', $lastInsertEmergencyContactNameEntryId, PDO::PARAM_INT);
            $stmt->bindParam(':relationship', $relationship, PDO::PARAM_STR);
            $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_INT);
        
            // Execute the statement
            $stmt->execute();
        
            // Get the last inserted ID
            $lastInsertEmergencyContactId = $conn->lastInsertId();
            
            // insert into city look up 
            // insert into addresses 

            if (isset($_POST['employeeStreetName']) && $_POST['employeeStreetName'] != NULL) {
                $streetName = filter_var($_POST['employeeStreetName'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input street name.");} 

            if (isset($_POST['employeePostCode']) && $_POST['employeePostCode'] != NULL) {
                $postCode = filter_var($_POST['employeePostCode'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input post code");} 
            if (isset($_POST['employeeCity']) && $_POST['employeeCity'] != NULL) {
                $cityName = filter_var($_POST['employeeCity'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input city name.");} 

        
            // Create a prepared statement
            $stmt = $conn->prepare("INSERT INTO Location (StreetName, PostCode, CityName) VALUES (:streetName, :postCode, :cityName)");
        
            // Bind parameters
            $stmt->bindParam(':streetName', $streetName, PDO::PARAM_STR);
            $stmt->bindParam(':postCode', $postCode, PDO::PARAM_STR);
            $stmt->bindParam(':cityName', $cityName, PDO::PARAM_STR);
        
            // Execute the statement
            $stmt->execute();
            $lastInsertLocationId = $conn->lastInsertId();


            // departmentID shld have all the positions avaialable 
            // managerID should be manager's employee ID 
            if (isset($_POST['employeeIDInput']) && $_POST['employeeIDInput'] != NULL){
                $employeeID = $_POST['employeeIDInput'];
                $stmt = $conn->prepare("SELECT * FROM Employee WHERE EmployeeID = :employeeID");
                $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    die("Employee ID is not unique. Choose a different one.") ;
                }
            }
            else { die ("need to input employee id");}

                // Example values for Employee
            if (isset($_POST['employeeSalaryInput']) && $_POST['employeeSalaryInput'] != NULL) {
                $salary = filter_var($_POST['employeeSalaryInput'], FILTER_VALIDATE_INT);
            } 
            else {die( "Need to input salary.");} 
            if (isset($_POST['employeeDOBInput']) && $_POST['employeeDOBInput'] != NULL) {
                $dateOfBirth = filter_var($_POST['employeeDOBInput'], FILTER_SANITIZE_STRING);
            } 
            else {die( "Need to input DOB.");} 
            if (isset($_POST['employeeNINInput']) && $_POST['employeeNINInput'] != NULL) {
                $NIN = filter_var($_POST['employeeNINInput'], FILTER_VALIDATE_INT);
            } 
            else {die( "Need to input NIN.");} 
            
            if (isset($_POST['employeeCategory']) && $_POST['employeeCategory'] != NULL) {
                $departmentID = filter_var($_POST['employeeCategory'], FILTER_VALIDATE_INT);
            } 
            else {die( "Need to input employee category.");} 
            if (isset($_POST['employeeManagerID']) && $_POST['employeeManagerID'] != NULL) {
                $managerID = filter_var($_POST['employeeManagerID'], FILTER_VALIDATE_INT);
            } 
            else {die( "Need to input employee manager ID.");} 
            
           

            //$employeeID = 123; 
            //$salary = 1000;
            // $dateOfBirth ='2003-02-01';
            // $NIN = 1999;
            // $departmentID = 1;
            // $managerID = 12;
            // Insert into Employee using last inserted IDs
            $stmt = $conn->prepare("INSERT INTO Employee (EmployeeID, NameEntryID, LocationID, Salary, DateOfBirth, NIN, DepartmentID, ManagerID, EmergencyEntryID) VALUES (:employeeID, :nameEntryID, :locationID, :salary, :dateOfBirth, :NIN, :departmentID, :managerID, :emergencyEntryID)");
            $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_INT);
            $stmt->bindParam(':nameEntryID', $lastInsertNameEntryId, PDO::PARAM_INT);
            $stmt->bindParam(':locationID', $lastInsertLocationId, PDO::PARAM_INT);
            $stmt->bindParam(':salary', $salary, PDO::PARAM_INT);
            $stmt->bindParam(':dateOfBirth', $dateOfBirth, PDO::PARAM_STR);
            $stmt->bindParam(':NIN', $NIN, PDO::PARAM_INT);
            $stmt->bindParam(':departmentID', $departmentID, PDO::PARAM_INT);
            $stmt->bindParam(':managerID', $managerID, PDO::PARAM_INT);
            $stmt->bindParam(':emergencyEntryID', $lastInsertEmergencyContactId, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();



            // if departmentID == e.g. Driver (2)
            // we need to insert into the Driver specific table

                // employeeID: same value 
                // working hours: 
                // others: NULL 

        } catch (PDOException $e) {
            echo "Error adding employee: " . $e->getMessage();
        }
    }
    else{
        echo "Error: Form not submitted using POST method.";
    }

	// Close the database connection
	$conn = null;
?>

