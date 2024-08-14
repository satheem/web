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

// Initialize search variables
$search = '';
if (isset($_POST['search'])) {
    $search = trim($_POST['search']);
}

// Debugging: Check if search variable is being set
// echo "Search Query: " . htmlspecialchars($search);

// Fetch students with search functionality
$sql = "SELECT student_id, full_name, date_of_birth, grade, section, address, guardian_name, phone_no, whatsapp_no, email, photo_path AS photo 
        FROM students 
        WHERE full_name LIKE ? OR student_id LIKE ?";
$search_param = "%$search%";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param('ss', $search_param, $search_param);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }
        .logo {
            display: block;
            max-width: 150px;
            margin: 0 auto 20px;
        }
        h2 {
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .search-box {
            text-align: center;
            margin-bottom: 20px;
        }
        .search-box input[type="text"] {
            width: 100%;
            max-width: 300px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }
        .search-box input[type="submit"] {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            margin-top: 10px;
        }
        .search-box input[type="submit"]:hover {
            background: #0056b3;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 0;
            text-align: center;
            background: #007bff;
            color: white;
            font-size: 1em;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .student-photo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 50%;
        }
        .edit-button {
            display: inline-block;
            padding: 5px 10px;
            font-size: 0.9em;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        .edit-button:hover {
            background: #007bff;
            color: white;
        }
        .logout-link {
            text-align: center;
            margin-top: 20px;
        }
        .logout-link a {
            color: #e74c3c;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.2em;
            transition: color 0.3s ease;
        }
        .logout-link a:hover {
            color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="img/logo3.png" alt="School Logo" class="logo">
        <div class="search-box">
            <form action="admin_grade_6_A.php" method="post">
                <input type="text" name="search" placeholder="Search by student ID or name" value="<?php echo htmlspecialchars($search); ?>">
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="table-container">
            <a href="add_students.php" class="button">Add Student</a>
            <h2>Student List</h2>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Photo</th>
                        <th>Student ID</th>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th>Grade</th>
                        <th>Section</th>
                        <th>Address</th>
                        <th>Guardian Name</th>
                        <th>Phone No</th>
                        <th>WhatsApp No</th>
                        <th>Email</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $serial = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $serial++; ?></td>
                                <td><img src="<?php echo htmlspecialchars($row['photo']); ?>" alt="Student Photo" class="student-photo"></td>
                                <td><?php echo htmlspecialchars($row['student_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_of_birth']); ?></td>
                                <td><?php echo htmlspecialchars($row['grade']); ?></td>
                                <td><?php echo htmlspecialchars($row['section']); ?></td>
                                <td><?php echo htmlspecialchars($row['address']); ?></td>
                                <td><?php echo htmlspecialchars($row['guardian_name']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_no']); ?></td>
                                <td><?php echo htmlspecialchars($row['whatsapp_no']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><a href="edit_student.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="edit-button">Edit</a></td>
                                <td><a href="delete_student.php?student_id=<?php echo urlencode($row['student_id']); ?>" class="edit-button" onclick="return confirm('Are you sure you want to delete this student?');">Delete</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="14">No students found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
<?php
$conn->close();
?>
