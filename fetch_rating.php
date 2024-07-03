<?php
// Establish database connection
$host = 'localhost';
$dbname = 'shop';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize product_id
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);

    if ($product_id === null || !is_numeric($product_id)) {
        die("Error: Invalid product ID");
    }

    try {
        // Prepare SQL statement to fetch reviews for the selected product
        $stmt_reviews = $pdo->prepare("
            SELECT user_name, user_rating, user_review, datetime 
            FROM review 
            WHERE id = :product_id
            ORDER BY datetime DESC
        ");
        $stmt_reviews->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt_reviews->execute();
        $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

        // Display reviews
        if (count($reviews) > 0) {
            echo "<h2>Reviews for Selected Product</h2>";
            echo "<ul>";
            foreach ($reviews as $review) {
                echo "<li>";
                echo "<strong>User: </strong>" . htmlspecialchars($review['user_name']) . "<br>";
                echo "<strong>Rating: </strong>" . htmlspecialchars($review['user_rating']) . "<br>";
                echo "<strong>Review: </strong>" . htmlspecialchars($review['user_review']) . "<br>";
                echo "<strong>Date: </strong>" . htmlspecialchars($review['datetime']) . "<br>";
                echo "</li>";
            }
            echo "</ul>";
        } else {
            echo "No reviews found for the selected product.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Error: Invalid request method.";
}
?>
