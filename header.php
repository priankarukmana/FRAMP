<!-- header.php -->
<?php
// Start session at the beginning if you're using sessions
// session_start();

// Include database connection setup if it's in another file
include 'config.php'; // Assume this file contains your $conn variable initialization

// Ensure $user_id is defined, for example, from a session variable
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Check if $conn is a valid connection and $user_id is not null before using them
// if ($conn && $user_id) {
//     // Your existing code that uses $conn and $user_id goes here
//     // For example, a query using mysqli_query()
// } else {
//     // Handle the case where $conn is not a valid connection or $user_id is null
//     echo "Database connection error or user ID is undefined.";
// }

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header">

   <div class="header-1">
      <div class="flex">
         <div class="share">
            <a href="#" class="fab fa-facebook-f"></a>
            <a href="#" class="fab fa-twitter"></a>
            <a href="#" class="fab fa-instagram"></a>
            <a href="#" class="fab fa-linkedin"></a>
         </div>
         <?php if (!isset($_SESSION['user_id'])): ?>
            <p> <a href="login.php"> Login  </a> | <a href="register.php"> Register</a> </p>
         <?php endif; ?>
      </div>
   </div>

   <div class="header-2">
      <div class="flex">
         <a href="home.php" class="logo">FRAMP. </a>

         <nav class="navbar">
            <a href="home.php">home</a>
            <a href="about.php">about</a>
            <a href="shop.php">shop</a>
            <a href="contact.php">contact</a>
            <a href="orders.php">orders</a>
            <a href="rating.php">review</a>
         </nav>

         <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search_page.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <?php if (isset($_SESSION['user_id'])): ?>
               <?php
               $select_cart_number = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
               $cart_rows_number = mysqli_num_rows($select_cart_number); 
               ?>
               <a href="cart.php"> <i class="fas fa-shopping-cart"></i> <span>(<?php echo $cart_rows_number; ?>)</span> </a>
            <?php endif; ?>
         </div>

         <?php if (isset($_SESSION['user_id'])): ?>
            <div class="user-box">
               <p> Username : <span><?php echo $_SESSION['user_name']; ?></span></p>
               <p> Email : <span><?php echo $_SESSION['user_email']; ?></span></p>
               <a href="logout.php" class="delete-btn">logout</a>
            </div>
         <?php endif; ?>
      </div>
   </div>

</header>
