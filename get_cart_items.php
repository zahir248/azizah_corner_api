<?php
// Database connection details
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$dbname = "order"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get customer_id from the request
$customer_id = isset($_GET['customer_id']) ? $_GET['customer_id'] : 0;

// Query to fetch cart items for the specific customer
$query = "SELECT cart_id, name, price FROM cart WHERE customer_id = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();

$cartItems = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }
}
// Convert to JSON format
echo json_encode($cartItems);

// Close database connection
$stmt->close();
$conn->close();
?>
