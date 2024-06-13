<?php
// Include the database connection file
include 'db_connect.php';

// Get the JSON data from the request
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['id'];
$base64Image = $data['image'];

// Decode the base64 image data
$imageData = base64_decode($base64Image);

// Update the product record in the database
$stmt = $conn->prepare("UPDATE product SET image = ? WHERE product_id = ?");
$stmt->bind_param('si', $imageData, $productId); // 's' for string, 'i' for integer

if ($stmt->execute()) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>
