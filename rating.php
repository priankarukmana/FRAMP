<?php
include 'config.php';
session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>review</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'header.php'; ?>
    <div class="container">
        <h1 class="mt-5 mb-5">Product Review</h1>
        <div class="card mb-3">
            <div class="card-header">Select Product</div>
            <div class="card-body">
                <form id="filter_form">
                    <div class="form-group">
                        <label for="product">Choose a Product:</label>
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

        <div class="card mb-4">
            <div class="card-header">Product Review</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4 text-center">
                        <h1 class="text-warning mt-4 mb-4">
                            <b><span id="average_rating">0.0</span> / 5</b>
                        </h1>
                        <div class="mb-3">
                            <?php
                            // Render stars dynamically
                            for ($i = 1; $i <= 5; $i++) {
                                echo '<i class="fas fa-star star-light mr-1 main_star"></i>';
                            }
                            ?>
                        </div>
                        <h3><span id="total_review">0</span> Review(s)</h3>
                    </div>
                    <div class="col-sm-4">
                        <?php
                        // Render star progress bars dynamically
                        for ($i = 5; $i >= 1; $i--) {
                            echo '<p>';
                            echo '<div class="progress-label-left"><b>' . $i . '</b> <i class="fas fa-star text-warning"></i></div>';
                            echo '<div class="progress-label-right">(<span id="total_' . $i . '_star_review">0</span>)</div>';
                            echo '<div class="progress">';
                            echo '<div class="progress-bar bg-warning" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="' . $i . '_star_progress"></div>';
                            echo '</div>';
                            echo '</p>';
                        }
                        ?>
                    </div>
                    <div class="col-sm-4 text-center">
                        <h3 class="mt-4 mb-3">Write Review Here</h3>
                        <button type="button" name="add_review" id="add_review" class="btn btn-primary">Add Review</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="review_content"></div>
    </div>

    <!-- Review Modal -->
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
                    <h4 class="text-center mt-2 mb-4">
                        <?php
                        // Render stars for review modal dynamically
                        for ($i = 1; $i <= 5; $i++) {
                            echo '<i class="fas fa-star star-light submit_star mr-1" id="submit_star_' . $i . '" data-rating="' . $i . '"></i>';
                        }
                        ?>
                    </h4>
                    <div class="form-group">
                        <input type="hidden" name="rating" id="rating" class="form-control" />
                    </div>
                    <div class="form-group">
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" />
                    </div>
                    <div class="form-group">
                        <textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
                    </div>
                    <div class="form-group text-center mt-4">
                        <button type="button" class="btn btn-primary" id="save_review">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript code to handle form submission and AJAX requests -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){

            // Initialize variables
            var rating_data = 0;

            // Handle click event to show review modal
            $('#add_review').click(function(){
                $('#review_modal').modal('show');
            });

            // Handle mouse enter event for star rating in review modal
            $(document).on('mouseenter', '.submit_star', function(){
                var rating = $(this).data('rating');
                reset_background();
                for(var count = 1; count <= rating; count++){
                    $('#submit_star_'+count).addClass('text-warning');
                }
            });

            // Reset star background colors
            function reset_background(){
                $('.submit_star').removeClass('text-warning');
                $('.submit_star').addClass('star-light');
            }

            // Handle click event for star rating in review modal
            $(document).on('click', '.submit_star', function(){
                rating_data = $(this).data('rating');
            });

            // Handle click event to save review
            $('#save_review').click(function(){
                var user_name = $('#user_name').val();
                var user_review = $('#user_review').val();

                // Validate user input
                if(user_name == '' || user_review == ''){
                    alert("Please Fill Both Fields");
                    return false;
                } else {
                    $.ajax({
                        url: "submit_rating.php",
                        method: "POST",
                        data: {
                            user_name: user_name,
                            user_rating: rating_data,
                            user_review: user_review,
                            product_id: $('#product').val() // Get selected product ID
                        },
                        dataType: "json",
                        success: function(data){
                            $('#review_modal').modal('hide');
                            alert(data.message); // Show success/error message
                            load_rating_data(); // Reload rating data
                        },
                        error: function(jqXHR, textStatus, errorThrown){
                            alert('Error: ' + textStatus + ' - ' + errorThrown);
                        }
                    });
                }
            });

            // Handle form submission for filtering reviews
            $('#filter_form').on('submit', function(event){
                event.preventDefault();
                load_rating_data();
            });

            // Function to load rating data dynamically
            // Load reviews dynamically
            function load_rating_data() {
                var product_id = $('#product').val();
                
                if (product_id == '') {
                    $('#review_content').html('<div class="alert alert-info" role="alert">Please select a product to view reviews.</div>');
                    $('#average_rating').text('0.0');
                    $('#total_review').text('0');

                    for (var i = 5; i >= 1; i--) {
                        $('#total_' + i + '_star_review').text('0');
                        $('#' + i + '_star_progress').css('width', '0%').attr('aria-valuenow', '0');
                    }
                    return;
                }

                $.ajax({
                    url: "fetch_rating.php",
                    method: "POST",
                    data: { product_id: product_id },
                    dataType: "json",
                    success: function(data) {
                        $('#average_rating').text(data.average_rating);
                        $('#total_review').text(data.total_review);

                        $('.main_star').each(function(){
                            var star_count = $(this).index() + 1;
                            $(this).toggleClass('text-warning', star_count <= Math.ceil(data.average_rating));
                        });

                        for (var i = 5; i >= 1; i--) {
                            $('#total_' + i + '_star_review').text(data[i + '_star_review']);
                            $('#' + i + '_star_progress').css('width', (data[i + '_star_review'] / data.total_review * 100) + '%').attr('aria-valuenow', (data[i + '_star_review'] / data.total_review * 100));
                        }

                        var html = '';
                        if (data.review_data.length > 0) {
                            for (var count = 0; count < data.review_data.length; count++) {
                                html += '<div class="row mb-3">';
                                // Adjust the column size for the circle to ensure it does not affect the size of the card container
                                html += '<div class="col-sm-1 d-flex justify-content-center"><div class="rounded-circle bg-danger text-white" style="width: 50px; height: 50px; display: flex; justify-content: center; align-items: center;"><h3 class="text-center" style="margin: 0;">' + data.review_data[count].user_name.charAt(0) + '</h3></div></div>';
                                // Adjust the card container to take the remaining space
                                html += '<div class="col-sm-11">';
                                html += '<div class="card">';
                                html += '<div class="card-header"><b>' + data.review_data[count].user_name + '</b></div>';
                                html += '<div class="card-body">';
                                html += '<div>';
                                for (var star = 1; star <= 5; star++) {
                                    var class_name = '';
                                    if (data.review_data[count].user_rating >= star) {
                                        class_name = 'text-warning';
                                    } else {
                                        class_name = 'star-light';
                                    }
                                    html += '<i class="fas fa-star ' + class_name + ' mr-1"></i>';
                                }
                                html += '</div>';
                                html += '<br />' + data.review_data[count].user_review;
                                html += '</div>';
                                var date = new Date(data.review_data[count].datetime * 1000);
                                var formattedDate = date.toLocaleDateString('en-US', {
                                    year: 'numeric', 
                                    month: 'long', 
                                    day: 'numeric'
                                }) + ', ' + date.toLocaleTimeString('en-US', {
                                    hour: 'numeric', 
                                    minute: 'numeric', 
                                    second: 'numeric', 
                                    hour12: true
                                });
                                html += '<div class="card-footer text-right">On ' + formattedDate + '</div>';

                                html += '</div>';
                                html += '</div>';
                                html += '</div>';
                            }
                        } else {
                            html += '<div class="row mb-3">';
                            html += '<div class="col-sm-12">';
                            html += '<div class="alert alert-info" role="alert">No reviews available for this product.</div>';
                            html += '</div>';
                            html += '</div>';
                        }
                        $('#review_content').html(html);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('Error: ' + textStatus + ' - ' + errorThrown);
                    }
                });
            }


        // Initial load of rating data
        load_rating_data();

        // Adjust z-index for user-box to ensure it's in front when user clicks on user-btn
        $('#user-btn').click(function() {
            $('.user-box').css('z-index', '1200'); // Set higher z-index for user-box
        });

        // Reset z-index when user-box is closed
        $('#user-btn').on('hidden.bs.dropdown', function () {
            $('.user-box').css('z-index', 'auto'); // Reset z-index to auto when user-box is hidden
        });

    });
</script>

    <?php include 'footer.php'; ?>

    <!-- custom js file link  -->
    <script src="js/script.js"></script>
</body>
</html>
