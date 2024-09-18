<?php
// Include database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "housingtax_registry"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$tin = 0;
$errorMessage = "";

// Validate and sanitize user input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tin = $_POST["tin"];
    // Validate user ID input (assuming it's an integer)
    if (filter_var($tin, FILTER_VALIDATE_INT)) {
        $tin = $tin;
    } 
}

// Display error message if validation fails
if (!empty($errorMessage)) {
    echo '<div class="error-message">' . $errorMessage . '</div>';
}

// Fetch notifications only if a valid user ID is provided
if ($tin > 0) {
    // Using prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM properties WHERE tin = ?");
    $stmt->bind_param("i", $tin);
    $stmt->execute();
    $result = $stmt->get_result();

    // Display notifications
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div>";
            echo "<strong>Type:</strong> " . $row["notificationType"] . "<br>";
            echo "<strong>Message:</strong> " . $row["message"] . "<br>";
            echo "</div><hr>";
        }
    } else {
        echo "No notifications.";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
