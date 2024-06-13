<?php
// Include the database connection file
include 'db_connect.php';

// Handling POST request
$data = json_decode(file_get_contents('php://input'), true);

// Validate received data
if (isset($data['username']) && isset($data['email']) && isset($data['password'])) {
    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];

    // Check if username already exists
    $check_stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $result = $check_stmt->get_result();

    if ($result->num_rows > 0) {
        // Username already exists
        $response = [
            'success' => false,
            'message' => 'Username already exists'
        ];
        echo json_encode($response);
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement for insertion
        $insert_stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $insert_stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute SQL statement
        if ($insert_stmt->execute()) {
            // Registration successful
            $response = [
                'success' => true,
                'message' => 'Admin registered successfully'
            ];
            echo json_encode($response);
        } else {
            // Registration failed
            $response = [
                'success' => false,
                'message' => 'Failed to register admin'
            ];
            echo json_encode($response);
        }

        // Close insert statement
        $insert_stmt->close();
    }

    // Close check statement
    $check_stmt->close();
} else {
    // Invalid data received
    $response = [
        'success' => false,
        'message' => 'Invalid data received'
    ];
    echo json_encode($response);
}

// Close database connection
$conn->close();
?>
