<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require '../Database/connect.php';

$input = filter_input_array(INPUT_POST);

$stopID = mysqli_real_escape_string($con, $input["id"]);
$stop = mysqli_real_escape_string($con, $input["stop"]);

$query = "SELECT * FROM stops WHERE stops='".$stop."'";

$result = mysqli_query($con, $query);

if($result) {
    
if($input["action"] === 'edit')
{
 $query = "
 UPDATE stops 
 SET stops = '".$stop."'
 WHERE id = '".$stopID."'
 ";

 mysqli_query($con, $query);

}


if($input["action"] === 'edit')
{
 $query = "
 UPDATE stops 
 SET stops = '".$stop."'
 WHERE id = '".$stopID."'
 ";

 mysqli_query($con, $query);

}
if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM stops 
 WHERE id = '".$stopID."'
 ";
 mysqli_query($con, $query);
}
if($input["action"] === 'restore')
{

}
}
?>