<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['email_error'] = "Invalid email format.";
        header("Location: signup.php");
        exit();
    }

    // Validate password
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) ||
        !preg_match('/[@$!%*?&#]/', $password)) {
        $_SESSION['password_error'] = "Password must be 8+ characters with uppercase, lowercase, digit, and special character.";
        header("Location: signup.php");
        exit();
    }

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['msg'] = "You already have an account. Please log in.";
        $_SESSION['msg_type'] = "danger";
        header("Location: login.php");
        exit();
    } else {
        // Insert the new user into the database without hashing the password
        $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $password); // Directly use the plain password

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Registration successful!";
            $_SESSION['msg_type'] = "success";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['msg'] = "Error during registration. Please try again.";
            $_SESSION['msg_type'] = "danger";
            header("Location: signup.php");
            exit();
        }
    }
    $stmt->close();
}
?>
