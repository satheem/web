<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

$host = 'localhost'; // Your database host
$db = 'school';      // Your database name
$user = 'root';      // Your database username
$pass = '';          // Your database password

// Create connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get student ID from query string
if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("DELETE FROM students WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);

    if ($stmt->execute()) {
        // Redirect to the admin page after successful deletion
        header('Location: admin_grade_6_A.php');
        exit();
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>Student ID not provided.</p>";
}

$conn->close();
?>
