CREATE TABLE bookings (
    booking_id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    guests INT NOT NULL,
    arrival_date DATE NOT NULL,
    departure_date DATE NOT NULL,
    FOREIGN KEY (email) REFERENCES logindetails(email) ON DELETE CASCADE
);
