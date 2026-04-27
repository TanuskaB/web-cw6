<?php
require "db.php";

// Values to update (hardcoded for testing)
$name = "sarah Miller"; 
$job = "Senior Designer";
$salary = 99000.00;
$hire = "2012-01-08";
$deptId = 6;
$department_name = "Design";

$stmt = $conn->prepare(
    "UPDATE employees
     SET job_name = ?, salary = ?, hire_date = ?, department_id = ?, department_name = ?
     WHERE emp_name = ?"
);

$stmt->bind_param("sdsiss", $job, $salary, $hire, $deptId, $department_name, $name);

if ($stmt->execute()) {
    if ($stmt->affected_rows == 1) {
        echo htmlspecialchars("Success! Record updated.");
    } else {
        echo htmlspecialchars("No record found to update.");
    }
} else {
    echo htmlspecialchars("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
