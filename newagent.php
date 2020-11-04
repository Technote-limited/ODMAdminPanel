

<!DOCTYPE html>
<?php require_once 'controllers/authController.php'; ?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!--Bootstrap for css-->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/ bootstrap/4.5.0/css/bootstrap.min.css">
	  <link rel="stylesheet" href="formstyles.css">  
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Oswald">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script> 
    <script src="jquery.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    
<title>Register Agent</title>
<script type="text/javascript">
$(document).ready(function(){
    $('#county').on('change',function(){
        var countyID = $(this).val();
        if(countyID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'county_id='+countyID,
                success:function(html){
                    $('#constituency').html(html);
                   $('#ward').html('<option value="">Select constituency first</option>'); 
                }
            }); 
        }else{
            $('#constituency').html('<option value="">Select county first</option>');
            $('#ward').html('<option value="">Select constituency first</option>'); 
        }
    });
    
    $('#constituency').on('change',function(){
        var constituencyID = $(this).val();
        if(constituencyID){
            $.ajax({
                type:'POST',
                url:'ajaxData.php',
                data:'constituency_id='+constituencyID,
                success:function(html){
                   $('#ward').html(html);
                }
            }); 
        }else{
            $('#ward').html('<option value="">Select constituency first</option>'); 
        }
    });
});
</script>
</head>
<body>
        <div class="col-md-4 offset-md-4 form-div">
        <form action="newagent.php" method="post"> 
        <?php if(count($errors)>0):?>
        <div class="alert alert-danger">
        <?php foreach($errors as $error):?>
            <li><?php  echo $error;?></li>
        <?php endforeach; ?>
        </div>
        <?php endif; ?>

<script>
function getAge() {
  function getAge() {
var dateString = document.getElementById("dob").value;
var birthDate = new Date(dateString);
var today = new Date();
var age = today.getFullYear() - birthDate.getFullYear();
if(age<18){
alert("should be atleast 18years old");
}
 else 
        {
          
        }
}
</script>
<div class="wrapper">
    <div class="title">
      Agent Registration Form
</div>
    <div class="form">
    
       <div class="inputfield">
          <label for = "agentName">Full Name</label>
          <input type="text"  name="agentName" class="input">
       </div>  
        <div class="inputfield">
          <label for = "id_passport">Id/Passport</label>
          <input type="text" name ="id_passport" class="input">
       </div>  
       <div class="inputfield">
          <label for ="member_number">Member Number</label>
          <input type="text" name="member_number" class="input"maxlength="11">
       </div>  
      <div class="inputfield">
          <label for ="phone_number">Phone Number</label>
          <input type="text" name="phone_number" class="input" maxlength="10">
       </div> 
	   <div class="inputfield">
     <label for="dob">Date of Birth</label>
      <input type="date" id="dob" name="dob" class="input" onblur="getAge()">
       </div> 
	   
        <div class="inputfield">
          <label for="gender">Gender</label>
          <div class="custom_select">
            <select name="gender">
              <option value="">Select</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
       </div>
  <div class="select-boxes">
  <?php
    //Include database configuration file
    $conn = new mysqli('localhost','root','','members_project');  
    //Get all country data
    $query = $conn->query("SELECT * FROM county WHERE status = 1 ORDER BY county_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;

    
function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $password = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $password[] = $alphabet[$n];
    }
    return implode($password); //turn the array into a string
}

//cho randomPassword();
?>

    <div class="inputfield">
          <label for="county">County</label>
          <div class="custom_select">
       <select name="county" id="county" >
        <option value="">Select County</option>
        <?php
        if($rowCount > 0){
            while($row = $query->fetch_assoc()){ 
                echo '<option value="'.$row['county_id'].'">'.$row['county_name'].'</option>';
            }
        }else{
            echo '<option value="">County not available</option>';
        }
        ?>
    </select>
    </div>
    </div>
    <div class="inputfield">
          <label for="constituency">Constituency</label>
          <div class="custom_select">
    <select name="constituency" id="constituency">
        <option value="">Select county first</option>
    </select>
    </div>
    </div>
    <div class="inputfield">
          <label for="ward">Ward</label>
          <div class="custom_select">
    <select name="ward" id="ward">
        <option value="">Select constituency first</option>
    </select>
    </div>
    </div>

    <div class="inputfield">
          <label for ="password">Password</label>
          <input type="password" name="password" class="input" >
       </div> 
    </div>
        <div class="form-group">
        <button type="submit" name="register-btn"  class="btn btn-primary btn-block btn-lg">Submit</button>
        </div>
        <p class="text-center"><a href="landing.html">Back to Home</a></p>
        </form>
     

    </div>
</div>
</div>
    
</body>
</html>