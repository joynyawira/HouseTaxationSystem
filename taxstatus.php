<?php
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

// Assuming you receive the TIN and payment status from the payment gateway notification
$tin = $_POST['tin']; // Adjust this based on your notification data
$payment_status = $_POST['payment_status']; // Adjust this based on your notification data

if ($payment_status == 'success') {
    // Update the tax status to "Paid" in the database
    $update_sql = "UPDATE properties SET taxStatus = 'Paid' WHERE tin = '$tin'";
    if ($conn->query($update_sql) === TRUE) {
        echo "Tax status updated successfully to Paid.";
    } else {
        echo "Error updating tax status: " . $conn->error;
    }
}

$conn->close();
?>
