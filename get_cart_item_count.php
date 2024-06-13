<?php
// Check if the required parameter is set
if (isset($_GET['customer_id'])) {
    $customerId = $_GET['customer_id'];

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

    // Query to get the count of items in the cart for a specific customer
    $query = "SELECT COUNT(*) AS cart_item_count FROM cart WHERE customer_id = ?";

    // Prepare and bind
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $customerId);

    // Execute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $cartItemCount = $row['cart_item_count'];
        echo $cartItemCount; // Output the count
    } else {
        echo "Error fetching cart item count";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Missing customer_id";
}
?>
