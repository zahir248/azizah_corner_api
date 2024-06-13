<?php

// Include the database connection file
include 'db_connect.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON data sent in the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if the product ID is set in the JSON data
    if (isset($data->id)) {
        // Extract the product ID
        $productId = $data->id;

        // SQL statement to delete a product with the given ID
        $sql = "DELETE FROM product WHERE product_id = ?";

        // Prepare the statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);

        // Execute the SQL statement
        if ($stmt->execute()) {
            // Product deleted successfully
            echo json_encode(array("message" => "Product deleted successfully"));
        } else {
            // Failed to delete product
            echo json_encode(array("message" => "Failed to delete product"));
        }

        // Close the statement
        $stmt->close();
    } else {
        // Product ID is not set in the request
        echo json_encode(array("message" => "Product ID is required"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}

// Close the database connection
$conn->close();

?>
