
<?php
// Include the database connection file
include 'C:/xampp/htdocs/project/includes/db_connection.php';

// Check if a session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize form data
    $email = sanitize_input($conn, $_POST['email']);
    $password = sanitize_input($conn, $_POST['password']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Prepare SQL to fetch user
    $sql = "SELECT Email,Password FROM signup WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['Password'])) {
            // Set session variables and redirect to home page
            $_SESSION['email'] = $user['Email'];
            header("Location: about.php"); // Redirect to the home page
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with this email.";
    }

    $stmt->close();
}

// Close the database connection
$conn->close();

// Function to sanitize user input
if (!function_exists('sanitize_input')) {
    function sanitize_input($conn, $data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $conn->real_escape_string($data);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
    </head>
    <body>
    <div class="login-container">
        <h1>Login</h1>
        <form>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <a href="signup.php" class="signup-link">Don't have an account? Sign up</a>
        <a href="home.php" class="home-button">Go to Home Page</a>    </div>
    </body>
    </html>