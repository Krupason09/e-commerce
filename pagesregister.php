```
<?php
include('../includes/db.php');

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        $error_message = "Passwords do not match!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();
        if ($check->num_rows > 0) {
            $error_message = "Email already registered!";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $hashed_password);
            if ($stmt->execute()) {
                $success_message = "Registration successful! Please login.";
            } else {
                $error_message = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - EasyShopping</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #71b7e6, #9b59b6);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: auto;
        }

        .container {
            width: 100%;
            max-width: 400px;
            padding: 50px 30px;
            justify-content: center;
            display: block;
        }

        .form-box {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-field {
            margin-bottom: 15px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #9b59b6;
            box-shadow: 0 0 5px rgba(155, 89, 182, 0.3);
        }

        .btn-field {
            margin-top: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #9b59b6;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: #8e44ad;
        }

        .forgot-pass,
        .register-link,
        .login-link {
            text-align: center;
            margin-top: 10px;
            color: #666;
        }

        .forgot-pass a,
        .register-link a,
        .login-link a {
            color: #9b59b6;
            text-decoration: none;
        }

        .forgot-pass a:hover,
        .register-link a:hover,
        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }
            .form-box {
                padding: 20px;
            }
        }

        .error-message {
            color: #e74c3c;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }

        .success-message {
            color: #2ecc71;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Register</h2>
            <form action="" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <input type="text" placeholder="Full Name" required name="fullname">
                    </div>
                    <div class="input-field">
                        <input type="email" placeholder="Email" required name="email">
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="Password" required name="password">
                    </div>
                    <div class="input-field">
                        <input type="password" placeholder="Confirm Password" required name="cpassword">
                    </div>
                </div>
                <div class="btn-field">
                    <button type="submit">Register</button>
                </div>
                <div class="login-link">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </form>
            <?php if ($error_message): ?>
                <p class="error-message"><?= htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <p class="success-message"><?= htmlspecialchars($success_message); ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
``` 