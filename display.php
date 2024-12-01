<?php
session_start();
include 'connection.php';

// Fetch user data
$email = $_SESSION['email'] ?? ''; // Ensure that email is initialized
$stmt = $conn->prepare("SELECT * FROM logindetails WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();

if (!$userData) {
    echo "No profile data found.";
    exit();
}

// Handle account deletion
if (isset($_POST['delete_account'])) {
    // Prepare delete statements for both tables
    $deleteLogindetailsStmt = $conn->prepare("DELETE FROM logindetails WHERE email = ?");
    $deleteUsersStmt = $conn->prepare("DELETE FROM users WHERE email = ?");

    // Bind the email parameter for both statements
    $deleteLogindetailsStmt->bind_param("s", $email);
    $deleteUsersStmt->bind_param("s", $email);

    // Execute both delete statements
    $logindetailsDeleted = $deleteLogindetailsStmt->execute();
    $usersDeleted = $deleteUsersStmt->execute();

    // Check if both deletions were successful
    if ($logindetailsDeleted && $usersDeleted) {
        session_destroy();
        header("Location: login.php");
        exit();
    } else {
        echo "Error deleting account: " . $deleteLogindetailsStmt->error . " " . $deleteUsersStmt->error;
    }

    // Close the statements
    $deleteLogindetailsStmt->close();
    $deleteUsersStmt->close();
}

// Close the main statement and connection
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styledisplay.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <title>Display Profile</title>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <div class="avatar">
                
            </div>
            <h1>Welcome, <?php echo htmlspecialchars($userData['name']); ?></h1>
        </div>

        <div class="profile-card">
            <h2><i class="fas fa-info-circle"></i> Your Details</h2>
            
            <div class="details-grid">
                <div class="detail-item">
                    <i class="fas fa-globe"></i>
                    <div class="detail-content">
                        <span class="label">Country</span>
                        <p><?php echo htmlspecialchars($userData['country']); ?></p>
                    </div>
                </div>

                <div class="detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div class="detail-content">
                        <span class="label">Address</span>
                        <p><?php echo htmlspecialchars($userData['address']); ?></p>
                    </div>
                </div>

                <div class="detail-item">
                    <i class="fas fa-phone"></i>
                    <div class="detail-content">
                        <span class="label">Phone Number</span>
                        <p><?php echo htmlspecialchars($userData['phone_number']); ?></p>
                    </div>
                </div>

                <div class="detail-item full-width">
                    <i class="fas fa-user-edit"></i>
                    <div class="detail-content">
                        <span class="label">Bio</span>
                        <p><?php echo htmlspecialchars($userData['bio']); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <!-- Update Details Button -->
            <form method="GET" action="myprofile.php">
                <button type="submit" class="btn-update">
                    <i class="fas fa-user-edit"></i> Update Details
                </button>
            </form>

            <!-- Go to Home Form -->
            <form action="index.php" method="get">
                <button type="submit" class="btn-home">
                    <i class="fas fa-home"></i> Go to Home
                </button>
            </form>

            <!-- Logout Form -->
            <form action="logout.php" method="get">
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>

            <!-- Delete Account Form -->
            <form method="POST">
                <button type="submit" name="delete_account" class="btn-delete" 
                        onclick="return confirm('Are you sure you want to delete your account?');">
                    <i class="fas fa-user-times"></i> Delete Account
                </button>
            </form>
        </div>
    </div>
</body>
</html>
