CREATE TABLE logindetails (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(100),
    country VARCHAR(50),
    phone_number VARCHAR(20),
    address TEXT,
    bio TEXT,
    profile_pic VARCHAR(255),
    FOREIGN KEY (email) REFERENCES users(email) ON DELETE CASCADE
);
