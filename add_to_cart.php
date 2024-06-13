<?php

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the required parameters are set
    if (isset($_POST['customer_id']) && isset($_POST['name']) && isset($_POST['price'])) {
        // Retrieve product information and customer_id from the request
        $customerId = $_POST['customer_id'];
        $productName = $_POST['name'];
        $productPrice = $_POST['price'];

        // Database connection details
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

        // Prepare SQL statement to insert product into cart table with customer_id
        $stmt = $conn->prepare("INSERT INTO cart (customer_id, name, price) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $customerId, $productName, $productPrice);

        // Execute SQL statement
        if ($stmt->execute() === TRUE) {
            // Product added successfully
            echo "Product added to cart successfully";
        } else {
            // Error inserting product
            echo "Error: " . $stmt->error;
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();
    } else {
        // Required parameters not set
        echo "Error: Missing required parameters";
    }
} else {
    // Invalid request method
    echo "Error: Invalid request method";
}
?>
