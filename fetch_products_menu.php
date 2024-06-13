<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "order";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT product_id, name, price, category, image FROM product"; // Include image column
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $products = array();
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Convert image data to Base64
        $image_base64 = base64_encode($row['image']);
        // Include image data in the product array
        $row['image'] = $image_base64;
        $products[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($products);
} else {
    echo "0 results";
}
$conn->close();

?>
