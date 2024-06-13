<?php
header('Content-Type: application/json');

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

// Fetch products from the database
$sql = "SELECT product_id, name, price, category, image FROM product";
$result = $conn->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $row['image_url'] = 'data:image/jpeg;base64,' . base64_encode($row['image']); // Convert image to base64
        unset($row['image']); // Remove binary image data from response
        array_push($products, $row);
    }
} else {
    echo json_encode(array('message' => 'No products found'));
    exit();
}

$conn->close();

echo json_encode($products);
?>
