<?php
// Database connection credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "housingtax_registry";

// Establish database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables for messages
$successMessage = "";
$errorMessage = "";

// Process form submission
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ownerName = $_POST["ownerName"];
    $ownerID = $_POST["ownerID"];
    $propertyAddress = $_POST["propertyAddress"];
    $propertySize = $_POST["propertySize"];
    $propertyType = $_POST["propertyType"];
    $taxStatus = $_POST["taxStatus"];

    // File upload handling for ID image
    $idImageName = $_FILES["idImage"]["name"];
    $idImageTemp = $_FILES["idImage"]["tmp_name"];
    $idImageDestination = "uploads/" . $idImageName;

    // Move uploaded file to destination folder
    if (move_uploaded_file($idImageTemp, $idImageDestination)) {
        // Example of generating a Tax Identification Number (TIN)
        $tin = generateTIN();

        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO properties (ownerName, ownerID, propertyAddress, propertySize, propertyType, taxStatus, idImage, tin) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("ssssssss", $ownerName, $ownerID, $propertyAddress, $propertySize, $propertyType, $taxStatus, $idImageDestination, $tin);

            // Execute the statement
            if ($stmt->execute()) {
                $successMessage = "Property registered successfully. Your Tax Identification Number (TIN) is: $tin";
                // Encode the success message for URL
                $encodedMessage = urlencode($successMessage);
                // Redirect with success message as parameter
                header("Location: registered_land.php?success_message=$encodedMessage");
                exit();
            } else {
                $errorMessage = "Error executing SQL statement: " . $stmt->error;
            }

            // Close the prepared statement
            $stmt->close();
        } else {
            $errorMessage = "Error preparing SQL statement: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();

// Function to generate a random Tax Identification Number (TIN)
function generateTIN() {
    return "TIN" . rand(100000, 999999); // Generates a random TIN (e.g., TIN123456)
}
?>
