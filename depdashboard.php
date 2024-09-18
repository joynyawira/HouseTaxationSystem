<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>House Tax Payment Dashboard</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Basic styling for the dashboard */
    body {
        font-family: Poppins, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5; /* Changed body background color */
    }
    nav {
        max-width: 1300px;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff; /* Changed container background color */
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .header {
        text-align: center;
        margin-bottom: 20px; /* Increased margin bottom for header */
        padding: 20px 0; /* Added padding to header */
        background-color: #007bff; /* Changed header background color */
        color: #fff; /* Changed header text color */
    }
    .menu {
    display: flex;
    justify-content: flex-end; /* Align items to the right */
    margin-bottom: 10px;
    background-color: #f9f9f9;
    padding: 10px 20px;
}
.menu a {
    text-decoration: none;
    color: #333;
    padding: 5px;
    border-radius: 5px;
    transition: background-color 0.3s ease;
    margin-right: 40px; /* Add spacing between menu items */
}
.menu a:hover {
    background-color: #ddd;
}
.menu a.logout:hover {
    background-color: red;
}

    h1 {
        text-align: center;
        margin-bottom: 20px; /* Increased margin bottom for h1 */
        color: #333; /* Changed h1 text color */
    }
 
    h2{
        color:blue;
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
      
    .footer .fa-solid {
        margin-right: 5px; /* Add spacing between the icon and text */
    }
    .view-btn {
    padding: 8px 16px;
    border-radius: 5px;
    background-color: #4caf50;
    color: #fff;
    border: none;
    cursor: pointer;
    text-decoration: none; /* Remove underline from button */
}

.view-btn:hover {
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
.property-list th a,
.property-list td a {
    text-decoration: none; /* Remove underline from links */
    color: inherit; /* Use the default text color */
    transition: color 0.3s; /* Smooth transition for color change */
}

.property-list th a:hover,
.property-list td a:hover {
    color: blue; /* Change color on hover (example: orange) */
}

</style>
</head>
<body>
<nav>
    <div class="header">
        <h1>House Tax Payment System</h1>
    </div>
    <div class="menu">
        <a href="depdashboard.php"><i class="fa-solid fa-house"></i> Home</a>
        <a href="view.html"> Housing</a> 
        <a href="dashboard.html" class="logout"> Logout</a> 
    </div>
</nav>
<div class="container">
  <h2>Registered Property List</h2>
   <div class="property-list">
      <table id="propertyList">
          <thead>
              <tr>
                  <th>Owner Name</th>
                  <th>Owner ID</th>
                  <th>Property Address</th>
                  <th>Property Size</th>
                  <th>property Type</th>
                  <th>Property Image</th>
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
          $sql = "SELECT * FROM properties";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
              // Output data of each row
              while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row["ownerName"] . "</td>";
                  echo "<td>" . $row["ownerID"] . "</td>";
                  echo "<td>" . $row["propertyAddress"] . "</td>";
                  echo "<td>" . $row["propertySize"] . "</td>";
                  echo "<td>" . $row["propertyType"] .  "</td>";
                  echo "<td><a href='propertimage.html?id=" . $row["propertyImage"] ."' target='_blank'>View Property</a></td>";
                  echo "<td><button class='due-btn' onclick='location.href=\"taxstatus.php?id=" . $row["tin"] . "\"&taxStatus'>Due</button></td>";
                  echo "<td>" . $row["tin"] . "</td>";
                  echo "<td><button class='view-btn' onclick='location.href=\"view.html?id=" . $row["action"] . "\"'>View</button></td>";
                  echo "</tr>";
              }
          } else {
              echo "<tr><td colspan='9'>0 results</td></tr>";
          }

          // Close the database connection
          $conn->close();
          ?>
          </tbody>
      </table>
  </div>
</div>
<script>
    // JavaScript to redirect to dashboard.html when logout link is clicked
    document.querySelector('.menu a.logout').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent default link behavior
        window.location.href = 'dashboard.html'; // Redirect to dashboard.html
    });
</script>
</body>
</html>
