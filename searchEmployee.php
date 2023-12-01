<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
</head>
<body>
<?php
    require_once("config.inc.php");

    $employeeTable = 'Employee';
    $emergencyContactTable = 'EmergencyContactEntry';

    // Your values for the conditions
    if (isset($_POST['employeeCategory']) && $_POST['employeeCategory']!= NULL){
        $departmentIDValue = $_POST['employeeCategory'];
    }
    else{
        die("Please select Department/Employee Category.");
    }
    if (isset($_POST['employeeEmergencyContactRelationship']) && $_POST['employeeEmergencyContactRelationship']!= NULL){
        $relationshipValue = $_POST['employeeEmergencyContactRelationship'];
    }
    else{
        die("Please select emergency contact relationship value");
    }

    try {
        // Construct the SQL query with placeholders
        $sql = "
            SELECT $employeeTable.*
            FROM $employeeTable
            JOIN $emergencyContactTable ON $employeeTable.EmergencyEntryID = $emergencyContactTable.EmergencyEntryID
            WHERE $emergencyContactTable.Relationship = :relationship
            AND $employeeTable.DepartmentID = :departmentID
        ";

        // Prepare the SQL query
        $stmt = $conn->prepare($sql);

        // Bind the parameters
        $stmt->bindParam(':relationship', $relationshipValue, PDO::PARAM_STR);
        $stmt->bindParam(':departmentID', $departmentIDValue, PDO::PARAM_INT);

        // Execute the query
        $stmt->execute();

        // Fetch the results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h1>Employee Results</h1>";
        $number = 1;
        // Process the results as needed
        foreach ($results as $row) {
            // employee first name, last name relationship, name of manager 
            $NameEntryID = $row['NameEntryID'];
            $stmt = $conn->prepare("SELECT * FROM NameEntry WHERE NameEntryID = :NameEntryID");

            // Bind the parameter
            $stmt->bindParam(':NameEntryID', $NameEntryID, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result as an associative array
            $EmployeeNameresult = $stmt->fetch(PDO::FETCH_ASSOC);
            // get department name 
            $DepartmentID = $row['DepartmentID'];
            $stmt = $conn->prepare("SELECT * FROM Department WHERE DepartmentID = :DepartmentID");

            // Bind the parameter
            $stmt->bindParam(':DepartmentID', $DepartmentID, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result as an associative array
            $DepartmentIDResult = $stmt->fetch(PDO::FETCH_ASSOC);

            $EmergencyEntryID = $row['EmergencyEntryID'];
            $stmt = $conn->prepare("SELECT * FROM EmergencyContactEntry WHERE EmergencyEntryID = :EmergencyEntryID");

            // Bind the parameter
            $stmt->bindParam(':EmergencyEntryID', $EmergencyEntryID, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();
            $EmergencyEntryResult = $stmt->fetch(PDO::FETCH_ASSOC);

            $ManagerID = $row['ManagerID'];
            $stmt = $conn->prepare("SELECT * FROM Employee WHERE EmployeeID = :ManagerID");

            // Bind the parameter
            $stmt->bindParam(':ManagerID', $ManagerID, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();
            $ManagerResult = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($ManagerResult){
                $ManagerNameEntryID = $ManagerResult['NameEntryID'];
            }   
            $stmt = $conn->prepare("SELECT * FROM NameEntry WHERE NameEntryID = :ManagerNameEntryID");

            // Bind the parameter
            $stmt->bindParam(':ManagerNameEntryID', $ManagerNameEntryID, PDO::PARAM_INT);

            // Execute the query
            $stmt->execute();

            // Fetch the result as an associative array
            $ManagerNameResult = $stmt->fetch(PDO::FETCH_ASSOC);


            echo "<h4>Result " . $number . "</h2>";
            echo "<ul>";
            echo "<li>Employee Name: " . $EmployeeNameresult['FirstName'] . " " . $EmployeeNameresult['LastName'] . "</li>";
            echo "<li>Department: " . $DepartmentIDResult['Name'] . "</li>";
            echo "<li>Emergency Contact Relationship: " . $EmergencyEntryResult['Relationship'] . "</li>";
            echo "<li>Manager Name: " . $ManagerNameResult['FirstName'] . " " . $ManagerNameResult['LastName'] . "</li>";
            echo "</ul>";
            $number += 1; 



            //print_r($row);
        }
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }

    // Close the connection
    $conn = null;
    ?>

    <a href="filterEmployee.html">Search again</a>
</body>
</html>



