<?php
// Establish database connection
include 'config.php'; // Ensure this file has your database connection settings

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);

    try {
        if ($product_id === '') {
            // If "Select Product" is chosen, fetch reviews for all products
            $stmt = $pdo->query("
                SELECT 
                    AVG(user_rating) as average_rating, 
                    COUNT(*) as total_review
                FROM review
            ");
        } else {
            // Fetch reviews for the selected product
            $stmt = $pdo->prepare("
                SELECT 
                    AVG(user_rating) as average_rating, 
                    COUNT(*) as total_review
                FROM review 
                WHERE id = :product_id
            ");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Fetch the average rating and total reviews
        $rating_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch star rating breakdown
        $star_rating_data = [];
        for ($i = 1; $i <= 5; $i++) {
            if ($product_id === '') {
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM review 
                    WHERE user_rating = :rating
                ");
            } else {
                $stmt = $pdo->prepare("
                    SELECT COUNT(*) as count 
                    FROM review 
                    WHERE id = :product_id 
                    AND user_rating = :rating
                ");
                $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            }
            $stmt->bindParam(':rating', $i, PDO::PARAM_INT);
            $stmt->execute();
            $star_rating_data[$i . '_star_review'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];
        }

        // Fetch review details, sorted by datetime
        if ($product_id === '') {
            $stmt = $pdo->query("
                SELECT r.user_name, r.user_rating, r.user_review, r.datetime, p.name as product_name 
                FROM review r
                JOIN products p ON r.id = p.id
                ORDER BY r.datetime DESC
            ");
        } else {
            $stmt = $pdo->prepare("
                SELECT user_name, user_rating, user_review, datetime, p.name as product_name 
                FROM review r
                JOIN products p ON r.id = p.id
                WHERE r.id = :product_id
                ORDER BY r.datetime DESC
            ");
            $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
            $stmt->execute();
        }

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
