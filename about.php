<?php

include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<div class="heading">
   <h3>about us</h3>
   <p> <a href="home.php">home</a> / about </p>
</div>

<section class="about">

   <div class="flex">

      <div class="image">
         <img src="images/why-us.jpg" alt="">
      </div>

      <div class="content">
         <h3>why choose us?</h3>
         <p>FRAMP transforms your wedding souvenir with cutting-edge AI technology, convenience, and the joy of creating enduring memories. Our platform offers couples an intuitive online commerce platform to easily create bespoke wedding souvenirs. From personalized editing services to AI-driven optimization, we're dedicated to delivering high-quality, customized souvenirs that capture the essence of each couple's special day. Let's be with us!.</p>
         <a href="contact.php" class="btn">contact us</a>
      </div>

   </div>

</section>

<section class="reviews">

   <h1 class="title">client's reviews</h1>

   <div class="box-container">

      <div class="box">
         <img src="images/pic11.png" alt="">
         <p>FRAMP made it incredibly easy for us to create unique wedding souvenirs that perfectly reflected our style and theme. The customization options were endless, and the final products exceeded our expectations. Highly recommend!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Monica Angel</h3>
      </div>

      <div class="box">
         <img src="images/pic-2.jpg" alt="">
         <p>As a wedding planner, I'm always on the lookout for innovative solutions for my clients. FRAMP has become my go-to platform for sourcing personalized wedding favors. The convenience and quality of their products are the best, moreover, they also quick in designing and producing. So it enhances my own business effeciency!.</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Fakhira Dhifa</h3>
      </div>

      <div class="box">
         <img src="images/pic-4.jpg" alt="">
         <p>FRAMP truly transformed our wedding memories beautifully that we'll cherish forever. The AI-driven optimization ensured that every detail was perfect, and the process was so simple. Thank you, FRAMP, for making our day even more special!</p>
         <div class="stars">
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star"></i>
            <i class="fas fa-star-half-alt"></i>
         </div>
         <h3>Prianka Ardina</h3>
      </div>

      

   </div>

</section>









<?php include 'footer.php'; ?>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>