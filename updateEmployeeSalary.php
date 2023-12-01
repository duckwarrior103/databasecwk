<?php
    require_once("config.inc.php");
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
        } catch (PDOException $e) {
            die ("Error updating salary");
        }
            
    }
    else {
        die("need to fill in employeeID");
    }
    if (isset($_POST['employeeSalaryInput']) && $_POST['employeeSalaryInput'] != NULL){
        $newSalary = $_POST['employeeSalaryInput']; 
    }
    else {
        die("need to input salary");
    }
    

try {
    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE Employee SET salary = :newSalary WHERE EmployeeID = :employeeID");

    // Bind parameters
    $stmt->bindParam(':newSalary', $newSalary, PDO::PARAM_INT);
    $stmt->bindParam(':employeeID', $employeeID, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    echo "Salary updated successfully!";
} catch (PDOException $e) {
    die("Error updating salary");
}
?>