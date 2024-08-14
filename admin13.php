<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade-13 Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
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
        .grade-links {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* 2 items per line */
            gap: 20px;
            justify-content: center;
        }
        .grade-link {
            background: #f0f4f8;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .grade-link a {
            color: #0056b3;
            text-decoration: none;
            font-weight: 700;
            font-size: 1.5em; /* Large text */
        }
        .logout-link {
            display: block;
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
        <h2>Grade-13 Admin Dashboard</h2>
        <div class="grade-links">
            <!-- Grade 13 Streams -->
            <?php foreach (['Bio Science', 'Physical Science', 'E-Tech', 'Bio Tech', 'Commerce', 'Arts'] as $stream): ?>
                <div class="grade-link">
                    <a href="admin_grade_13_<?php echo strtolower(str_replace(' ', '_', $stream)); ?>.php">Grade 13 <?php echo $stream; ?></a>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="logout-link">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
