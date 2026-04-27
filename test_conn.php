<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "tbiswakarma1";
$pass = "tbiswakarma1";
$db   = "tbiswakarma1";  // Use myDB

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo htmlspecialchars("Connection successful");
echo htmlspecialchars(" | Server: " . $conn->server_info);
$conn->close();
