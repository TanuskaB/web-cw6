<?php
require "db.php";

// Value to delete (example: delete by employee name)
$name = "Sarah Miller";

$stmt = $conn->prepare(
    "DELETE FROM employees WHERE emp_name = ?"
);
$stmt->bind_param("s", $name);

if ($stmt->execute()) {
    if ($stmt->affected_rows == 1) {
        echo htmlspecialchars("Success! Record deleted.");
    } else {
        echo htmlspecialchars("No record found with that name.");
    }
} else {
    echo htmlspecialchars("Error: " . $stmt->error);
}

$stmt->close();
$conn->close();
?>
