<?php
$connection = mysqli_connect("localhost","root","");
$db = mysqli_select_db($connection,'members_project');

$query = "SELECT agents.status FROM agents WHERE agents.member_number = '$member_number'";

    $member_number = $_POST['member_number'];
    $query_run = mysqli_query($connection,$query);

    while($row = mysqli_fetch_array($query_run))
    {

    }
 



?>
