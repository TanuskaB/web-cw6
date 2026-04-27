<?php
require "db.php";

// Values to insert (hardcoded for testing)
$name   = "sarah Miller";
$job    = "Designer";
$salary = 91000.00;
$hire   = "2012-05-15";
$deptId = 6;
$department_name = "Design";

$stmt = $conn->prepare(
    "INSERT INTO employees
     (emp_name, job_name, salary, hire_date, department_id, department_name)
     VALUES (?, ?, ?, ?, ?, ?)"
);
$stmt->bind_param("ssdsis", $name, $job, $salary, $hire, $deptId, $department_name);

if ($stmt->execute()) {
    echo htmlspecialchars("Success! Inserted ID: " . $stmt->insert_id);
} else {
    echo htmlspecialchars("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
