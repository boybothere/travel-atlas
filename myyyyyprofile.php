<?php
session_start(); // Starting the session

include 'connection.php'; // Including the database connection file

// Initialize variables
$email = "";
$name="";
$address = "";
$country="";
$bio = "";
$profile_pic = "";
$phone_number = "";
$error_message = "";
$success_message = "";

// Fetch user data (assuming email is stored in session)
if (isset($_SESSION['user_email'])) {
    $email = $_SESSION['user_email'];

    // Prepare and execute the SQL statement to fetch existing user profile data
    $stmt = $conn->prepare("SELECT name, address, bio, profile_pic, phone_number FROM logindetails WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'] ?? '';
        $address = $row['address'] ?? '';
        $bio = $row['bio'] ?? '';
        $profile_pic = $row['profile_pic'] ?? '';
        $phone_number = $row['phone_number'] ?? '';
    } else {
        $error_message = "No profile data found.";
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $address = trim($_POST['address']);
    $bio = trim($_POST['bio']);
    $phone_number = trim($_POST['phone_number']);

    // Validate phone number (10 digits)
    if (!preg_match('/^\d{10}$/', $phone_number)) {
        $error_message = "Phone number must be 10 digits without special characters.";
    } else {
        // Update user profile information in the database
        $update_stmt = $conn->prepare("UPDATE logindetails SET address = ?, bio = ?, phone_number = ? WHERE email = ?");
        $update_stmt->bind_param("ssss", $address, $bio, $phone_number, $email);
        
        if ($update_stmt->execute()) {
            $success_message = "Profile updated successfully!";
            // Optionally refresh the page to display the updated values
            // header("Location: myprofile.php"); exit();
        } else {
            $error_message = "Error updating profile: " . $conn->error;
        }
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link rel="stylesheet" href="styleprofile.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/emoji-picker/1.0.0/emoji-picker.min.js"></script>
</head>

<body>
    <div class="page-container">
        <header class="welcome-header">
            <h1>Welcome, <?php echo htmlspecialchars($name ?? $email); ?></h1>
        </header>

        <main class="main-content">
            <div class="profile-card">
                

                <div class="profile-form">
                    <form action="myprofile.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="update_info" value="1">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($db_email); ?>">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="country">Country</label>
                            <select id="country" name="country" required>
                                <option value="">Select your country</option>
                                <option value="Afghanistan" <?php echo $country === 'Afghanistan' ? 'selected' : ''; ?>>
                                    Afghanistan</option>
                                <option value="Albania" <?php echo $country === 'Albania' ? 'selected' : ''; ?>>Albania
                                </option>
                                <option value="Algeria" <?php echo $country === 'Algeria' ? 'selected' : ''; ?>>Algeria
                                </option>
                                <option value="Andorra" <?php echo $country === 'Andorra' ? 'selected' : ''; ?>>Andorra
                                </option>
                                <option value="Angola" <?php echo $country === 'Angola' ? 'selected' : ''; ?>>Angola
                                </option>
                                <option value="Argentina" <?php echo $country === 'Argentina' ? 'selected' : ''; ?>>
                                    Argentina</option>
                                <option value="Armenia" <?php echo $country === 'Armenia' ? 'selected' : ''; ?>>Armenia
                                </option>
                                <option value="Australia" <?php echo $country === 'Australia' ? 'selected' : ''; ?>>
                                    Australia</option>
                                <option value="Austria" <?php echo $country === 'Austria' ? 'selected' : ''; ?>>Austria
                                </option>
                                <option value="Azerbaijan" <?php echo $country === 'Azerbaijan' ? 'selected' : ''; ?>>
                                    Azerbaijan</option>
                                <option value="Bangladesh" <?php echo $country === 'Bangladesh' ? 'selected' : ''; ?>>
                                    Bangladesh</option>
                                <option value="Belgium" <?php echo $country === 'Belgium' ? 'selected' : ''; ?>>Belgium
                                </option>
                                <option value="Brazil" <?php echo $country === 'Brazil' ? 'selected' : ''; ?>>Brazil
                                </option>
                                <option value="Bulgaria" <?php echo $country === 'Bulgaria' ? 'selected' : ''; ?>>Bulgaria
                                </option>
                                <option value="Canada" <?php echo $country === 'Canada' ? 'selected' : ''; ?>>Canada
                                </option>
                                <option value="Chile" <?php echo $country === 'Chile' ? 'selected' : ''; ?>>Chile</option>
                                <option value="China" <?php echo $country === 'China' ? 'selected' : ''; ?>>China</option>
                                <option value="Colombia" <?php echo $country === 'Colombia' ? 'selected' : ''; ?>>Colombia
                                </option>
                                <option value="Costa Rica" <?php echo $country === 'Costa Rica' ? 'selected' : ''; ?>>
                                    Costa Rica</option>
                                <option value="Cuba" <?php echo $country === 'Cuba' ? 'selected' : ''; ?>>Cuba</option>
                                <option value="Czech Republic" <?php echo $country === 'Czech Republic' ? 'selected' : ''; ?>>Czech Republic</option>
                                <option value="Denmark" <?php echo $country === 'Denmark' ? 'selected' : ''; ?>>Denmark
                                </option>
                                <option value="Dominican Republic" <?php echo $country === 'Dominican Republic' ? 'selected' : ''; ?>>Dominican Republic</option>
                                <option value="Egypt" <?php echo $country === 'Egypt' ? 'selected' : ''; ?>>Egypt</option>
                                <option value="Estonia" <?php echo $country === 'Estonia' ? 'selected' : ''; ?>>Estonia
                                </option>
                                <option value="Finland" <?php echo $country === 'Finland' ? 'selected' : ''; ?>>Finland
                                </option>
                                <option value="France" <?php echo $country === 'France' ? 'selected' : ''; ?>>France
                                </option>
                                <option value="Georgia" <?php echo $country === 'Georgia' ? 'selected' : ''; ?>>Georgia
                                </option>
                                <option value="Germany" <?php echo $country === 'Germany' ? 'selected' : ''; ?>>Germany
                                </option>
                                <option value="Greece" <?php echo $country === 'Greece' ? 'selected' : ''; ?>>Greece
                                </option>
                                <option value="Hungary" <?php echo $country === 'Hungary' ? 'selected' : ''; ?>>Hungary
                                </option>
                                <option value="Iceland" <?php echo $country === 'Iceland' ? 'selected' : ''; ?>>Iceland
                                </option>
                                <option value="India" <?php echo $country === 'India' ? 'selected' : ''; ?>>India</option>
                                <option value="Indonesia" <?php echo $country === 'Indonesia' ? 'selected' : ''; ?>>
                                    Indonesia</option>
                                <option value="Iran" <?php echo $country === 'Iran' ? 'selected' : ''; ?>>Iran</option>
                                <option value="Iraq" <?php echo $country === 'Iraq' ? 'selected' : ''; ?>>Iraq</option>
                                <option value="Ireland" <?php echo $country === 'Ireland' ? 'selected' : ''; ?>>Ireland
                                </option>
                                <option value="Israel" <?php echo $country === 'Israel' ? 'selected' : ''; ?>>Israel
                                </option>
                                <option value="Italy" <?php echo $country === 'Italy' ? 'selected' : ''; ?>>Italy</option>
                                <option value="Japan" <?php echo $country === 'Japan' ? 'selected' : ''; ?>>Japan</option>
                                <option value="Jordan" <?php echo $country === 'Jordan' ? 'selected' : ''; ?>>Jordan
                                </option>
                                <option value="Kazakhstan" <?php echo $country === 'Kazakhstan' ? 'selected' : ''; ?>>
                                    Kazakhstan</option>
                                <option value="Kenya" <?php echo $country === 'Kenya' ? 'selected' : ''; ?>>Kenya</option>
                                <option value="Kuwait" <?php echo $country === 'Kuwait' ? 'selected' : ''; ?>>Kuwait
                                </option>
                                <option value="Latvia" <?php echo $country === 'Latvia' ? 'selected' : ''; ?>>Latvia
                                </option>
                                <option value="Lithuania" <?php echo $country === 'Lithuania' ? 'selected' : ''; ?>>
                                    Lithuania</option>
                                <option value="Malaysia" <?php echo $country === 'Malaysia' ? 'selected' : ''; ?>>Malaysia
                                </option>
                                <option value="Mexico" <?php echo $country === 'Mexico' ? 'selected' : ''; ?>>Mexico
                                </option>
                                <option value="Mongolia" <?php echo $country === 'Mongolia' ? 'selected' : ''; ?>>Mongolia
                                </option>
                                <option value="Morocco" <?php echo $country === 'Morocco' ? 'selected' : ''; ?>>Morocco
                                </option>
                                <option value="Nepal" <?php echo $country === 'Nepal' ? 'selected' : ''; ?>>Nepal</option>
                                <option value="Netherlands" <?php echo $country === 'Netherlands' ? 'selected' : ''; ?>>
                                    Netherlands</option>
                                <option value="New Zealand" <?php echo $country === 'New Zealand' ? 'selected' : ''; ?>>
                                    New Zealand</option>
                                <option value="Nigeria" <?php echo $country === 'Nigeria' ? 'selected' : ''; ?>>Nigeria
                                </option>
                                <option value="Norway" <?php echo $country === 'Norway' ? 'selected' : ''; ?>>Norway
                                </option>
                                <option value="Pakistan" <?php echo $country === 'Pakistan' ? 'selected' : ''; ?>>Pakistan
                                </option>
                                <option value="Peru" <?php echo $country === 'Peru' ? 'selected' : ''; ?>>Peru</option>
                                <option value="Philippines" <?php echo $country === 'Philippines' ? 'selected' : ''; ?>>
                                    Philippines</option>
                                <option value="Poland" <?php echo $country === 'Poland' ? 'selected' : ''; ?>>Poland
                                </option>
                                <option value="Portugal" <?php echo $country === 'Portugal' ? 'selected' : ''; ?>>Portugal
                                </option>
                                <option value="Qatar" <?php echo $country === 'Qatar' ? 'selected' : ''; ?>>Qatar</option>
                                <option value="Romania" <?php echo $country === 'Romania' ? 'selected' : ''; ?>>Romania
                                </option>
                                <option value="Russia" <?php echo $country === 'Russia' ? 'selected' : ''; ?>>Russia
                                </option>
                                <option value="Saudi Arabia" <?php echo $country === 'Saudi Arabia' ? 'selected' : ''; ?>>
                                    Saudi Arabia</option>
                                <option value="Singapore" <?php echo $country === 'Singapore' ? 'selected' : ''; ?>>
                                    Singapore</option>
                                <option value="Slovakia" <?php echo $country === 'Slovakia' ? 'selected' : ''; ?>>Slovakia
                                </option>
                                <option value="South Africa" <?php echo $country === 'South Africa' ? 'selected' : ''; ?>>
                                    South Africa</option>
                                <option value="South Korea" <?php echo $country === 'South Korea' ? 'selected' : ''; ?>>
                                    South Korea</option>
                                <option value="Sri Lanka" <?php echo $country === 'Sri Lanka' ? 'selected' : ''; ?>>Sri
                                    Lanka</option>
                                <option value="Sweden" <?php echo $country === 'Sweden' ? 'selected' : ''; ?>>Sweden
                                </option>
                                <option value="Switzerland" <?php echo $country === 'Switzerland' ? 'selected' : ''; ?>>
                                    Switzerland</option>
                                <option value="Taiwan" <?php echo $country === 'Taiwan' ? 'selected' : ''; ?>>Taiwan
                                </option>
                                <option value="Thailand" <?php echo $country === 'Thailand' ? 'selected' : ''; ?>>Thailand
                                </option>
                                <option value="Turkey" <?php echo $country === 'Turkey' ? 'selected' : ''; ?>>Turkey
                                </option>
                                <option value="Ukraine" <?php echo $country === 'Ukraine' ? 'selected' : ''; ?>>Ukraine
                                </option>
                                <option value="United Arab Emirates" <?php echo $country === 'United Arab Emirates' ? 'selected' : ''; ?>>United Arab Emirates</option>
                                <option value="United Kingdom" <?php echo $country === 'United Kingdom' ? 'selected' : ''; ?>>United Kingdom</option>
                                <option value="United States" <?php echo $country === 'United States' ? 'selected' : ''; ?>>United States</option>
                                <option value="Venezuela" <?php echo $country === 'Venezuela' ? 'selected' : ''; ?>>
                                    Venezuela</option>
                                <option value="Vietnam" <?php echo $country === 'Vietnam' ? 'selected' : ''; ?>>Vietnam
                                </option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" id="phone_number" name="phone_number"
                                value="<?php echo htmlspecialchars($phone_number); ?>" maxlength="10" required>
                            <div id="phone-message"></div> <!-- Message div for validation feedback -->
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address"
                                rows="3"><?php echo htmlspecialchars($address); ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea id="bio" name="bio" rows="4"><?php echo htmlspecialchars($bio); ?></textarea>
                            <button type="button" id="emoji-button">😀</button>
                        </div>
                        <div class="button-group">
                            <button type="submit" name="update_info" class="save-btn">Save Changes</button>
                            <button type="button" name="deleteAccountBtn" class="delete-btn"
                                onclick="return confirm('Are you sure you want to delete your account?');">
                                Delete Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bookings-card">
                <h2>Your Bookings</h2>
                <div class="bookings-content">
                    <?php
                    // Add your booking fetching logic here
                    ?>
                    <p class="no-bookings">Details on your recent bookings will appear here.</p>
                </div>
            </div>
        </main>

        <footer class="page-footer">
            <a href="logout.php" class="bye">Logout</a>
            <a href="index.php" class="home-link">Go to Home</a>
        </footer>
    </div>

    <script>
   // Delete account handler
document.getElementById('deleteAccountBtn').addEventListener('click', function() {
    // First confirmation
    const confirmDelete = confirm('Are you sure you want to delete your account? This cannot be undone.');
    
    if (confirmDelete) {
        // Second confirmation with custom styling
        const customConfirm = confirm('Please confirm again. All your data will be permanently deleted.');
        
        if (customConfirm) {
            const formData = new FormData();
            formData.append('delete_account', '1');

            fetch('update_profile.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert(data.message);
                    window.location.href = 'login.php'; // Redirect to login page
                } else {
                    throw new Error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred: ' + error.message);
            });
        }
    }
});

// Profile update handler - add error logging
document.getElementById('profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    if (!validatePhoneNumber()) {
        return;
    }

    const formData = new FormData(this);

    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        // Log the raw response for debugging
        response.clone().text().then(text => console.log('Raw response:', text));
        return response.json();
    })
    .then(data => {
        console.log('Processed data:', data); // Debug log
        if (data.status === "success") {
            alert(data.message);
            return fetch('fetch_profile_data.php');
        } else {
            throw new Error(data.message);
        }
    })
    .then(response => response.json())
    .then(freshData => {
        console.log('Fresh data:', freshData); // Debug log
        // Update form fields
        document.getElementById("name").value = freshData.name;
        document.getElementById("country").value = freshData.country;
        document.getElementById("phone_number").value = freshData.phone_number;
        document.getElementById("address").value = freshData.address;
        document.getElementById("bio").value = freshData.bio;
        
        // Update welcome message
        const welcomeHeader = document.querySelector('.welcome-header h1');
        if (welcomeHeader) {
            welcomeHeader.textContent = `Welcome, ${freshData.name}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    });
});



document.getElementById('profileForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    if (!validatePhoneNumber()) {
        return;
    }

    const formData = new FormData(this);
    
    // Log form data being sent
    for (let pair of formData.entries()) {
        console.log(pair[0] + ': ' + pair[1]);
    }

    fetch('update_profile.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        return response.text().then(text => {
            console.log('Raw response:', text);
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('JSON parse error:', e);
                throw new Error('Invalid JSON response');
            }
        });
    })
    .then(data => {
        console.log('Processed data:', data);
        if (data.status === "success") {
            alert(data.message);
            return fetch('fetch_profile_data.php');
        } else {
            throw new Error(data.message);
        }
    })
    .then(response => response.json())
    .then(freshData => {
        console.log('Fresh data:', freshData);
        // Update form fields
        document.getElementById("name").value = freshData.name;
        document.getElementById("country").value = freshData.country;
        document.getElementById("phone_number").value = freshData.phone_number;
        document.getElementById("address").value = freshData.address;
        document.getElementById("bio").value = freshData.bio;
        
        // Update welcome message
        const welcomeHeader = document.querySelector('.welcome-header h1');
        if (welcomeHeader) {
            welcomeHeader.textContent = `Welcome, ${freshData.name}`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred: ' + error.message);
    });
});
</script>

</body>

</html>