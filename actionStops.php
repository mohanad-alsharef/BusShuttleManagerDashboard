<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require 'connect.php';

$input = filter_input_array(INPUT_POST);

$stopID = mysqli_real_escape_string($con, $input["id"]);
$stop = mysqli_real_escape_string($con, $input["stop"]);

if($input["action"] === 'edit')
{
 $query = "
 UPDATE stops 
 SET loops = '".$stop."'
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

echo json_encode($input);

?>