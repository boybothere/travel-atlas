<?php
session_start();
include 'connection.php';

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
    "Mumbai" => 8500,
    "Hawaii" => 23000,
    "Sydney" => 40000,
    "Belfast" => 32000,
    "Tokyo" => 30000,
    "Egypt" => 40000,
];
$price_per_guest = $prices[$destination];
$total_price = $price_per_guest * $guests;

// Insert booking into the database
$stmt = $conn->prepare("INSERT INTO bookings (email, destination, guests, arrival_date, departure_date) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $email, $destination, $guests, $arrival_date, $departure_date);

if ($stmt->execute()) {
    // Booking inserted, display summary
    echo "<h2>Booking Summary</h2>";
    echo "<p>Destination: $destination</p>";
    echo "<p>Number of Guests: $guests</p>";
    echo "<p>Arrival Date: $arrival_date</p>";
    echo "<p>Departure Date: $departure_date</p>";
    echo "<p>Total Price: ₹ " . number_format($total_price, 2) . "</p>";

    echo '<form action="confirmbooking.php" method="POST">';
    echo '<input type="hidden" name="booking_id" value="' . $conn->insert_id . '">';
    echo '<button type="submit">Proceed and Pay</button>';
    echo '</form>';
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();


?>
