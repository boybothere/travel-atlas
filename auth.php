

<?php
session_start();  // Start the session
include 'connection.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the account exists in the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Account exists, now check the password
        $stmt->bind_result($stored_password);
        $stmt->fetch();

        // Compare the entered password with the stored password
        if ($stored_password === $password) {  // No hashing as per your request
            // Password matches, so save the email in session
            $_SESSION['email'] = $email;
            header("Location: myprofile.php");
            exit();
        } else {
            // Incorrect password
            $_SESSION['msg'] = "Incorrect password. Please try again.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Account does not exist
        $_SESSION['msg'] = "Account doesn't exist. Please <a href='signup.php'>sign up</a>.";
        header("Location: login.php");
        exit();
    }

    $stmt->close();
}
?>
