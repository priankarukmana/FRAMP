<?php

include 'config.php';

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if($password !== $confirm_password){
        $error_message = "Passwords do not match.";
    } else {
        // Update password in the database
        $hashed_password = md5($password); // You may consider using a stronger hashing algorithm
        $update_password = mysqli_query($conn, "UPDATE `users` SET password = '$hashed_password' WHERE email = '$email'");
        
        if($update_password){
            $success_message = "Password updated successfully.";
        } else {
            $error_message = "Failed to update password. Please try again later.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Reset Password</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php
if(isset($success_message)){
   echo '
   <div class="message success">
      <span>'.$success_message.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
   ';
}elseif(isset($error_message)){
   echo '
   <div class="message error">
      <span>'.$error_message.'</span>
      <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
   </div>
   ';
}
?>

<div class="form-container">

   <form action="" method="post">
      <h3>Reset Password</h3>
      <input type="email" name="email" placeholder="Enter your email" required class="box">
      <input type="password" name="password" placeholder="Enter new password" required class="box">
      <input type="password" name="confirm_password" placeholder="Confirm new password" required class="box">
      <input type="submit" name="submit" value="Reset Password" class="btn">
      <p>Remembered your password? <a href="login.php">Login now</a></p>
   </form>

</div>

</body>
</html>
