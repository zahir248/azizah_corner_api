<?php
// Include the database connection file
include 'db_connect.php';

// Get the raw POST data
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (isset($data['order_id']) && isset($data['status'])) {
    $order_id = $data['order_id'];
    $status = $data['status'];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE order_customer SET status = ? WHERE order_id = ?");
    $stmt->bind_param("si", $status, $order_id);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        $response = array("status" => "success", "message" => "Order status updated successfully");
    } else {
        $response = array("status" => "error", "message" => "Failed to update order status");
    }

    // Close the statement
    $stmt->close();
} else {
    $response = array("status" => "error", "message" => "Invalid input");
}

// Close the database connection
$conn->close();

// Set the content type to JSON and output the response
header('Content-Type: application/json');
echo json_encode($response);
?>
