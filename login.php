<?php
session_start();
include('config.php');

// Generate CSRF token and regenerate it on each form load
if ($_SERVER['REQUEST_METHOD'] === 'GET' || empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $csrf_token = $_POST['csrf_token'] ?? '';

    // Validate CSRF token
    if ($csrf_token !== $_SESSION['csrf_token']) {
        die('CSRF token mismatch');
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters (s = string)
    $stmt->bind_param("s", $username);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Fetch the associative array
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Set session variables
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        if ($user['role'] == 'admin') {
            header('Location: admin.php');
        } else {
            header('Location: index.php');
        }
        exit();
    } else {
        $error = "Invalid username or password";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Include Font Awesome for eye icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-jLKHWMzy+HA8psmEvvRk+vcJbF4c62hcw6KCJ9RUL3qNd6iNtrzQ0ZXuEhIhRoxR" crossorigin="anonymous" />
    <script src="https://kit.fontawesome.com/0ca0bd90fd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
        }

        .login-container {
            background: #ffffff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        .login-container img {
            max-width: 150px;
            margin-bottom: 20px;
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-weight: 700;
            color: #333;
        }

        .login-container form {
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .login-container form label {
            text-align: left;
            margin-bottom: 5px;
            font-weight: 400;
            color: #666;
        }

        .login-container form input {
            padding: 10px;
            width: 100%;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .password-container {
            position: relative;
            margin-bottom: 15px;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px; /* Space for the eye icon */
        }

        .password-container .toggle-password {
            position: absolute;
            top: 40%;
            right: -8%;
            padding-right: 0px;
            padding-right: 0px;
            transform: translateY(-50%);
            border: none;
            background: none;
            cursor: pointer;
            color: #007bff;
            font-size: 18px;
            display: flexbox;
        }

        .login-container form button {
            padding: 12px;
            border: none;
            border-radius: 5px;
            display: block;
            width: 80px;
            display: flexbox;
            align-self: center;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-container form button:hover {
            background-color: gainsboro;
            opacity: .3;
        }

        .error {
            color: #ff0000;
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 30px;
                max-width: 90%;
            }

            .login-container img {
                max-width: 120px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="img/logo3.png" alt="Your Logo">
        <h2>Login</h2>
        <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <div class="password-container">
                <input type="password" name="password" id="password" required aria-label="Password">
                <button type="button" class="toggle-password" aria-label="Toggle password visibility">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <button type="submit">Login</button>
        </form>
    </div>

    <script>
        const togglePasswordButton = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = togglePasswordButton.querySelector('i');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Toggle the eye and eye-slash icons
            if (type === 'text') {
                togglePasswordIcon.classList.remove('fa-eye');
                togglePasswordIcon.classList.add('fa-eye-slash');
            } else {
                togglePasswordIcon.classList.remove('fa-eye-slash');
                togglePasswordIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>
