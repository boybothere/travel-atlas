<?php
session_start();
include 'connection.php';

$email = $_SESSION['email'] ?? '';

// Initialize variables
$name = "";
$country = "";
$phone_number = "";
$address = "";
$bio = "";

// Fetch existing user profile data if the user is logged in
if (!empty($email)) {
    $stmt = $conn->prepare("SELECT * FROM logindetails WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $userData = $result->fetch_assoc();
        $name = $userData['name'] ?? '';
        $country = $userData['country'] ?? '';
        $phone_number = $userData['phone_number'] ?? '';
        $address = $userData['address'] ?? '';
        $bio = $userData['bio'] ?? '';
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user inputs
    $name = $_POST['name'];
    $country = $_POST['country'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $bio = $_POST['bio'];

    // Input validation
    if (empty($name) || empty($country) || !preg_match('/^\d{10}$/', $phone_number)) {
        echo "Invalid input. Please check your information.";
    } else {
        // Check if a record exists
        $checkStmt = $conn->prepare("SELECT id FROM logindetails WHERE email = ?");
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // Update existing record
            $updateStmt = $conn->prepare("UPDATE logindetails SET name = ?, country = ?, phone_number = ?, address = ?, bio = ? WHERE email = ?");
            $updateStmt->bind_param("ssssss", $name, $country, $phone_number, $address, $bio, $email);
            if ($updateStmt->execute()) {
                // Redirect to display.php after successful update
                header("Location: display.php");
                exit();
            } else {
                echo "Error updating profile: " . $updateStmt->error;
            }
        } else {
            // Insert new record
            $insertStmt = $conn->prepare("INSERT INTO logindetails (email, name, country, phone_number, address, bio) VALUES (?, ?, ?, ?, ?, ?)");
            $insertStmt->bind_param("ssssss", $email, $name, $country, $phone_number, $address, $bio);
            if ($insertStmt->execute()) {
                // Redirect to display.php after successful insert
                header("Location: display.php");
                exit();
            } else {
                echo "Error creating profile: " . $insertStmt->error;
            }
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styleprofile.css">
    <title>My Profile</title>
    <style>
        /* Styling for validation message */
        .error-message {
            color: red;
            font-size: 0.9em;
            display: none; /* Hidden by default */
        }
    </style>
</head>
<body>
    <h1>Profile Form</h1>
    <form method="POST" action="">
        <label>Name: <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required></label><br>
        <label>Country: <input type="text" name="country" value="<?php echo htmlspecialchars($country); ?>" required></label><br>
        
        <label>Phone Number: 
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" 
                   pattern="\d{10}" title="Phone number must be exactly 10 digits." required 
                   oninput="validatePhoneNumber()">
            <div id="phoneError" class="error-message">Phone number must be exactly 10 digits.</div>
        </label><br>
        
        <label>Address: <input type="text" name="address" value="<?php echo htmlspecialchars($address); ?>" required></label><br>
        <label>Bio: <textarea name="bio" required><?php echo htmlspecialchars($bio); ?></textarea></label><br>
        <button type="submit">Save Changes</button>
    </form>

    <script>
        function validatePhoneNumber() {
            const phoneInput = document.getElementById("phone_number");
            const phoneError = document.getElementById("phoneError");
            
            // Check if the input value is exactly 10 digits
            if (phoneInput.value.length === 10 && /^\d{10}$/.test(phoneInput.value)) {
                phoneError.style.display = "none"; // Hide error if valid
            } else {
                phoneError.style.display = "block"; // Show error if invalid
            }
        }
    </script>
</body>
</html>
