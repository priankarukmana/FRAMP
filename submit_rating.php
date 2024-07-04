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
        // Use PDO for the database connection from config.php
        global $pdo;

        // Prepare statement for inserting data
        $stmt = $pdo->prepare("
            INSERT INTO review (id, user_name, user_rating, user_review, datetime) 
            VALUES (:product_id, :user_name, :user_rating, :user_review, :datetime)
        ");
        
        $datetime = time(); // Current UNIX timestamp

        // Bind parameters
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
        $stmt->bindParam(':user_rating', $user_rating, PDO::PARAM_INT);
        $stmt->bindParam(':user_review', $user_review, PDO::PARAM_STR);
        $stmt->bindParam(':datetime', $datetime, PDO::PARAM_INT);

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
