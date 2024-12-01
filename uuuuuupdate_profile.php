<?php 
session_start();
include 'connection.php';

header('Content-Type: application/json');

if (!isset($_SESSION['email'])) {
    echo json_encode([
        "status" => "error", 
        "message" => "Not logged in"
    ]);
    exit();
}

$email = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_info'])) {
        $name = trim($_POST['name']);
        $country = trim($_POST['country']);
        $phone_number = trim($_POST['phone_number']);
        $address = trim($_POST['address']);
        $bio = trim($_POST['bio']);

        // Basic input validation
        if (empty($name) || empty($country) || !preg_match('/^\d{10}$/', $phone_number)) {
            echo json_encode([
                "status" => "error", 
                "message" => "Invalid input. Please check your information."
            ]);
            exit();
        }

        try {
            // Check if record exists
            $checkStmt = $conn->prepare("SELECT id FROM logindetails WHERE email = ?");
            $checkStmt->bind_param("s", $email);
            $checkStmt->execute();
            $result = $checkStmt->get_result();
            $checkStmt->close();

            if ($result->num_rows > 0) {
                // Update existing record
                $stmt = $conn->prepare("
                    UPDATE logindetails 
                    SET name = ?, 
                        country = ?, 
                        phone_number = ?, 
                        address = ?, 
                        bio = ? 
                    WHERE email = ?
                ");
                $stmt->bind_param("ssssss", $name, $country, $phone_number, $address, $bio, $email);
            } else {
                // Insert new record
                $stmt = $conn->prepare("
                    INSERT INTO logindetails 
                    (email, name, country, phone_number, address, bio) 
                    VALUES (?, ?, ?, ?, ?, ?)
                ");
                $stmt->bind_param("ssssss", $email, $name, $country, $phone_number, $address, $bio);
            }

            if ($stmt->execute()) {
                echo json_encode([
                    "status" => "success",
                    "message" => "Profile updated successfully"
                ]);
            } else {
                throw new Exception($stmt->error);
            }
            $stmt->close();

        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Database error: " . $e->getMessage()
            ]);
        }
        exit();
    }

    // Handle account deletion
    if (isset($_POST['delete_account'])) {
        try {
            // Due to ON DELETE CASCADE in your table structure,
            // we only need to delete from users table
            $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            
            if ($stmt->execute()) {
                session_destroy();
                echo json_encode([
                    "status" => "success",
                    "message" => "Account deleted successfully",
                    "redirect" => "login.php"
                ]);
            } else {
                throw new Exception("Failed to delete account");
            }
            $stmt->close();
        } catch (Exception $e) {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to delete account: " . $e->getMessage()
            ]);
        }
        exit();
    }
}

echo json_encode([
    "status" => "error",
    "message" => "Invalid request"
]);
?>
