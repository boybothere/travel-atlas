<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $booking_id = $_POST['booking_id'];

    // Assuming payment process is successful
    echo '<link rel="stylesheet" href="styleconfirm.css">';
    echo '<div class="confirmation-container">';
    echo '<h2>Booking Confirmed!</h2>';
    echo '<p>Your booking has been confirmed.</p>';
    echo '<p>Thank you for booking with us. You can view your booking details on your profile page.</p>';
    echo '<p>We will get back to you shortly on the email via you have booked.</p>';
    echo '<a href="displaybookings.php" class="view-bookings-btn">View Bookings</a>';
    echo '</div>';
}
?>
