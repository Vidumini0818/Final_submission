<?php

require_once __DIR__ . '/../includes/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate inputs
    $fullName = $conn->real_escape_string(trim($_POST['fullName']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = trim($_POST['password']);

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO signup (Email, Password, FullName) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $hashedPassword, $fullName);

    if ($stmt->execute()) {
        // Redirect to a success page or home page
        echo "<script>alert('Sign-up successful!'); window.location.href = 'Login.php';</script>";
    } else {
        // Show an error alert
        echo "<script>alert('Failed to sign up. Error: " . $conn->error . "');</script>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/Signup.css">
</head>
<body>
    <div class="signup-container">
        <h1>Sign Up</h1>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error-message">
                <?php 
                    $errors = explode("|", $_GET['error']);
                    foreach ($errors as $error) {
                        echo htmlspecialchars($error) . "<br>";
                    }
                ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success-message">
                Registration successful! <a href="Login.php">Login here</a>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="fullName" placeholder="Full Name" required 
                   value="<?php echo isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : ''; ?>">
            
            <input type="email" name="email" placeholder="Email" required
                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            
            <input type="password" name="password" placeholder="Password" required>
            
            <button type="submit">Sign Up</button>
        </form>
        
        <a href="Login.php" class="login-link">Already have an account? Login here</a>
    </div>
</body>
</html>
<?php
// Close connection only if it exists
if (isset($conn)) {
    $conn->close();
}
?>