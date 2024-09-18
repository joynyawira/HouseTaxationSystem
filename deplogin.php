<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "taxlogin_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Validate input
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);

    // Check user credentials
    $loginQuery = "SELECT * FROM users WHERE username='$username'";
    $loginResult = $conn->query($loginQuery);

    if ($loginResult->num_rows == 1) {
        $row = $loginResult->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Login successful, redirect to dashboard or home page
            header("Location: depdashboard.php");
            exit();
        } else {
            echo "<p class='error-message'>Invalid password.</p>";
        }
    } else {
        echo "<p class='error-message'>User not found.</p>";
    }
}

// Close the database connection
$conn->close();
?>
