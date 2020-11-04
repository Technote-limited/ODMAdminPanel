<?php
// Include config file
require_once "dbconfig.php";
 
// Define variables and initialize with empty values
$agentName = $id_passport = $member_number = $phone_number = $dob = $gender = $county =$constituency = $ward ="";
$agentName_err = $id_passport_err = $member_number_err = $phone_number_err = $dob_err = $gender_err = $county_err =$constituency_err = $ward_err ="";

 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_name = trim($_POST["agentName"]);
    if(empty($input_name)){
        $agentName_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $agentName_err = "Please enter a valid name.";
    } else{
        $agentName = $input_name;
    }
    
    // Validate id_passport
    $input_idPassport = trim($_POST["id_passport"]);
    if(empty($input_idPassport)){
        $id_passport = "Please enter an ID or passport number.";     
    } else{
        $id_passport = $input_idPassport;
    }
    
    // Validate member_number
    $input_member_number = trim($_POST["member_number"]);
    if(empty($input_member_number)){
        $member_number_err = "Please enter the member_number.";     
    }
    else{
        $member_number = $input_member_number;
    }
    // Validate phone_number
    $input_phone_number = trim($_POST["phone_number"]);
    if(empty($input_phone_number)){
        $phone_number_err = "Please enter the phone_number.";     
    }
    else{
        $phone_number = $input_phone_number;
    }

    // Validate DOB
    $input_dob = trim($_POST["dob"]);
    if(empty($input_dob)){
        $dob_err = "Please enter the dob.";     
    }
    else{
        $dob = $input_dob;
    }
    // Validate Gender
    $input_gender = trim($_POST["gender"]);
    if(empty($input_gender)){
        $gender_err= "Please enter the gender.";     
    }
    else{
        $gender = $input_gender;
    }

    // Validate County
    $input_county = trim($_POST["county"]);
    if(empty($input_county)){
        $county_err = "Please enter the County.";     
    }
    else{
        $county = $input_county;
    }
    // Validate Constituency
    $input_constituency = trim($_POST["constituency"]);
    if(empty($input_constituency)){
        $constituency_err = "Please enter the Constituency.";     
    }
    else{
        $constituency = $input_constituency;
    }

    // Validate Ward
    $input_ward = trim($_POST["ward"]);
    if(empty($input_ward)){
        $ward_err = "Please enter the Ward.";     
    }
    else{
        $ward = $input_ward;
    }

    
    // Check input errors before inserting in database
    if(empty($agentName_err) && empty($id_passport_err) && empty($member_number_err) 
    && empty($phone_number_err)&& empty($dob_err)&& empty($gender_err)&& empty($county_err)
    && empty($constituency_err)&& empty($ward_err)){
        // Prepare an update statement
        $sql = "UPDATE agents SET agentName=?, id_passport=?, member_number=?, phone_number=?, dob=?, gender=?, county=?, constituency=?, ward=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "isssssssss",$param_id, $param_name, $param_id_passport, $param_member_number, $param_phone_number,$param_dob,$param_gender,$param_county,$param_constituency,$param_ward);
            
            // Set parameters
            $param_id = $id;
            $param_name = $agentName;
            $param_id_passport = $id_passport;
            $param_member_number = $member_number;
            $param_phone_number = $phone_number;
            $param_dob = $dob;
            $param_gender = $gender;
            $param_county = $county;
            $param_constituency = $constituency;
            $param_ward = $ward;

           
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: agent.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM agents WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. 
                    Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $agentName = $row["agentName"];
                    $id_passport = $row["id_passport"];
                    $member_number = $row["member_number"];
                    $phone_number = $row["phone_number"];
                    $dob = $row["dob"];
                    $gender = $row["gender"];
                    $county = $row["county"];
                    $constituency = $row["constituency"];
                    $ward = $row["ward"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Agent Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Edit Agent Details</h2>
                    </div>
                    <p>Please submit the details to update the agent details.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($agentName_err)) ? 'has-error' : ''; ?>">
                            <label>Agent Name</label>
                            <input type="text" name="agentName" class="form-control" value="<?php echo $agentName; ?>">
                            <span class="help-block"><?php echo $agentName_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($id_passport_err)) ? 'has-error' : ''; ?>">
                            <label>ID/Passport</label>
                            <input type="text" name="id_passport" class="form-control" value = "<?php echo $id_passport; ?>">
                            <span class="help-block"><?php echo $id_passport_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($member_number)) ? 'has-error' : ''; ?>">
                            <label>Member Number</label>
                            <input type="text" name="member_number" class="form-control" value="<?php echo $member_number; ?>">
                            <span class="help-block"><?php echo $member_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($phone_number)) ? 'has-error' : ''; ?>">
                            <label>Phone Number</label>
                            <input type="text" name="phone_number" class="form-control" value="<?php echo $phone_number; ?>">
                            <span class="help-block"><?php echo $phone_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($dob)) ? 'has-error' : ''; ?>">
                            <label>Date of Birth</label>
                            <input type="text" name="dob" class="form-control" value="<?php echo $dob; ?>">
                            <span class="help-block"><?php echo $dob_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($gender)) ? 'has-error' : ''; ?>">
                            <label>Gender</label>
                            <input type="text" name="gender" class="form-control" value="<?php echo $gender; ?>">
                            <span class="help-block"><?php echo $gender_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($county)) ? 'has-error' : ''; ?>">
                            <label>County</label>
                            <input type="text" name="county" class="form-control" value="<?php echo $county; ?>">
                            <span class="help-block"><?php echo $county_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($constituency)) ? 'has-error' : ''; ?>">
                            <label>Constituency</label>
                            <input type="text" name="constituency" class="form-control" value="<?php echo $constituency; ?>">
                            <span class="help-block"><?php echo $constituency_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($ward)) ? 'has-error' : ''; ?>">
                            <label>Ward</label>
                            <input type="text" name="ward" class="form-control" value="<?php echo $ward; ?>">
                            <span class="help-block"><?php echo $ward_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="agent.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>