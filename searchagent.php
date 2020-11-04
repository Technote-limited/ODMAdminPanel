

<!DOCTYPE html>
<html>
  <head>
    <title>Search Agent Records</title>
    <style>
       body{
           background-color: whitesmoke;
       }
       input{
           width: 40%;
           height:5%;
           border:1px;
           border-radius:05px;
           padding:8px 15px 8px 15px;
           margin: 10px 0px 15px 0px;
           box-shadow:1px 1px 2px 1px grey;
       }

           button{
        border: none;
        color: blue;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
                    }
					
					.input-group {
    margin: 10px 0px 10px 0px;
}
.input-group label {
    display: block;
    text-align: left;
    margin: 3px;
}
.input-group input {
    height: 30px;
    width: 93%;
    padding: 5px 10px;
    font-size: 16px;
    border-radius: 5px;
    border: 1px solid gray;
}
.btn {
    padding: 10px;
    font-size: 15px;
    color: white;
    background: #5F9EA0;
    border: none;
    border-radius: 5px;
}
.edit_btn {
    text-decoration: none;
    padding: 2px 5px;
    background: #2E8B57;
    color: white;
    border-radius: 3px;
}

.del_btn {
    text-decoration: none;
    padding: 2px 5px;
    color: white;
    border-radius: 3px;
    background: #800000;
}
.msg {
    margin: 30px auto; 
    padding: 10px; 
    border-radius: 5px; 
    color: #3c763d; 
    background: #dff0d8; 
    border: 1px solid #3c763d;
    width: 50%;
    text-align: center;
}
</style>
  </head>
  <body>
      <center>
          <form action="" method="POST">
		  <div class = "input-group">
              <input type="text" name="member_number" placeholder="Enter Member Number to search"/><br/>
			  </div>
              <div class="button">
              <input type="submit" name="search" value="Search Agent">
              </div>
</form>
<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'members_project');

if(isset($_POST['search']))
{
    $member_number = $_POST['member_number'];
   
    //$query = "SELECT * FROM agents  where member_number='$member_number'";
    $query = "SELECT agents.agentName,agents.id_passport,agents.member_number,agents.phone_number,agents.dob,agents.gender,
    agents.date_created,agents.created_by , county.county_name , constituency.constituency_name , ward.ward_name , agents.status FROM 
    agents INNER JOIN county ON agents.county = county.county_id INNER JOIN constituency ON 
    agents.constituency = constituency.constituency_id INNER JOIN ward ON agents.ward = ward.ward_id 
    WHERE agents.member_number = '$member_number'";
    $query_run = mysqli_query($connection,$query);

    while($row = mysqli_fetch_array($query_run))
    {
        ?>
        <form action ="" method="POST">
		<div class = "input-group">
            <input type="hidden" name ="id" value="<?php echo $row['id'] ?>"/>
            <div class="inputfield">
            <label for = "agentName">Name</label>
            <input type="text" name ="agentName" value="<?php echo $row['agentName'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "id_passport">Id or Passport</label>
            <input type="text" name ="id_passport" value="<?php echo $row['id_passport'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "member_number">Member Number</label>
            <input type="text" name ="member_number" value="<?php echo $row['member_number'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "phone_number">Phone Number</label>
            <input type="text" name ="phone_number" value="<?php echo $row['phone_number'] ?>"/>
            </div>
            <div class="inputfield">
             <label for = "dob">Date Of Birth</label>
            <input type="text" name ="dob" value="<?php echo $row['dob'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "gender">Gender</label>
            <input type="text" name ="gender" value="<?php echo $row['gender'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "county">County</label>
            <input type="text" name ="county" value="<?php echo $row['county_name'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "constituency">Constituency</label>
            <input type="text" name ="constituency" value="<?php echo $row['constituency_name'] ?>"/>
            </div>
            <div class="inputfield">
             <label for = "ward">Ward</label>
             <input type="text" name ="ward" value="<?php echo $row['ward_name'] ?>"/>
             </div>
             <div class="inputfield">
            <label for = "date_created">Date Created</label>
            <input type="text" name ="date_created" value="<?php echo $row['date_created'] ?>"/>
            </div>
            <div class="inputfield">
            <label for = "status">Status</label>
            <input type="int" name ="status" value="
            <?php 
            if($row['status']==0)
            {
                echo 
               "Active"  ;}
            else{ 
                echo 
                "Inactive";
            }
             ?>"/>
             </div>
             <div class="inputfield">
          <label for="status">Change Status</label>
          <div class="custom_select">
            <select onchange = "active_inactive_agent(this.value)">
              <option value="0">Active</option>
              <option value="1">InActive</option>
            </select>
          </div>
       </div>
            

            <div class="button">
              <input type="submit" name="Edit Details" value="Edit Agent Details">
              </div>

		  			
              
             
        
        <?php
    }
}

?>
</center>

<script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type = "text/javascript">
function active_inactive_agent(val, member_number)
{
    $.ajax({
        type:'post',
        url:'change.php',
        data: { val:val, member_number:member_number},
        success:function(result){
            if(result ==0){
            $('#str' + member_number).html('Active');
            }
            else{
                $('#str' + member_number).html('InActive');
            }
        
        }

    })
}
</script>


<a href="landing.html" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white">Back to Home</a> 
    
  </body>
</html>