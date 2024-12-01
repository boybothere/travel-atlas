<?php
session_start();
include 'connection.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';
require 'PHPMailer/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];

// Handle booking cancellation
if (isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];
    
    // Delete booking from the database
    $deleteStmt = $conn->prepare("DELETE FROM bookings WHERE booking_id = ? AND email = ?");
    $deleteStmt->bind_param("is", $booking_id, $email);
    
    if ($deleteStmt->execute()) {
        // Send cancellation email using PHPMailer and Mailtrap
        $mail = new PHPMailer(true);
        
        try {
            // Mailtrap SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';  // Mailtrap SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = '9e43bf8e4ef4a5';  // Replace with your Mailtrap SMTP username
            $mail->Password = '1a7e9c5ff8833b';  // Replace with your Mailtrap SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email content
            $mail->setFrom('no-reply@travelatlas.com', 'Travel Atlas');
            $mail->addAddress('adrianfdes242004@gmail.com'); // Send to your email

            $mail->isHTML(true);
            $mail->Subject = "Booking Cancelled: Booking ID $booking_id";
            $mail->Body = "
                <h3>Booking Cancellation Details</h3>
                <p><strong>User Email:</strong> $email</p>
                <p><strong>Booking ID:</strong> $booking_id</p>
                <p>The user has cancelled their booking for this destination.</p>
            ";

            $mail->send();
            echo "<p class='success-message'>Booking cancelled successfully. An email notification has been sent.</p>";
        } catch (Exception $e) {
            echo "<p class='error-message'>Mailer Error: {$mail->ErrorInfo}</p>";
        }
    } else {
        echo "<p class='error-message'>Error cancelling booking: " . $deleteStmt->error . "</p>";
    }
    $deleteStmt->close();
}

// Fetch bookings for the logged-in user
$stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

echo '<link rel="stylesheet" href="stylebookings.css">';
echo '<div class="bookings-container">';
echo "<h1>Your Bookings</h1>";

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="booking-entry">';
        echo "<p><strong>Destination:</strong> " . htmlspecialchars($row['destination']) . "</p>";
        echo "<p><strong>Guests:</strong> " . htmlspecialchars($row['guests']) . "</p>";
        echo "<p><strong>Arrival Date:</strong> " . htmlspecialchars($row['arrival_date']) . "</p>";
        echo "<p><strong>Departure Date:</strong> " . htmlspecialchars($row['departure_date']) . "</p>";
        
        // Cancel booking form
        echo '<form method="POST" style="margin-top: 10px;">';
        echo '<input type="hidden" name="booking_id" value="' . $row['booking_id'] . '">';
        echo '<button type="submit" name="cancel_booking" class="cancel-btn" onclick="return confirm(\'Are you sure you want to cancel this booking?\');">Cancel Booking</button>';
        echo '</form>';
        
        echo '</div>';
    }
} else {
    echo "<p class='no-bookings'>No bookings found.</p>";
}

$stmt->close();
$conn->close();
echo '</div>';

// Return to Home button
echo '<div class="return-home">';
echo '<form action="index.php" method="get">';
echo '<button type="submit" class="return-btn">Return to Home</button>';
echo '</form>';
echo '</div>';
?>
