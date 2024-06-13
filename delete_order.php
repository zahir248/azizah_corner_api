<?php

// Include the database connection file
include 'db_connect.php';

// Ensure the request method is DELETE
if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Decode the JSON data sent in the request body
    $input = json_decode(file_get_contents("php://input"), true);

    // Check if the order ID is set in the JSON data
    if (isset($input['order_id'])) {
        $order_id = $input['order_id'];

        // Prepare SQL statement to delete order
        $sql = "DELETE FROM order_customer WHERE order_id = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $order_id); // 'i' indicates integer type for order_id

        if ($stmt->execute()) {
            // Order deleted successfully
            http_response_code(200); // OK
            echo json_encode(array('message' => 'Order deleted successfully.'));
        } else {
            // Error deleting order
            http_response_code(500); // Internal Server Error
            echo json_encode(array('message' => 'Error deleting order: ' . $stmt->error));
        }

        $stmt->close();
    } else {
        // Order ID is not provided in the request
        http_response_code(400); // Bad Request
        echo json_encode(array('message' => 'Order ID is required.'));
    }
} else {
    // Invalid request method
    http_response_code(405); // Method Not Allowed
    echo json_encode(array('message' => 'Method not allowed.'));
}

// Close connection
$conn->close();

?>
