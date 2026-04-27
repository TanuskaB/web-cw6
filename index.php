<?php
$target = "employee_demo.php";

if (!headers_sent()) {
    header("Location: " . $target);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="0;url=employee_demo.php">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Database Demo</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="demo-page">
    <main class="demo-shell">
        <section class="demo-wrap">
            <div class="demo-card">
                <h1 class="demo-title">Redirecting to the employee form</h1>
                <p class="demo-section-copy">
                    If you are not redirected automatically, use the link below.
                </p>
                <div class="demo-actions">
                    <a class="demo-btn" href="employee_demo.php">Open Employee Form</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
