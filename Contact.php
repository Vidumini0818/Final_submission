<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once __DIR__ . '/../includes/db_connection.php';

// Initialize variables
$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get and sanitize form data
    $name = $conn->real_escape_string(trim($_POST['name'] ?? ''));
    $email = $conn->real_escape_string(trim($_POST['email'] ?? ''));
    $phone = $conn->real_escape_string(trim($_POST['phone'] ?? ''));
    $eventType = $conn->real_escape_string(trim($_POST['event_type'] ?? ''));
    $description = $conn->real_escape_string(trim($_POST['description'] ?? ''));

    // Validate inputs
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if (empty($phone)) $errors[] = "Phone number is required";
    if (empty($eventType)) $errors[] = "Event type is required";
    if (empty($description)) $errors[] = "Description is required";

    // If no errors, save to database
    if (empty($errors)) {
        // Using prepared statement with correct column names
        $stmt = $conn->prepare("INSERT INTO contact (Name, Email, Phone_number, Event, Discription) 
                               VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $email, $phone, $eventType, $description);
        
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Error saving your message: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact_page</title>
    <link rel="stylesheet" href="../css/Contact.css">
</head>
<body>

    <div class="search-bar">
        <input type="text" placeholder="Search...">
        <button type="submit">Search</button>
    </div>

    <div class="navbar">
        <img src="../Images/logo2.webp" alt="Logo" width="150" height="150">
        <div class="nav-links">
            <a href="home.php">Home</a>
            <a href="About.php">About</a>
            <a href="Service.php">Services</a>
            <a href="packages.php">Packages</a>
            <a href="Contact.php">Contact</a>
        </div>
        <a href="Login.php">
        <button class="login-button">Login</button>
        </a>
    </div>
    <br><br><br>
    <h1 style="text-align: center;">Contact Us</h1>

    <?php if (!empty($errors)): ?>
        <div style="color: red; text-align: center; margin: 20px; padding: 10px; background: #ffeeee;">
            <?php foreach ($errors as $error): ?>
                <?php echo htmlspecialchars($error); ?><br>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div style="color: green; text-align: center; margin: 20px; padding: 10px; background: #eeffee;">
            Your message has been submitted successfully!
        </div>
    <?php endif; ?>

    <div class="contact-container">
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required 
                       value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="tel" id="phone" name="phone" required
                       value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>
            <div class="form-group">
                <label for="event-type">Event Type:</label>
                <select id="event-type" name="event_type" required>
                    <option value="">Select an event type</option>
                    <option value="Wedding" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] === 'Wedding') ? 'selected' : ''; ?>>Wedding</option>
                    <option value="Birthday" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] === 'Birthday') ? 'selected' : ''; ?>>Birthday</option>
                    <option value="Corporate" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] === 'Corporate') ? 'selected' : ''; ?>>Corporate</option>
                    <option value="Other" <?php echo (isset($_POST['event_type']) && $_POST['event_type'] === 'Other') ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
            </div>
            <button type="submit" class="submit-button">Submit</button>
        </form>
    </div>

    <footer class="footer">
        <div class="footer-content">
            <div class="footer-left">
                <p>Address: 123 Event St, Celebration City, Country</p>
                <p>Contact: 041 224 0220</p>
                <p>Email: <a href="mailto:info@happelowevents.com">info@happelowevents.com</a></p>
            </div>
            <div class="footer-right">
                <a href="https://www.facebook.com" target="_blank">
                    <img src="../Images/icon1.png" alt="Facebook" class="social-icon">
                </a>
                <a href="https://www.instagram.com" target="_blank">
                    <img src="../Images/icon2.jpg" alt="Instagram" class="social-icon">
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="../Images/icon3.png" alt="Twitter" class="social-icon">
                </a>
            </div>
        </div>
    </footer>

</body>
</html>
<?php
// Close connection at the end
if (isset($conn)) {
    $conn->close();
}
?>