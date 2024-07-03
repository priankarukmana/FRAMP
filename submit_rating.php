<?php
// Establish database connection
include 'config.php'; // Ensure this file has your database connection settings

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $user_name = filter_input(INPUT_POST, 'user_name', FILTER_SANITIZE_STRING);
    $user_rating = filter_input(INPUT_POST, 'user_rating', FILTER_SANITIZE_NUMBER_INT);
    $user_review = filter_input(INPUT_POST, 'user_review', FILTER_SANITIZE_STRING);

    // Validate input
    if ($product_id === null || !is_numeric($product_id) || $user_name === null || $user_rating === null || $user_review === null) {
        echo json_encode(["status" => "error", "message" => "Invalid input"]);
        exit;
    }

    try {
        // Prepare statement for inserting data
        $stmt = $conn->prepare("
            INSERT INTO review (id, user_name, user_rating, user_review, datetime) 
            VALUES (?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("issi", $product_id, $user_name, $user_rating, $user_review);

        // Execute the statement
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Review submitted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to submit review"]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
