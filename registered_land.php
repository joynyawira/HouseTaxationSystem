<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Property List</title>
<style>
    /* Basic styling for the property list page */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }
    .container {
        max-width: 1200px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1{
      color:blue;
    }
    .property-list {
        margin-bottom: 20px;
    }
    .property-list table {
        width: 100%;
        border-collapse: collapse;
    }
    .property-list th, .property-list td {
        padding: 10px;
        border: 1px solid #ddd;
    }
    .property-list th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }
    .property-list th a,
.property-list td a {
    text-decoration: none; /* Remove underline from links */
    color: inherit; /* Use the default text color */
}
.pay-now-btn {
    padding: 8px 16px;
    border-radius: 5px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    cursor: pointer;
    text-decoration: none; /* Remove underline from button */
}

.pay-now-btn:hover {
    background-color: #45a049;
}
.due-btn {
    padding: 8px 16px;
    border-radius: 5px;
    background-color: #e53935; /* Red color for due */
    color: #fff;
    border: none;
    cursor: not-allowed; /* Change cursor to indicate non-clickable */
    text-decoration: none; /* Remove underline from button */
}

.due-btn:hover {
    background-color: #c62828; /* Darker red color on hover */
}

    .search-form {
        margin-bottom: 20px;
    }
    .search-form input[type="text"], .search-form select {
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 200px;
        margin-right: 10px;
    }
    .search-form button {
        padding: 8px 16px;
        border-radius: 5px;
        background-color: #4caf50;
        color: #fff;
        border: none;
        cursor: pointer;
    }
    .search-form button:hover {
        background-color: #45a049;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Registered Property List</h1>
     <div class="property-list">
        <table id="propertyList">
            <thead>
                <tr>
                    <th>Owner Name</th>
                    <th>Owner ID</th>
                    <th>property Type</th>
                    <th>Tax Status</th>
                    <th>Tax Identification Number</th>
                    <th>Action</th>
                </tr>
            </thead>
            <?php
            // Establish a connection to your database
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

            // Fetch registered property details from the database
            $sql = "SELECT DISTINCT ownerName, ownerID, propertyType, tin,action FROM properties";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["ownerName"] . "</td>";
                    echo "<td>" . $row["ownerID"] . "</td>";
                    echo "<td>" . $row["propertyType"] .  "</td>";
                    echo "<td><button class='due-btn' onclick='location.href=\"taxstatus.php?id=" . $row["tin"] . "\"&taxStatus'>Due</button></td>";
                    echo "<td>" . $row["tin"] . "</td>";
                    echo "<td><button class='pay-now-btn' onclick='location.href=\"taxassessment.html?id=" . $row["action"] . "\"'>Pay Now</button></td>";
                    echo "</tr>";

                    
            // Update previous owner details
            $previousOwnerName = $row["ownerName"];
            $previousOwnerID = $row["ownerID"];
                }
            } else {
                echo "<tr><td colspan='5'>0 results</td></tr>";
            }

            // Close the database connection
            $conn->close();
            ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    // Function to populate property list based on search criteria
    function searchProperties() {
        const ownerName = document.getElementById('ownerName').value.trim();
        const ownerID = document.getElementById('ownerID').value.trim();
        const taxStatus = document.getElementById('taxStatus').value.trim();
        const tin = document.getElementById('tin').value.trim();

        const filteredProperties = properties.filter(property => {
            return (ownerName === '' || property.owner.toLowerCase().includes(ownerName.toLowerCase())) &&
                   (ownerID === '' || property.id.toString() === ownerID) &&
                   (taxStatus === '' || property.status === taxStatus) &&
                   (tin === '' || property.tin.toLowerCase().includes(tin.toLowerCase()));
        });

        displayProperties(filteredProperties);
    }

    // Function to display filtered properties in the table
    function displayProperties(properties) {
        const propertyListBody = document.getElementById('propertyListBody');
        propertyListBody.innerHTML = '';

        properties.forEach(property => {
            const row = `
                <tr>
                    <td>${property.owner}</td>
                    <td>${property.id}</td>
                    <td>${property.status}</td>
                    <td>${property.tin}</td>
                </tr>
            `;
            propertyListBody.innerHTML += row;
        });
    }

    
    // Initial display of all properties
    displayProperties(properties);
</script>
</body>
</html>
