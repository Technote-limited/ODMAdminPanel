<?php require_once 'controllers/authController.php'; 

if(!isset($_SESSION['id'])){
    header('location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--Bootstrap for css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="card.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Poppins", sans-serif}
body {font-size:16px;}
.w3-half img{margin-bottom:-6px;margin-top:16px;opacity:0.8;cursor:pointer}
.w3-half img:hover{opacity:1}
</style>
 
    
    <title>Home</title>
</head>
<body>
<nav class="w3-sidebar w3-orange w3-collapse w3-top w3-large w3-padding" 
style="z-index:3;width:300px;font-weight:bold;" id="mySidebar"><br>
  <a href="javascript:void(0)" onclick="w3_close()" 
  class="w3-button w3-hide-large w3-display-topleft" 
  style="width:100%;font-size:22px">Close Menu</a>
  <div class="w3-container">
    <h3 class="w3-padding-64"><b>Admin Panel</b></h3>
  </div>
  <div class="w3-bar-block">
    <a href="" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Profile</a> 
    <a href="newagent.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Register Agent</a> 
    <a href="login.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Logout</a> 
  
  </div>
</nav>
<div class="container">
    <div class="row ">
        <div class="col-md-4 offset-md-4 form-div login">

        <?php if(isset($_SESSION['message'])):?>
            <div class = "alert <?php echo $_SESSION['alert-class'];?>">
            <?php
             echo $_SESSION['message'];
             unset($_SESSION['message']);
             unset ($_SESSION['alert-class']);
            ?>
           </div>
        <?php endif; ?>

            <h3>Welcome,  <?php echo $_SESSION['username'];?></h3>
            <!--<a href="index.php?logout=1" class= "logout">logout</a>-->
            
            <?php if(!$_SESSION['verified']): ?>
            <div class="alert alert-warning">
            You need to verify your account.
            Sign in on your email and click on the verification link we just 
            emailed you at <strong> <?php echo $_SESSION['email'];?></strong>
            </div>
            <?php endif; ?>

            <?php if($_SESSION['verified']): ?>
            <button class= "btn btn-block btn-lg btn-primary">I am Verified!</button>
            <?php endif; ?>

            <a href="landing.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Verify later</a> 
    </div>

</div>
</div> 
    
</body>
</html>