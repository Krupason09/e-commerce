```
<?php
session_start();
include '../includes/db.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($id, $fullname, $email, $hashed_password);
    $stmt->fetch();
    $user = $stmt->fetch_assoc();

    if ($user && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['fullname'];
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Invalid email or password.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Easyshopping - Login</title>
    <link href="stylesheet" rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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
            background: #fff;
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
            border-color: #9b59b6;color;
            box-shadow: 0 0 5px rgba(155, 89, 182, 0.3);
        }

        .btn-field {
            margin-top: 20px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: #9b59b6;color;
            color: #fff;white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: #8e44ad;
        }

        .forgot-pass {
            text-align: right;
            margin-top: 10px;
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

        .register-link,
        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #666;
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
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-box">
            <h2>Login to EasyShopping</h2>
            <?php if (isset($error_message)): ?>
                <p class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="input-group">
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="forgot-pass">
                        <a href="#">Forgot Password?</a>
                    </div>
                </div>
                <div class="btn-field">
                    <button type="submit" name="login">Login</button>
                </div>
                <div class="register-link">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
```g