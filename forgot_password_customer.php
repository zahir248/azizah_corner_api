<?php
// Include database connection
include 'db_connect.php';

// Handling POST request
$data = json_decode(file_get_contents('php://input'), true);

// Validate received data
if (isset($data['username']) && isset($data['email']) && isset($data['password'])) {
    $username = $data['username'];
    $email = $data['email'];
    $new_password = $data['password'];

    // Validate username and email
    $stmt = $conn->prepare("SELECT * FROM customer WHERE username = ? AND email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username and email match found, update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_stmt = $conn->prepare("UPDATE customer SET password = ? WHERE username = ?");
        $update_stmt->bind_param("ss", $hashed_password, $username);

        if ($update_stmt->execute()) {
            // Password updated successfully
            $response = [
                'success' => true,
                'message' => 'Kata Laluan berjaya dikemaskini'
            ];
            echo json_encode($response);
        } else {
            // Failed to update password
            $response = [
                'success' => false,
                'message' => 'Gagal mengemaskini kata laluan'
            ];
            echo json_encode($response);
        }

        $update_stmt->close();
    } else {
        // No matching username and email found
        $response = [
            'success' => false,
            'message' => 'Maklumat pengguna tidak sah'
        ];
        echo json_encode($response);
    }

    $stmt->close();
} else {
    // Invalid data received
    $response = [
        'success' => false,
        'message' => 'Invalid data received'
    ];
    echo json_encode($response);
}

// Close connection (if not already closed by db_connect.php)
$conn->close();
?>
