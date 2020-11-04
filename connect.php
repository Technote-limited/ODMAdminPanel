<?php
 $conn = new mysqli('localhost','root','','members_project');


 if($conn->connect_error){
    echo "$conn->connect_error";
    die("Connection Failed : ". $conn->connect_error);
} 
else {
    $errors=array();
    if(isset($_POST['register-btn'])){
        $agentName = $_POST['agentName'];
        $idPassport = $_POST['idPassport'];
        $memberNumber = $_POST['memberNumber'];
        $phoneNumber = $_POST['phoneNumber'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $county = $_POST['county'];
        $constituency = $_POST['constituency'];
        $ward = $_POST['ward'];
    
         //validation
         if(empty($agentName)){
            echo "Agent name required";
        }
        if(empty($idPassport)){
             echo "id/Passport required";
       }
       if(empty($memberNumber)){
          echo "memberNumber required";
       }
       if(empty($phoneNumber)){
        echo "Phone Number required";
        }
        if(empty($dob)){
        echo "Date Of Birth required";
        }
        if(empty($gender)){
            echo "gender required";
        }
       
        if(empty($county)){
            echo "county required";
        }
        if(empty($constituency)){
            echo "constituency required";
        }
        if(empty($ward)){
            echo  "ward required";
        }
     
        
    }
    else{
        
          
          
    $stmt = $conn->prepare("insert into agents(agentName, idPassport, memberNumber, phoneNumber, dob, 
    gender, county, constituency, ward,date_created)
     values(?, ?, ?, ?, ?, ?, ?, ?, ?,NOW())");
     $stmt->bind_param("sssssssss",$agentName, $idPassport, $memberNumber, $phoneNumber,
    $dob, $gender, $county, $constituency, $ward);
    $execval = $stmt->execute();
    echo $execval;
    $stmt->close();
    $conn->close();

    }


}
  
   
?>