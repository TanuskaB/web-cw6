<?php
require "db.php";

$employees = [];
$errorMessage = "";

$result = $conn->query(
    "SELECT emp_name, job_name, salary, hire_date, department_id, department_name
     FROM employees
     ORDER BY hire_date DESC, emp_name ASC"
);

if ($result === false) {
    $errorMessage = "Unable to load employee records: " . $conn->error;
} else {
    while ($row = $result->fetch_assoc()) {
        $employees[] = $row;
    }
    $result->free();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Records</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
    <main class="demo-shell">
        <section class="demo-wrap">
            <div class="demo-hero">
                <p class="demo-eyebrow">Employee Database Demo</p>
                <h1 class="demo-title">Stored employee records</h1>
                <p class="demo-subtitle">
                    Use this page to verify that submitted employee information was written to the database.
                </p>
            </div>

            <div class="demo-card">
                <div class="demo-actions demo-actions-top">
                    <a class="demo-btn demo-btn-secondary" href="employee_demo.php">Back to Employee Form</a>
                </div>

                <?php if ($errorMessage !== ""): ?>
                    <div class="demo-msg error" role="alert">
                        <?= htmlspecialchars($errorMessage) ?>
                    </div>
                <?php elseif (count($employees) === 0): ?>
                    <div class="demo-msg">
                        No employee records are available yet. Submit the form to add one.
                    </div>
                <?php else: ?>
                    <div class="demo-table-wrap">
                        <table class="demo-table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Job Title</th>
                                    <th>Salary</th>
                                    <th>Hire Date</th>
                                    <th>Department ID</th>
                                    <th>Department Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($employee["emp_name"]) ?></td>
                                        <td><?= htmlspecialchars($employee["job_name"]) ?></td>
                                        <td>$<?= htmlspecialchars(number_format((float)$employee["salary"], 2)) ?></td>
                                        <td><?= htmlspecialchars($employee["hire_date"]) ?></td>
                                        <td><?= htmlspecialchars($employee["department_id"]) ?></td>
                                        <td><?= htmlspecialchars($employee["department_name"]) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>
</body>
</html>
