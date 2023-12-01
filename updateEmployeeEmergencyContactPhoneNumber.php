<?php
    require_once("config.inc.php");
    echo "hi";
    if (isset($_POST['employeeIDInput']) && $_POST['employeeIDInput'] != NULL){
        $employeeID = $_POST['employeeIDInput']; 
        try{
            $stmt = $conn->prepare("SELECT * FROM Employee WHERE EmployeeID = :employeeID");

            // Bind parameters
            $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {die("employee not found");}
            else{
                $emergencyentryid = $result['EmergencyEntryID'];
            }
        } catch (PDOException $e) {
            die ("Error updating emergency contact phone number");
        }
            
    }
    else {
        die("need to fill in employeeID");
    }
    if (isset($_POST['employeeEmergencyContactPhoneNumber']) && $_POST['employeeEmergencyContactPhoneNumber'] != NULL){
        $phoneNumber = $_POST['employeeEmergencyContactPhoneNumber']; 
    }
    else {
        die("need to input salary");
    }
    


try {
    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE EmergencyContactEntry SET PhoneNumber = :phoneNumber WHERE EmergencyEntryID = :emergencyentryid");

    // Bind parameters
    $stmt->bindParam(':phoneNumber', $phoneNumber, PDO::PARAM_INT);
    $stmt->bindParam(':emergencyentryid', $emergencyentryid, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    echo "Phone Number updated successfully!";
    $conn = NULL;
} catch (PDOException $e) {
    die("Error updating salary");
}
?>