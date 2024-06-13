<?php
// Connection parameters
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
