<?php
// Establish database connection
include 'config.php'; // Ensure this file has your database connection settings

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    
    if ($product_id === null || !is_numeric($product_id)) {
        echo json_encode(["status" => "error", "message" => "Invalid product ID"]);
        exit;
    }

    try {
        // Use PDO for the database connection from config.php
        global $pdo;

        // Fetch average rating and review count
        $stmt = $pdo->prepare("
            SELECT 
                AVG(user_rating) as average_rating, 
                COUNT(*) as total_review 
            FROM review 
            WHERE id = :product_id
        ");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $rating_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch review counts for each star rating
        $star_rating_data = [];
        for ($i = 1; $i <= 5; $i++) {
            $stmt = $pdo->prepare("
                SELECT COUNT(*) as count 
                FROM review 
                WHERE id = :product_id 
                AND user_rating = :rating
            ");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->bindParam(':rating', $i, PDO::PARAM_INT);
            $stmt->execute();
            $star_rating_data[$i . '_star_review'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        }

        // Fetch review details ordered by datetime in descending order
        $stmt = $pdo->prepare("
            SELECT user_name, user_rating, user_review, datetime 
            FROM review 
            WHERE id = :product_id
            ORDER BY datetime DESC
        ");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();
        $review_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Prepare response
        $response = [
            'average_rating' => round($rating_data['average_rating'], 1),
            'total_review' => $rating_data['total_review']
        ];

        $response = array_merge($response, $star_rating_data);
        $response['review_data'] = $review_data;

        echo json_encode($response);

    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>
