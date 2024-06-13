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

// Set default time zone to Kuala Lumpur (Malaysia)
date_default_timezone_set('Asia/Kuala_Lumpur');

// Prepare data from POST request
$customerName = $_POST['customerName'];
$totalPrice = $_POST['totalPrice'];
$tableNumber = $_POST['tableNumber'];
$itemNames = $_POST['itemNames'];
$cartIds = $_POST['cartIds'];
$prices = $_POST['prices']; // This will be a comma-separated string of prices
$quantities = $_POST['quantities']; // This will be a comma-separated string of quantities

// Convert comma-separated quantities and prices strings to arrays
$quantityArray = explode(', ', $quantities);
$priceArray = explode(', ', $prices);

// Split itemNames and cartIds into arrays
$itemNamesArray = explode(', ', $itemNames);
$cartIdsArray = explode(', ', $cartIds);

// Get the current datetime in MySQL format
$currentDateTime = date('Y-m-d H:i:s');

// Insert each item into the database using a loop
$insertSuccess = true; // Flag to track if all inserts are successful

for ($i = 0; $i < count($itemNamesArray); $i++) {
    $itemName = $itemNamesArray[$i];
    $cartId = $cartIdsArray[$i];
    $quantity = $quantityArray[$i];
    $price = $priceArray[$i];

    // SQL query to insert data into database
    $sql = "INSERT INTO order_customer (name, quantity, price, `table`, customer_name, created_at, status)
            VALUES ('$itemName', $quantity, $price, '$tableNumber', '$customerName', '$currentDateTime', 'Diproses')";

    // Attempt to execute the query
    if ($conn->query($sql) !== TRUE) {
        $insertSuccess = false;
        echo "Error inserting record for item: $itemName - " . $conn->error . "<br>";
        break; // Exit loop on first error
    }
}

// Check if all inserts were successful before deleting carts
if ($insertSuccess) {
    // Delete cart items based on cart_ids
    $cartIdsString = implode(', ', $cartIdsArray); // Convert cartIds array to comma-separated string

    $deleteSql = "DELETE FROM cart WHERE cart_id IN ($cartIdsString)";

    if ($conn->query($deleteSql) === TRUE) {
        echo "All cart items deleted successfully<br>";
    } else {
        echo "Error deleting cart items: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
