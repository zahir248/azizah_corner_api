<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if the cart_id and customer_id parameters exist
    if (isset($_POST['cart_id']) && isset($_POST['customer_id'])) {
        // Extract cart_id and customer_id from the POST parameters
        $cart_id = $_POST['cart_id'];
        $customer_id = $_POST['customer_id'];

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

        // Prepare SQL statement to delete cart item for specific customer
        $sql = "DELETE FROM cart WHERE cart_id = ? AND customer_id = ?";
        
        // Prepare statement
        $stmt = $conn->prepare($sql);
        
        // Bind parameters
        $stmt->bind_param("ii", $cart_id, $customer_id);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Check if any row was affected
            if ($stmt->affected_rows > 0) {
                // Cart item deleted successfully
                echo json_encode(["success" => true, "message" => "Cart item deleted successfully"]);
            } else {
                // No rows affected, cart item not found
                echo json_encode(["success" => false, "message" => "Failed to delete item or item not found"]);
            }
        } else {
            // Error executing SQL statement
            echo json_encode(["success" => false, "message" => "Error deleting cart item: " . $stmt->error]);
        }

        // Close statement
        $stmt->close();

        // Close connection
        $conn->close();
    } else {
        // cart_id or customer_id parameter is missing
        echo json_encode(["success" => false, "message" => "cart_id or customer_id parameter is missing"]);
    }
} else {
    // Invalid request method
    echo json_encode(["success" => false, "message" => "Invalid request method"]);
}

?>
