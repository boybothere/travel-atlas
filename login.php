<?php
session_start();
include 'connection.php';
if (isset($_SESSION['msg'])) {
    // Display the message
    echo '<div class="alert ' . $_SESSION['msg_type'] . '">';
    echo $_SESSION['msg'];
    echo '</div>';
    // Clear the message after displaying it
    unset($_SESSION['msg']);
    unset($_SESSION['msg_type']);
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_password);
        $stmt->fetch();

        if ($password === $db_password) { // Assuming no hashing, per your setup
            $_SESSION['msg'] = "Login successful!";
            $_SESSION['msg_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['msg'] = "Incorrect password.";
            $_SESSION['msg_type'] = "danger";
        }
    } else {
        $_SESSION['msg'] = "Account doesn't exist.";
        $_SESSION['msg_type'] = "danger";
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

        .alert {
    position: fixed;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    background-color: #ffcc00; /* For warning messages */
    color: #333;
    padding: 10px 20px;
    border-radius: 5px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    font-size: 16px;
    z-index: 1000;
    width: 80%; /* Adjust width as necessary */
    text-align: center;
}

.alert a {
    color: #0056b3; /* Link color */
    text-decoration: underline;
}

.alert.danger {
    background-color: #ff4d4d; /* For error messages */
    color: #fff;
}

.alert.warning {
    background-color: #ffcc00; /* For warning messages */
    color: #333;
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
            .left-side, .right-side {
                padding: 20px;
            }
            .tagline {
                font-size: 2em;
            }
        }
        .success { color: green; }
        .error { color: red; }
    </style>
</head>
<body>
<?php if (isset($_SESSION['msg'])): ?>
        <<div class="alert <?php echo $_SESSION['msg_type']; ?>">
            <?php
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
                unset($_SESSION['msg_type']);
            ?>
        </div>
    <?php endif; ?>



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
            <h2 style="margin-bottom: 30px; color: #333;">Begin your Journey</h2>
            <form method="post" action="auth.php">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" autocomplete="off" required>
                    <div id="emailFeedback"></div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" autocomplete="off" required>
                    <div id="passwordFeedback"></div>
                </div>
                <button type="submit" name="login" class="submit-btn">LOGIN</button>
            </form>
            <div class="links">
                DON'T HAVE AN ACCOUNT? 
                <a href="signup.php">SIGNUP</a>
            </div>
        </div>
    </div>

    

</body>
</html>