<?php
// Include config file
require_once "dbconfig.php";
 
// Define variables and initialize with empty values
$order_number = $cards= $quantity= $order_date = $created_by = $status ="";
$order_number_err = $cards_err= $quantity_err= $order_date_err = $created_by_err = $status_err  ="";

 
// Processing form data when form is submitted
if(isset($_POST["order_number"]) && !empty($_POST["order_number"])){
    // Get hidden input value
    $order_number = $_POST["order_number"];
    
   
    // Validate id_passport
    $input_cards = trim($_POST["cards"]);
    if(empty($input_cards)){
        $cards_err = "Please enter an cards Order category.";     
    } else{
        $cards= $input_cards;
    }
    
    // Validate member_number
    $input_quantity = trim($_POST["quantity"]);
    if(empty($input_quantity)){
        $quantity = "Please enter the quantity.";     
    }
    else{
        $quantity = $input_quantity;
    }
    // Validate phone_number
    $input_order_date = trim($_POST["order_date"]);
    if(empty($input_order_date)){
        $order_date_err = "Please enter the order date.";     
    }
    else{
        $order_date= $input_order_date;
    }

    // Validate County
    $input_created_by = trim($_POST["created_by"]);
    if(empty($input_created_by)){
        $created_by_err = "Please enter the date order was made.";     
    }
    else{
        $created_by = $input_created_by;
    }
    // Validate Constituency
    $input_status= trim($_POST["status"]);
    if(empty($input_status)){
        $status_err = "Please enter the order status.";     
    }
    else{
        $status = $input_status;
    }

  

    
    // Check input errors before inserting in database
    if(empty($order_date_err) && empty($cards_err) && empty($quantity_err) && empty($order_date_err) 
    && empty($created_by_err) && empty($status_err)){
        // Prepare an update statement
        $sql = "UPDATE orders SET cards=?, quantity=?,order_date=?,created_by=?,status=?  WHERE order_number=?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
           
            mysqli_stmt_bind_param($stmt, "sssssi",  $param_cards, $param_quantity,$param_order_date , $param_created_by,$param_status,$param_order_number );
            
            // Set parameters
           
            $param_cards = $cards;
            $param_quantity = $quantity;
            $param_order_date = $order_date;
            $param_created_by= $created_by;
            $param_status = $status;
            $param_order_number = $order_number;

           
    
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: agentsorders.php");
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
    if(isset($_GET["order_number"]) && !empty(trim($_GET["order_number"]))){
        // Get URL parameter
        $order_number=  trim($_GET["order_number"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM orders WHERE order_number = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_order_number);
            
            // Set parameters
            $param_order_number = $order_number;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. 
                    Since the result set contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $order_number = $row["order_number"];
                    $cards = $row["cards"];
                    $quantity= $row["quantity"];
                    $order_date = $row["order_date"];
                    $created_by = $row["created_by"];
                    $status = $row["status"];
                   

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
    <title>Update Order Details</title>
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
                        <h2>Update Order Details</h2>
                    </div>
                    <p>Please submit the details to update order details.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($order_number_err)) ? 'has-error' : ''; ?>">
                            <label>OrderNumber</label>
                            <input type="text" name="order_number" class="form-control" value="<?php echo $order_number; ?>">
                            <span class="help-block"><?php echo $order_number_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($cards_err)) ? 'has-error' : ''; ?>">
                            <label>Cards Type</label>
                            <input type="text" name="cards" class="form-control" value="<?php echo $cards; ?>">
                            <span class="help-block"><?php echo $cards_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($quantity_err)) ? 'has-error' : ''; ?>">
                            <label>Quantity</label>
                            <input type="text" name="quantity" class="form-control" value="<?php echo $quantity; ?>">
                            <span class="help-block"><?php echo $quantity_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($order_date_err)) ? 'has-error' : ''; ?>">
                            <label>Order Date</label>
                            <input type="text" name="order_date" class="form-control" value = "<?php echo $order_date; ?>">
                            <span class="help-block"><?php echo $order_date_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($created_by_err)) ? 'has-error' : ''; ?>">
                            <label>Created by</label>
                            <input type="text" name="created_by" class="form-control" value="<?php echo $created_by; ?>">
                            <span class="help-block"><?php echo $created_by_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($status_err)) ? 'has-error' : ''; ?>">
                            <label>Status</label>
                            <input type="text" name="status" class="form-control" value="<?php echo $status; ?>">
                            <span class="help-block"><?php echo $status_err;?></span>
                            
                        </div>
                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="agentsorders.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>