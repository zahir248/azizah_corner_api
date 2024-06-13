<?php

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON data sent in the request body
    $data = json_decode(file_get_contents("php://input"));

    // Check if the product ID is set in the JSON data
    if (isset($data->id)) {
        // Extract the product ID
        $productId = $data->id;

        // Your database connection code (replace with your own)
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

        // SQL statement to delete a product with the given ID
        $sql = "DELETE FROM product WHERE product_id = $productId";

        // Execute the SQL statement
        if ($conn->query($sql) === TRUE) {
            // Product deleted successfully
            echo json_encode(array("message" => "Product deleted successfully"));
        } else {
            // Failed to delete product
            echo json_encode(array("message" => "Failed to delete product"));
        }

        // Close the database connection
        $conn->close();
    } else {
        // Product ID is not set in the request
        echo json_encode(array("message" => "Product ID is required"));
    }
} else {
    // Invalid request method
    echo json_encode(array("message" => "Invalid request method"));
}

?>
