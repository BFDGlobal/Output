<?php
// Database connection
$servername = "localhost";
$username = "root"; // Default XAMPP username is 'root'
$password = ""; // Default XAMPP password is empty
$dbname = "daily_target_system"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Sanitize user input to prevent SQL Injection
    $user = $conn->real_escape_string($user);
    $pass = $conn->real_escape_string($pass);

    // Check if user exists in the database
    $sql = "SELECT * FROM users WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Check if the password matches
        if ($pass === $row['password']) {
            // Start a session and store the user information (optional)
            session_start();
            $_SESSION['username'] = $user;

            // Redirect to the admin page
            header("Location: admin.php");
            exit; // Don't forget to call exit after header to stop script execution
        } else {
            echo "Incorrect password!";
        }
    } else {
        echo "Username not found!";
    }
}

$conn->close();
?>
