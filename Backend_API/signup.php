<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fitness";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Database connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST['full_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? 'user'; // default role is 'user'

    // --- Basic Validation ---
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit();
    }

    if ($password !== $confirm_password) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match."]);
        exit();
    }

    // --- NEW: Server-Side Password Complexity Validation ---
    // 
    $errors = [];
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "Password must include at least one uppercase letter.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        $errors[] = "Password must include at least one lowercase letter.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        $errors[] = "Password must include at least one number.";
    }
    if (!preg_match('/[!@#$%^&*+=?-]/', $password)) {
        $errors[] = "Password must include at least one special character.";
    }

    // If there are any validation errors, combine them into a single message.
    if (!empty($errors)) {
        echo json_encode(["status" => "error", "message" => implode("\n", $errors)]);
        exit();
    }
    // --- END of New Validation ---


    // Validate role (only user/admin allowed)
    if ($role !== "user" && $role !== "admin") {
        $role = "user";
    }

    // IMPORTANT FOR PRODUCTION: You should hash the password for security.
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // And then store $hashed_password in the database.

    $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role, confirm_password) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    // Note: We are now storing the confirmed password as well, as your table requires it.
    $stmt->bind_param("sssss", $full_name, $email, $password, $role, $confirm_password);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => ucfirst($role) . " registered successfully."]);
    } else {
        // Provide a more user-friendly error for duplicate emails
        if (str_contains($stmt->error, "Duplicate entry")) {
            echo json_encode(["status" => "error", "message" => "An account with this email already exists."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
        }
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}

$conn->close();
?>