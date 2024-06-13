<?php

// Include the database connection file
include 'db_connect.php';

// Get post data
$data = json_decode(file_get_contents('php://input'), true);

$name = $data['name'];
$category = $data['category'];
$price = $data['price'];
$image = base64_decode($data['image']); // Decode base64 image data

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO product (name, category, price, image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $name, $category, $price, $image);

// Execute
if ($stmt->execute() === TRUE) {
  echo "Product added successfully";
} else {
  echo "Error: " . $conn->error;
}

// Close connection
$stmt->close();
$conn->close();

?>
