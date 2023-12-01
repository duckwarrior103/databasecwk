<?php 

    require_once("config.inc.php");

    if ($_SERVER["REQUEST_METHOD"] === "POST") {


    $employeeID = isset($_POST['employeeID']) ? $_POST['employeeID'] : null;

        if ($employeeID !== null) {
            // Prepare a SQL statement to select the employee with the given ID
            $stmt = $conn->prepare("SELECT * FROM Employee WHERE EmployeeID = :employeeID");

            // Bind parameters
            $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_INT);

            // Execute the statement
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Employee found, you can display or process the data
                
                // save Name Entry
                $employeeID = $result['EmployeeID'];
                $NameEntryID = $result['NameEntryID'];
                $EmergencyEntryID = $result['EmergencyEntryID'];
                $LocationID = $result['LocationID'];
                $stmt = $conn->prepare("SELECT * FROM EmergencyContactEntry WHERE EmergencyEntryID = :EmergencyEntryID");
                $stmt->bindParam(':EmergencyEntryID', $EmergencyEntryID, PDO::PARAM_INT);
                $stmt->execute();
                $emergencyentry = $stmt->fetch(PDO::FETCH_ASSOC);
                $emergencyNameEntryID = $emergencyentry['NameEntryID'];

                $stmt = $conn->prepare("DELETE FROM Employee WHERE EmployeeID = :employeeID");

                // Bind parameters
                $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_INT);
        
                // Execute the statement
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM NameEntry WHERE NameEntryID = :NameEntryID");
                //Delete name
                // Bind parameters
                $stmt->bindParam(':NameEntryID', $NameEntryID, PDO::PARAM_INT);
        
                // Execute the statement
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM `Location` WHERE LocationID = :LocationID");
                //Delete name
                // Bind parameters
                $stmt->bindParam(':LocationID', $LocationID, PDO::PARAM_INT);
        
                // Execute the statement
                $stmt->execute();

                

                $stmt = $conn->prepare("DELETE FROM `EmergencyContactEntry` WHERE EmergencyEntryID = :EmergencyEntryID");
                //Delete name
                // Bind parameters
                $stmt->bindParam(':EmergencyEntryID', $EmergencyEntryID, PDO::PARAM_INT);
        
                // Execute the statement
                $stmt->execute();

                $stmt = $conn->prepare("DELETE FROM `NameEntry` WHERE NameEntryID = :emergencyNameEntryID");
                //Delete name
                // Bind parameters
                $stmt->bindParam(':emergencyNameEntryID', $emergencyNameEntryID, PDO::PARAM_INT);
        
                // Execute the statement
                $stmt->execute();

                echo "Employee Deleted.";

            } else {
                echo "Employee not found.";
            }
    }
}

?>