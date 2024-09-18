<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Registration</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    /* Basic styling for the form */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }
    .container {
      margin: 20px auto;
      max-width: 400px;
      padding: 25px;
      color: black;
        background-color: #ffffff;
        border: 1px solid #ddd;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    h1 {
        text-align: center;
        margin-bottom: 20px;
    }
    label {
        display: block;
        margin-bottom: 10px;
    }
    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 20px;
        border: 1px solid #ddd;
        border-radius: 5px;
    }
    button {
        width: 100%;
        padding: 10px;
        border: none;
        border-radius: 5px;
        background-color:  rgb(47, 255, 203);
        color: #fff;
        cursor: pointer;
    }
    button:hover {
        background-color: #0056b3;
    }
    p {
            text-align: center;
            margin-top: 20px;
            color: #777;
    }
    .success-message {
        color: green;
        text-align: center;
        margin-top: 10px;
    }
    .error-message {
        color: red;
        text-align: center;
        margin-top: 10px;
    }
    .fa-input {
        position: absolute;
        top: 12px;
        left: 10px;
        color: #999;
    }
    
</style>
</head>
<body>
<div class="container">
    <h1>Register Here</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
       <label for="username"><i class="fa-solid fa-user"></i> Username/Email</label>
        <input type="text" id="username" name="username" placeholder="Enter your username/Email" required>
        <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
        <button type="submit">Create Account</button>
        <p>Already have an account? <a href="login.html">Login</a></p>
      </form>
    <div id="successMessage" class="success-message" style="display:none;"></div>
    <div id="errorMessage" class="error-message" style="display:none;"></div>
</div>
<?php
   // Place the PHP code within PHP tags
   // Database connection and signup logic here
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

       // Check if the user already exists
       $userCheckQuery = "SELECT * FROM users WHERE username='$username'";
       $userCheckResult = $conn->query($userCheckQuery);

       if ($userCheckResult->num_rows > 0) {
           // User already exists
           echo "<p>Registration Failed. User already exists.</p>";
       } else {
           // User does not exist, proceed with registration
           $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
           $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";

           if ($conn->query($insertQuery) === TRUE) {
               echo "<p>Registration Successful!</p>";
               echo '<script>document.getElementById("successMessage").style.display = "block";</script>';
           } else {
               echo "<p>Registration Failed. Please try again later.</p>";
           }
       }
   }

   // Close the database connection
   $conn->close();
   ?>
   <div class="success-message" id="successMessage" style="display:none;">
    Congratulations! Your account has been created successfully.
  </div>
<script>
    function validateForm() {
        var username = document.getElementById('username').value;
        var password = document.getElementById('password').value;
        
        // You can add more validation here if needed
        
        // Example: Check if username is not empty
        if (username.trim() === '') {
            alert('Please enter a username.');
            return false;
        }

        // Example: Check if password is at least 6 characters long
        if (password.length < 6) {
            alert('Password must be at least 6 characters long.');
            return false;
        }

        return true;
    }
</script>
</body>
</html>
