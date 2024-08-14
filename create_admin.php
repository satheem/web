<?php
// Include your database configuration file
include('config.php');

// SQL Query to delete the existing admin user
$sql_delete = "DELETE FROM users WHERE username = 'admin'";

if ($conn->query($sql_delete) === TRUE) {
    echo "Existing admin user deleted successfully";

    // Now insert the new admin user
    $hashed_password = password_hash('admin_password', PASSWORD_DEFAULT);
    $sql_insert = "INSERT INTO users (username, password, role) VALUES ('admin', '$hashed_password', 'admin')";
    
    if ($conn->query($sql_insert) === TRUE) {
        echo "New admin user created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
} else {
    echo "Error deleting admin user: " . $conn->error;
}
$hashed_password = password_hash('admin_password', PASSWORD_DEFAULT);
$sql_insert = "INSERT INTO users (username, password, role) VALUES ('admin', '$hashed_password', 'admin')";

// Close the database connection
$conn->close();
?>
