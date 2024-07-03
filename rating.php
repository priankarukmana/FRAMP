<?php
include 'config.php';
include 'header.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Handle loading review data
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'load_data') {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Fetch review data
    $query = "SELECT * FROM review WHERE id = '$product_id' ORDER BY review_id DESC";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
        exit;
    }

    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Calculate average rating and count ratings
    $total_reviews = count($data);
    $average_rating = 0;
    $total_five_star = 0;
    $total_four_star = 0;
    $total_three_star = 0;
    $total_two_star = 0;
    $total_one_star = 0;

    foreach ($data as $review) {
        $average_rating += $review['user_rating'];
        switch ($review['user_rating']) {
            case '5':
                $total_five_star++;
                break;
            case '4':
                $total_four_star++;
                break;
            case '3':
                $total_three_star++;
                break;
            case '2':
                $total_two_star++;
                break;
            case '1':
                $total_one_star++;
                break;
        }
    }

    $average_rating = $total_reviews > 0 ? $average_rating / $total_reviews : 0;

    $output = array(
        'average_rating'   => number_format($average_rating, 1),
        'total_reviews'    => $total_reviews,
        'total_five_star'  => $total_five_star,
        'total_four_star'  => $total_four_star,
        'total_three_star' => $total_three_star,
        'total_two_star'   => $total_two_star,
        'total_one_star'   => $total_one_star,
        'review_data'      => $data
    );

    echo json_encode($output);
    exit;
}

// Handle submitting a new review
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_name']) && isset($_POST['user_review']) && isset($_POST['rating_data']) && isset($_POST['product_id'])) {
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_review = mysqli_real_escape_string($conn, $_POST['user_review']);
    $rating_data = mysqli_real_escape_string($conn, $_POST['rating_data']);
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Insert new review into database
    $query = "INSERT INTO review (id, user_name, user_rating, user_review, datetime) VALUES ('$product_id', '$user_name', '$rating_data', '$user_review', NOW())";

    if (mysqli_query($conn, $query)) {
        echo json_encode(['status' => 'success', 'message' => 'Your review and rating have been successfully submitted']);
    } else {
        echo json_encode(['status' => 'error', 'message' => mysqli_error($conn)]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>





<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Product Review System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-5">Product Review System</h1>
        <div class="card mb-3">
            <div class="card-header">Select Product</div>
            <div class="card-body">
                <form id="filter_form">
                    <div class="form-group">
                        <label for="product">Choose a Product:</label>
                        <!-- Main form -->
                        <select class="form-control" id="product" name="product_id">
                            <option value="">Select Product</option>
                            <?php
                            // Fetch products from database
                            $query = "SELECT id, name FROM products";
                            $result = mysqli_query($conn, $query);
                            if ($result) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Show Reviews</button>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Product Review</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating">0.0</span> / 5</b>
                        </h1>
                        <div class="mb-3">
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                        </div>
                        <h3><span id="total_review">0</span> Review</h3>
                    </div>
                    <div class="col-sm-4">
                        <p>
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>
                        </p>
                        <p>
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>
                        </p>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="mt-4 mb-3">Write Review Here</h3>
                        <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5" id="review_content"></div>
    </div>

    <!-- Add Review Modal -->
    <div id="review_modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Submit Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="review_form">
                        <div class="form-group">
                            <label for="review_product">Select Product:</label>
                            <!-- Modal form -->
                            <select class="form-control" id="review_product" name="product_id">
                                <option value="">Select Product</option>
                                <?php
                                // Fetch products from database
                                $query = "SELECT id, name FROM products";
                                $result = mysqli_query($conn, $query);
                                if ($result) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Enter Your Name</label>
                            <input type="text" id="user_name" class="form-control" required />
                        </div>
                        <div class="form-group">
                            <label>Enter Your Review</label>
                            <textarea id="user_review" class="form-control" required></textarea>
                        </div>
                        <div class="form-group text-center mt-4">
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                            <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                        </div>
                        <div class="form-group mt-3 text-center">
                            <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<style>
.progress-label-left {
    float: left;
    margin-right: 0.5em;
    line-height: 1em;
}
.progress-label-right {
    float: right;
    margin-left: 0.3em;
    line-height: 1em;
}
.star-light {
    color: #e9ecef;
}
</style>

<script>
$(document).ready(function(){
    // Show review modal
    $('#add_review').click(function(){
        $('#review_modal').modal('show');
    });

    // Handle star rating hover effect
    $('.submit_star').hover(function(){
        var rating = $(this).data('rating');
        reset_background();
        for (var count = 1; count <= rating; count++) {
            $('#submit_star_' + count).addClass('text-warning');
        }
    });

    // Function to reset star background
    function reset_background() {
        for (var count = 1; count <= 5; count++) {
            $('#submit_star_' + count).removeClass('text-warning');
        }
    }

    // Handle star click event
    $('.submit_star').click(function(){
        var rating = $(this).data('rating');
        $('#user_rating').val(rating);
    });

    // Handle save review button click
    $('#save_review').click(function(){
        var user_name = $('#user_name').val();
        var user_review = $('#user_review').val();
        var rating = $('#user_rating').val();
        var product_id = $('#review_product').val(); // Ensure correct product ID field

        // Validate form data
        if (user_name === '' || user_review === '' || rating === '') {
            alert("Please fill in all fields and give a rating.");
            return false;
        } else {
            // Submit data via AJAX
            $.ajax({
                url: "submit_rating.php",
                method: "POST",
                data: {
                    product_id: product_id,
                    user_name: user_name,
                    user_rating: rating,
                    user_review: user_review
                },
                success: function(data) {
                    // Handle success
                    $('#review_modal').modal('hide');
                    fetch_reviews(product_id); // Assuming this function updates review display
                },
                error: function(xhr, status, error) {
                    // Handle error
                    alert("Error submitting review: " + error);
                }
            });
        }
    });

    // Function to fetch reviews
    function fetch_reviews(product_id) {
        $.ajax({
            url: "fetch_rating.php",
            method: "POST",
            data: { product_id: product_id },
            success: function(data) {
                $('#review_content').html(data); // Update review display
            },
            error: function(xhr, status, error) {
                alert("Error fetching reviews: " + error);
            }
        });
    }
});

</script>


