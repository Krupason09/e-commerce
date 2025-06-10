<?php
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $result = mysqli_query($conn, "SELECT * FROM password_resets WHERE token = '$token'");

    if (mysqli_num_rows($result)) {
        $row = mysqli_fetch_assoc($result);
        if (strtotime($row['expires_at']) < time()) {
            echo "Token expired.";
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $email = $row['email'];

            mysqli_query($conn, "UPDATE users SET password = '$password' WHERE email = '$email'");
            mysqli_query($conn, "DELETE FROM password_resets WHERE email = '$email'");
            echo "Password updated!";
            exit();
        }
    } else {
        echo "Invalid token.";
        exit();
    }
} else {
    echo "No token.";
    exit();
}
?>

<form method="post">
    <h2>Reset Password</h2>
    <input type="password" name="password" required placeholder="New password">
    <button type="submit">Reset Password</button>
</form>
