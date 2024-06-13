<?php
// Handle CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Include the database connection file
include 'db_connect.php';

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
    echo json_encode(array("message" => "No results found"));
}

$conn->close();
?>
