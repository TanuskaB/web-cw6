<?php
require "db.php";

$statusType = "";
$message = "";
$formData = [
    "emp_name" => "",
    "job_name" => "",
    "salary" => "",
    "hire_date" => "",
    "department_id" => "",
    "department_name" => "",
];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($formData as $field => $value) {
        $formData[$field] = trim($_POST[$field] ?? "");
    }

    $name = $formData["emp_name"];
    $job = $formData["job_name"];
    $salaryInput = $formData["salary"];
    $hireDate = $formData["hire_date"];
    $departmentIdInput = $formData["department_id"];
    $departmentName = $formData["department_name"];

    $parsedHireDate = DateTime::createFromFormat("Y-m-d", $hireDate);

    if (
        $name === "" ||
        $job === "" ||
        $salaryInput === "" ||
        $hireDate === "" ||
        $departmentIdInput === "" ||
        $departmentName === ""
    ) {
        $statusType = "error";
        $message = "Please complete every field before submitting the form.";
    } elseif (!is_numeric($salaryInput) || (float)$salaryInput < 0) {
        $statusType = "error";
        $message = "Salary must be a valid non-negative number.";
    } elseif ($parsedHireDate === false || $parsedHireDate->format("Y-m-d") !== $hireDate) {
        $statusType = "error";
        $message = "Hire date must be a valid date.";
    } elseif (filter_var($departmentIdInput, FILTER_VALIDATE_INT) === false) {
        $statusType = "error";
        $message = "Department ID must be a whole number.";
    } else {
        $salary = (float)$salaryInput;
        $departmentId = (int)$departmentIdInput;

        $stmt = $conn->prepare(
            "INSERT INTO employees (emp_name, job_name, salary, hire_date, department_id, department_name)
             VALUES (?, ?, ?, ?, ?, ?)"
        );

        if ($stmt === false) {
            $statusType = "error";
            $message = "Unable to prepare the insert statement: " . $conn->error;
        } else {
            $stmt->bind_param("ssdsis", $name, $job, $salary, $hireDate, $departmentId, $departmentName);

            if ($stmt->execute()) {
                $statusType = "success";
                $message = "Employee record saved successfully. You can view it on the records page.";
                foreach ($formData as $field => $value) {
                    $formData[$field] = "";
                }
            } else {
                $statusType = "error";
                $message = "Unable to save the employee record: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Demo Form</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
    <main class="demo-shell">
        <section class="demo-wrap">
            <div class="demo-hero">
                <p class="demo-eyebrow">Employee Database Demo</p>
                <h1 class="demo-title">Add a new employee record</h1>
                <p class="demo-subtitle">
                    Submit employee information through this form and store it safely in MySQL using PHP and a prepared statement.
                </p>
            </div>

            <div class="demo-card">
                <h2 class="demo-section-title">Employee details</h2>
                <p class="demo-section-copy">All fields are required. Numeric values are validated before the record is inserted.</p>

                <?php if ($message !== ""): ?>
                    <div class="demo-msg <?= htmlspecialchars($statusType) ?>" role="status" aria-live="polite">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <form method="post" action="employee_demo.php" class="demo-form">
                    <div class="demo-grid">
                        <div class="demo-field">
                            <label class="demo-label" for="emp_name">Employee Name</label>
                            <input
                                class="demo-input"
                                id="emp_name"
                                name="emp_name"
                                type="text"
                                value="<?= htmlspecialchars($formData["emp_name"]) ?>"
                                placeholder="Enter full name"
                                required
                            >
                        </div>

                        <div class="demo-field">
                            <label class="demo-label" for="job_name">Job Title</label>
                            <input
                                class="demo-input"
                                id="job_name"
                                name="job_name"
                                type="text"
                                value="<?= htmlspecialchars($formData["job_name"]) ?>"
                                placeholder="Enter job title"
                                required
                            >
                        </div>

                        <div class="demo-field">
                            <label class="demo-label" for="salary">Salary</label>
                            <input
                                class="demo-input"
                                id="salary"
                                name="salary"
                                type="number"
                                min="0"
                                step="0.01"
                                value="<?= htmlspecialchars($formData["salary"]) ?>"
                                placeholder="50000.00"
                                required
                            >
                        </div>

                        <div class="demo-field">
                            <label class="demo-label" for="hire_date">Hire Date</label>
                            <input
                                class="demo-input"
                                id="hire_date"
                                name="hire_date"
                                type="date"
                                value="<?= htmlspecialchars($formData["hire_date"]) ?>"
                                required
                            >
                        </div>

                        <div class="demo-field">
                            <label class="demo-label" for="department_id">Department ID</label>
                            <input
                                class="demo-input"
                                id="department_id"
                                name="department_id"
                                type="number"
                                step="1"
                                value="<?= htmlspecialchars($formData["department_id"]) ?>"
                                placeholder="101"
                                required
                            >
                        </div>

                        <div class="demo-field">
                            <label class="demo-label" for="department_name">Department Name</label>
                            <input
                                class="demo-input"
                                id="department_name"
                                name="department_name"
                                type="text"
                                value="<?= htmlspecialchars($formData["department_name"]) ?>"
                                placeholder="Human Resources"
                                required
                            >
                        </div>
                    </div>

                    <div class="demo-actions">
                        <button class="demo-btn" type="submit">Save Employee</button>
                        <a class="demo-btn demo-btn-secondary" href="read_employees.php">View Stored Records</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
