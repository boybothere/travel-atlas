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
    if (
        strlen($password) < 8 || !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) ||
        !preg_match('/[@$!%*?&#]/', $password)
    ) {
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
        $stmt->bind_param("ss", $email, $password);

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




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TravelAtlas - Adventure Awaits</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background-image: url('https://cache.marriott.com/content/dam/marriott-renditions/GOIMC/goimc-simply-grills-6480-hor-clsc.jpg?output-quality=70&interpolation=progressive-bilinear&downsize=1846px:*');
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            z-index: 1;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            padding: 20px;
            gap: 50px;
            position: relative;
            z-index: 2;
        }

        .left-side {
            flex: 1;
            color: white;
            padding: 40px;
            animation: slideIn 1s ease-out;
        }

        .right-side {
            flex: 1;
            background: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            animation: fadeIn 1s ease-out;
        }

        .logo {
            font-size: 2.5em;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .logo span {
            color: #ffa500;
        }

        .tagline {
            font-size: 2.5em;
            margin-bottom: 20px;
            line-height: 1.2;
            font-weight: bold;
        }

        .subtagline {
            font-size: 1.2em;
            margin-bottom: 30px;
            opacity: 0.9;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 2px solid #e1e1e1;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #ffa500;
            outline: none;
            box-shadow: 0 0 0 3px rgba(255, 165, 0, 0.1);
        }

        .submit-btn {
            width: 100%;
            padding: 12px;
            background: #ffa500;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: #ff8c00;
            transform: translateY(-2px);
        }

        .links {
            margin-top: 20px;
            text-align: center;
        }

        .links a {
            color: #333;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s ease;
        }

        .links a:hover {
            color: #ffa500;
        }

        @keyframes slideIn {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-side,
            .right-side {
                padding: 20px;
            }

            .tagline {
                font-size: 2em;
            }
        }

        .validation-message {
            margin-top: 5px;
            font-size: 0.9em;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>

<body>
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?php echo $_SESSION['msg_type']; ?>"
            style="color: <?php echo ($_SESSION['msg_type'] == 'danger') ? 'red' : 'green'; ?>;">
            <?php
            echo $_SESSION['msg'];
            unset($_SESSION['msg']);
            unset($_SESSION['msg_type']);
            ?>
        </div>
    <?php endif; ?>

    <?php 
    // Display session messages if they exist
    if (isset($_SESSION['email_error']) || isset($_SESSION['password_error'])) {
        echo '<div class="validation-message">';
        if (isset($_SESSION['email_error'])) {
            echo '<div class="error">' . $_SESSION['email_error'] . '</div>';
            unset($_SESSION['email_error']);
        }
        if (isset($_SESSION['password_error'])) {
            echo '<div class="error">' . $_SESSION['password_error'] . '</div>';
            unset($_SESSION['password_error']);
        }
        echo '</div>';
    } 
    ?>

    <div class="overlay"></div>
    <div class="container">
        <div class="left-side">
            <div class="logo">
                <span>T</span>RAVEL
                <span>A</span>TLAS
            </div>
            <div class="tagline">YOUR NEW ADVENTURE AWAITS</div>
            <div class="subtagline">Discover New Places With Us</div>
        </div>

        <div class="right-side">
            <h2 style="margin-bottom: 30px; color: #333;">Create your Account</h2>
            <form method="post" action="authsignup.php">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    <div id="emailFeedback" class="validation-message"></div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                    <div id="passwordFeedback" class="validation-message"></div>
                </div>

                <button type="submit" class="submit-btn">SIGNUP</button>
            </form>
            <div class="links">
                ALREADY HAVE AN ACCOUNT? 
                <a href="login.php">LOGIN</a>
            </div>
        </div>
    </div>

    <script>
        const emailInput = document.getElementById("email");
        const emailFeedback = document.getElementById("emailFeedback");
        const passwordInput = document.getElementById("password");
        const passwordFeedback = document.getElementById("passwordFeedback");

        // Real-time Email Validation
        emailInput.addEventListener("input", () => {
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (emailPattern.test(emailInput.value)) {
                emailFeedback.textContent = "Valid email!";
                emailFeedback.className = "success";
            } else {
                emailFeedback.textContent = "Enter a valid email address.";
                emailFeedback.className = "error";
            }
        });

        // Real-time Password Validation
        passwordInput.addEventListener("input", () => {
            const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
            if (passwordPattern.test(passwordInput.value)) {
                passwordFeedback.textContent = "Password is strong!";
                passwordFeedback.className = "success";
            } else {
                passwordFeedback.textContent = "Password must contain 1 digit, 1 uppercase, 1 lowercase, 1 special character, and be 8+ characters.";
                passwordFeedback.className = "error";
            }
        });
    </script>

</body>

</html>