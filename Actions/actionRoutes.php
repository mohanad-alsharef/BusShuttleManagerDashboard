<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require '../Database/connect.php';

$input = filter_input_array(INPUT_POST);

$stopID = mysqli_real_escape_string($con, $input["id"]);
var_dump($stopID);
$stop = mysqli_real_escape_string($con, $input["stops"]);

$query = "SELECT * FROM stops WHERE stops='".$stop."'";

$result = mysqli_query($con, $query);

if($result) {
    

//Not used right now
if($input["action"] === 'edit')
{
 $query = "
 UPDATE stop_loop 
 SET stops = '".$stop."'
 WHERE id = '".$stopID."'
 ";

 mysqli_query($con, $query);

}

if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM stop_loop 
 WHERE stop = '".$stopID."'
 ";
 if(mysqli_query($con, $query)) {
 } else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create user."));
 }
 
}
if($input["action"] === 'restore')
{

}
}
?>