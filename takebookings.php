<?php
session_start();
include 'connection.php';
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';
require 'PHPMailer/PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION['email'];
$destination = $_POST['destination'];
$guests = $_POST['guests'];
$arrival_date = $_POST['arrival_date'];
$departure_date = $_POST['departure_date'];

// Destination pricing
$prices = [
    "Mumbai" => 1200,
    "Hawaii" => 22000,
    "Sydney" => 15700,
    "Belfast" => 14300,
    "Tokyo" => 16500,
    "Egypt" => 17500,
];
$price_per_guest = $prices[$destination];
$total_price = $price_per_guest * $guests;

// Insert booking into the database
$stmt = $conn->prepare("INSERT INTO bookings (email, destination, guests, arrival_date, departure_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $email, $destination, $guests, $arrival_date, $departure_date);

if ($stmt->execute()) {
    // Include the CSS file here
    echo '<link rel="stylesheet" href="stylebooking.css">';
    echo '<div class="booking-container">';
    echo "<h2>Booking Successful!</h2>";
    echo '<div class="booking-summary">';
    echo "<p><strong>Destination:</strong> $destination</p>";
    echo "<p><strong>Number of Guests:</strong> $guests</p>";
    echo "<p><strong>Arrival Date:</strong> $arrival_date</p>";
    echo "<p><strong>Departure Date:</strong> $departure_date</p>";
    echo "<p><strong>Total Price:</strong> ₹ " . number_format($total_price, 2) . "</p>";
    echo '</div>';
    echo '<form action="confirmbooking.php" method="POST" class="booking-form">';
    echo '<input type="hidden" name="booking_id" value="' . $conn->insert_id . '">';
    echo '<button type="submit" class="proceed-btn">Proceed for further details</button>';
    echo '</form>';
    echo '</div>';

    // Send booking details via email using PHPMailer and Mailtrap
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
        $mail->Subject = "New Booking: $destination";
        $mail->Body = "
            <h3>New Booking Details</h3>
            <p><strong>User Email:</strong> $email</p>
            <p><strong>Destination:</strong> $destination</p>
            <p><strong>Number of Guests:</strong> $guests</p>
            <p><strong>Arrival Date:</strong> $arrival_date</p>
            <p><strong>Departure Date:</strong> $departure_date</p>
            <p><strong>Total Price:</strong> ₹ " . number_format($total_price, 2) . "</p>
        ";

        $mail->send();
       // echo "<p class='success-message'>Booking details have been sent to your email.</p>";
    } catch (Exception $e) {
        echo "<p class='error-message'>Mailer Error: {$mail->ErrorInfo}</p>";
    }
} else {
    echo "<p class='error'>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
