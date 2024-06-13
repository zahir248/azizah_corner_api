<?php
// Retrieve the username and password from the request
$username = $_POST['username'];
$password = $_POST['password'];

// Assuming you have a database connection
$servername = "localhost";
$username_db = "root";
$password_db = "";
$dbname = "order";

// Create connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to check if the username exists
$sql = "SELECT * FROM user WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Username exists, fetch the hashed password from the database
    $row = $result->fetch_assoc();
    $hashedPassword = $row['password'];

    // Verify the password
    if (password_verify($password, $hashedPassword)) {
        // Password matches
        // You can do further processing here, like setting session variables
        // For now, let's just return a success message
        echo "Login successful";
    } else {
        // Password does not match
        echo "Login failed";
    }
} else {
    // Username does not exist
    echo "Login failed";
}


$conn->close();
?>
