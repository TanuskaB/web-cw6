<?php
// db.php — Include this file at the top of every CRUD script
$host = "localhost";
$user = "tbiswakarma1";   // Your GSU username
$pass = "tbiswakarma1";   // Your MySQL password
$db   = "tbiswakarma1";            // DB name for this class

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("DB Error: " . $conn->connect_error);
}

if (basename(__FILE__) === basename($_SERVER["SCRIPT_FILENAME"] ?? "")) {
    echo "Connection successful";
    echo " | Server: " . htmlspecialchars($conn->server_info);
    $conn->close();
}
// $conn is now available in any file that requires this
