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

// Decode the JSON data from the request body
$data = json_decode(file_get_contents("php://input"));

$id = $data->id;
$name = $data->name;
$category = $data->category;
$price = $data->price;

// Prepare and bind parameters
$stmt = $conn->prepare("UPDATE product SET name=?, category=?, price=? WHERE product_id=?");
$stmt->bind_param("ssdi", $name, $category, $price, $id);

// Execute the update statement
if ($stmt->execute()) {
    echo json_encode(array("message" => "Product updated successfully"));
} else {
    echo json_encode(array("message" => "Failed to update product"));
}

$stmt->close();
$conn->close();
?>
