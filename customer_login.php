<?php

// Include the database connection file
include 'db_connect.php';

// Retrieve POST data sent from Flutter app
$username = $_POST['username'];
$password = $_POST['password'];

// SQL query to retrieve user from database
$sql = "SELECT customer_id, password FROM customer WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User found, verify password
    $row = $result->fetch_assoc();
    $stored_password = $row['password'];

    // Verify hashed password using password_verify() for secure hashing methods like bcrypt
    if (password_verify($password, $stored_password)) {
        // Passwords match, login successful
        $customer_id = $row['customer_id'];
        $response = array(
            "status" => "success",
            "message" => "Login successful",
            "customer_id" => $customer_id
        );
    } else {
        // Passwords do not match, login unsuccessful
        $response = array(
            "status" => "error",
            "message" => "Login unsuccessful"
        );
    }
} else {
    // No user found with the given username
    $response = array(
        "status" => "error",
        "message" => "Login unsuccessful"
    );
}

// Close statement and database connection
$stmt->close();
$conn->close();

// Send JSON response back to Flutter app
header('Content-Type: application/json');
echo json_encode($response);

?>
