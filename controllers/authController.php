 <?php
 session_start();
 require 'config/db.php';
 require_once 'emailController.php';

 $errors=array();
 $username="";
 $email="";

 //if user clicks on the sign up button
 if(isset($_POST['signup-btn'])){
     $username = $_POST['username'];
     $email = $_POST['email'];
     $userPassword = $_POST['userPassword'];
     $passwordConf = $_POST['passwordConf'];

     //validation
     if(empty($username)){
         $errors['username'] = "Username required";
     }
     if(empty($email)){
        $errors['email'] = "email required";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors['email']="Email address is invalid";
    }
    if(empty($userPassword)){
        $errors['userPassword'] = "Password required";
    }
    if($userPassword !== $passwordConf){
        $errors['userPassword']="The two passwords do not match";
    }

    $emailQuery= "SELECT * FROM users WHERE email =? LIMIT 1" ;
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if($userCount >0){
        $errors['email']="Email already exists";
    }
    if(count($errors)===0){
        $userPassword=password_hash($userPassword,PASSWORD_DEFAULT);
        $token=bin2hex(random_bytes(50));
        $verified=false;

        $sql="INSERT INTO users(username,email,verified,token,userPassword) VALUES(?,?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdss',$username,$email,$verified,$token,$userPassword);
        
        if($stmt->execute()){
            //login user
            $user_id = $conn->insert_id;
            $_SESSION['id'] = $user_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['verified'] = $verified;
        
            //Flash Message
            $_SESSION['message'] = "You are now logged in!";
            $_SESSION['alert-class'] = "alert success";
            header('location: index.php');
            exit();

        }else{
            $errors['db_error']="Database error: Failed to register";
        }
    }
 }
 
  //if user clicks on the register agent button
 if(isset($_POST['register-btn'])){
		$agentName = $_POST['agentName'];
        $id_passport = $_POST['id_passport'];
        $member_number = $_POST['member_number'];
        $phone_number = $_POST['phone_number'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $county = $_POST['county'];
        $constituency = $_POST['constituency'];
        $ward = $_POST['ward'];
		$password = $_POST['password'];
		$password=password_hash($password,PASSWORD_DEFAULT);
		
       
   

     //validation
	 if(empty($agentName)){
           $errors['agentName'] = "Agent name required";
        }
        if(empty($id_passport)){
             $errors['id_passport'] ="id/Passport required";
       }
       if(empty($member_number)){
       $errors['member_number'] = "memberNumber required";
       }
       if(empty($phone_number)){
        $errors['phone_number'] = "Phone Number required";
        }
        if(empty($dob)){
        $errors['dob'] ="Date Of Birth required";
        }
        if(empty($gender)){
             $errors['gender'] = "gender required";
        }
        if(empty($county)){
             $errors['county'] = "county required";
        }
        if(empty($constituency)){
             $errors['constituency'] ="constituency required";
        }
        if(empty($ward)){
             $errors['ward'] = "ward required";
        }
        if(empty($password)){
            $errors['password'] = "password required";
       }
			$memberNumberQuery= "SELECT * FROM agents WHERE member_number =? LIMIT 1" ;
			$idNumberQuery= "SELECT * FROM agents WHERE id_passport =? LIMIT 1" ;
			$stmt = $conn->prepare($memberNumberQuery);
			$stmt = $conn->prepare($idNumberQuery);
			$stmt->bind_param('s',$member_number);
			$stmt->bind_param('s',$id_passport);
			$stmt->execute();
			$result = $stmt->get_result();
			$userCount = $result->num_rows;
			$stmt->close();

    if($userCount >0){
        $errors['member_number']="memberNumber already exists";
		 $errors['id_passport']="ID/Passport already exists";
    }
    if(count($errors)===0){
		
		$stmt = $conn->prepare("insert into agents(agentName, id_passport, member_number, phone_number, dob, gender, county, constituency, ward, password, date_created)
		values(?, ?, ?, ?, ?, ?, ?, ?, ?,?,NOW())");
		$stmt->bind_param('ssssssssss',$agentName, $id_passport, $member_number, $phone_number, $dob, $gender, $county, $constituency, $ward, $password);
        $execval = $stmt->execute();
    
		$stmt->close();
       
        }
		else
		{
            $errors['db_error']="Database error: Failed to register";
        }
    }
 


 //if user clicks on the login button
 if(isset($_POST['login-btn'])){
    $username = $_POST['username'];
    $userPassword = $_POST['userPassword'];
  
    //validation
    if(empty($username)){
        $errors['username'] = "Username required";
    }
   if(empty($userPassword)){
       $errors['userPassword'] = "Password required";
   }
   
   if(count($errors)===0){
    $sql = "SELECT * FROM users WHERE email=? OR username =? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt-> bind_param('ss',$username,$username);
    $stmt->execute();
 
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
 
    if(password_verify($userPassword,$user['userPassword'])){
     $_SESSION['id'] = $user['id'];
     $_SESSION['username'] = $user['username'];
     $_SESSION['email'] = $user['email'];
     $_SESSION['verified'] = $user['verified'];

    // sendVerificationEmail($email,$token);
 
     
             //Flash Message
             $_SESSION['message'] = "You are now logged in!";
             $_SESSION['alert-class'] = "alert success";
             header('location: index.php');
             exit();
 
     
    }else{
        $errors['login_fail']="Wrong Credentials";
    }
   }

 
}
//logout user
if(isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verified']);
    header('location: login.php');
    exit();

}
