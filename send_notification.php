<?php
// Include database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "housingtax_registry"; // Replace "your_database_name" with your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ownerID = $_POST['tin'];
    $notificationType = $_POST['notificationType'];
    $message = $_POST['message'];

    // SQL query to retrieve user email addresses
    $sql = "SELECT  tin FROM properties";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $tin = $row['tin'];
            // Save notification to the database
            saveNotification($conn, $tin, $notificationType, $message);
        }
        echo "Notifications sent successfully.";
    } else {
        echo "No users found to send notifications.";
    }
}

// Close the database connection
$conn->close();

// Function to save notification to the database
function saveNotification($conn, $tin, $notificationType, $message) {
    $sql = "INSERT INTO properties (tin, notificationType, message) VALUES ('$tin', '$notificationType', '$message')";
    if ($conn->query($sql) === TRUE) {
        // Notification saved successfully
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>
