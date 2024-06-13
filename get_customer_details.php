<?php
// Include the database connection file
include 'db_connect.php';

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Check if the customer_id parameter exists
    if (isset($_GET['customer_id'])) {
        // Extract customer_id from the GET parameters
        $customer_id = $_GET['customer_id'];

        // Prepare SQL statement to fetch customer details
        $sql = "SELECT username FROM customer WHERE customer_id = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $customer_id);

        // Execute SQL statement
        if ($stmt->execute()) {
            // Bind result variables
            $stmt->bind_result($username);

            // Fetch single row (assuming customer_id is unique)
            if ($stmt->fetch()) {
                // Return JSON response with customer details
                $response = array(
                    'customer_id' => $customer_id,
                    'username' => $username
                );
                echo json_encode($response);
            } else {
                // Customer not found
                echo json_encode(array('error' => 'Customer not found'));
            }
        } else {
            // Error executing SQL statement
            echo json_encode(array('error' => 'Error executing SQL statement'));
        }

        // Close statement (and leave the connection open for subsequent queries if needed)
        $stmt->close();
    } else {
        // customer_id parameter is missing
        echo json_encode(array('error' => 'customer_id parameter is missing'));
    }
} else {
    // Invalid request method
    echo json_encode(array('error' => 'Invalid request method'));
}

// Close connection
$conn->close();
?>
