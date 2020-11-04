<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--Bootstrap for css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    
    <title>Login</title>
</head>
<body>
<div class="container">
    <div class="row ">
        <div class="col-md-4 offset-md-4 form-div login">
        <form action="login.php" method="post">
        <h3 class ="text-center">Login</h3>

        <?php if(count($errors)>0):?>
        <div class="alert alert-danger">
        <?php foreach($errors as $error):?>
            <li><?php  echo $error;?></li>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <div class="form-group">
        <label for="username">Username or Email</label>
        <input type="text" name="username" value="<?php echo $username; ?>"class="form-control form-control-lg">
        </div>
    
        <div class="form-group">
        <label for="userPassword">Password</label>
        <input type="password" name="userPassword"class="form-control form-control-lg">
        </div>

        <div class="form-group">
        <button type="submit" name="login-btn" class="btn btn-primary btn-block btn-lg">Login</button>
        </div>
        <p class="text-center">Not yet a Member?<a href="signup.php">Sign Up</a></p>
        </form>

    </div>
</div>
</div>
    
</body>
</html>