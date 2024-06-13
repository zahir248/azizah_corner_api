<?php
// Handle CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "order";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to fetch orders
$sql = "SELECT order_id, name, quantity, price, `table`, customer_name, created_at, status FROM order_customer";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Array to hold orders
    $orders = array();

    // Fetch rows and add to orders array
    while($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    // Output orders array as JSON
    echo json_encode($orders);
} else {
    echo "0 results";
}

$conn->close();
?>
