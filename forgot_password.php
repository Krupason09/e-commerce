<?php
include 'db.php';
require 'vendor/autoload.php'; // for PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $check = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");

    if (mysqli_num_rows($check)) {
        $token = bin2hex(random_bytes(32));
        $expires = date("Y-m-d H:i:s", time() + 3600); // 1 hour

        mysqli_query($conn, "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expires')");

        $link = "http://yourdomain.com/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        $mail->setFrom('noreply@yourdomain.com', 'E-Commerce Site');
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->Body = "Click the link to reset your password: $link";
        $mail->send();

        echo "Password reset email sent!";
    } else {
        echo "Email not found.";
    }
}
?>

<form method="post">
    <h2>Forgot Password</h2>
    <input type="email" name="email" required placeholder="Enter your email">
    <button type="submit">Send Reset Link</button>
</form>
