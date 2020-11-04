<?php
//Include database configuration file

$conn = new mysqli('localhost','root','','members_project');  

if(isset($_POST["county_id"]) && !empty($_POST["county_id"])){
    //Get all constituencies data
    $query = $conn->query("SELECT * FROM constituency WHERE county_id = ".$_POST['county_id']." AND status = 1 ORDER BY constituency_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display constituencies list
    if($rowCount > 0){
        echo '<option value="">Select constituency</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['constituency_id'].'">'.$row['constituency_name'].'</option>';
        }
    }else{
        echo '<option value="">constituency not available</option>';
    }
}

if(isset($_POST["constituency_id"]) && !empty($_POST["constituency_id"])){
    //Get all ward data
    $query = $conn->query("SELECT * FROM ward WHERE constituency_id = ".$_POST['constituency_id']." AND status = 1 ORDER BY ward_name ASC");
    
    //Count total number of rows
    $rowCount = $query->num_rows;
    
    //Display ward list
    if($rowCount > 0){
        echo '<option value="">Select ward</option>';
        while($row = $query->fetch_assoc()){ 
            echo '<option value="'.$row['ward_id'].'">'.$row['ward_name'].'</option>';
        }
    }else{
        echo '<option value="">Ward not available</option>';
    }
}
?>