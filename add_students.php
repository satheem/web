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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $student_id = $_POST['student_id'];
    $full_name = $_POST['full_name'];
    $date_of_birth = $_POST['date_of_birth'];
    $grade = $_POST['grade'];
    $section = $_POST['section'];
    $address = $_POST['address'];
    $guardian_name = $_POST['guardian_name'];
    $phone_no = $_POST['phone_no'];
    $whatsapp_no = $_POST['whatsapp_no'];
    $email = $_POST['email'];

    // Handle file upload
    $photo_path = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photo_tmp_name = $_FILES['photo']['tmp_name'];
        $photo_name = basename($_FILES['photo']['name']);
        $photo_path = 'uploads/' . $photo_name;
        move_uploaded_file($photo_tmp_name, $photo_path);
    }

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO students (student_id, full_name, date_of_birth, grade, section, address, guardian_name, phone_no, whatsapp_no, email, photo_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $student_id, $full_name, $date_of_birth, $grade, $section, $address, $guardian_name, $phone_no, $whatsapp_no, $email, $photo_path);

    if ($stmt->execute()) {
        echo "<p>Student added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .form-group input[type="file"] {
            padding: 0;
        }
        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            text-align: center;
            background: #007bff;
            color: white;
            font-size: 1.2em;
            text-decoration: none;
            border-radius: 5px;
        }
        .button:hover {
            background: #0056b3;
        }
        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1em;
            text-align: center;
        }
        .back-button:hover {
            background: #5a6268;
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
    <script>
        function updateSections() {
            const grade = document.getElementById('grade').value;
            const section = document.getElementById('section');
            
            // Clear current options    #0056b3
            section.innerHTML = '';
            
            let options;
            if (grade >= 6 && grade <= 11) {
                options = ['A', 'B', 'C', 'D'];
            } else if (grade == 12 || grade == 13) {
                options = ['Bio Science', 'Physical Science', 'Engineering Technology', 'Bio System Technology', 'Arts', 'Commerce'];
            }
            
            // Populate dropdown
            if (options) {
                options.forEach(opt => {
                    const option = document.createElement('option');
                    option.value = opt;
                    option.textContent = opt;
                    section.appendChild(option);
                });
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <a href="admin_grade_6_A.php" class="back-button">Back to Admin Grade 6 A</a>
        <img src="img/logo3.png" alt="School Logo" class="logo">
        <h2>Add Student</h2>
        <form action="add_students.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="student_id">Student ID:</label>
                <input type="text" id="student_id" name="student_id" required>
            </div>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" id="full_name" name="full_name" required>
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="form-group">
                <label for="grade">Grade:</label>
                <select id="grade" name="grade" required onchange="updateSections()">
                    <option value="">Select Grade</option>
                    <?php for ($i = 6; $i <= 13; $i++): ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="section">Section/Stream:</label>
                <select id="section" name="section" required>
                    <option value="">Select Section</option>
                </select>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>
            </div>
            <div class="form-group">
                <label for="guardian_name">Guardian Name:</label>
                <input type="text" id="guardian_name" name="guardian_name" required>
            </div>
            <div class="form-group">
                <label for="phone_no">Phone No:</label>
                <input type="text" id="phone_no" name="phone_no" required>
            </div>
            <div class="form-group">
                <label for="whatsapp_no">WhatsApp No:</label>
                <input type="text" id="whatsapp_no" name="whatsapp_no">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo:</label>
                <input type="file" id="photo" name="photo">
            </div>
            <button type="submit" class="button">Add Student</button>
        </form>
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
