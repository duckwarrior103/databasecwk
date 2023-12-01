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
    $relationshipValue = 'awefeaw';
    $departmentIDValue = 1;

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
        // Process the results as needed
        foreach ($results as $row) {
            echo "<ul>";
            echo "<li>ID: " . $row['EmployeeID'] . "</li>";
            echo "<li>Salary: " . $row['Salary'] . "</li>";
            echo "</ul>";




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



