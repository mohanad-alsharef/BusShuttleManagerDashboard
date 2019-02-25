<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require 'connect.php';

$input = filter_input_array(INPUT_POST);

$loopName = mysqli_real_escape_string($con, $input["loopName"]);
$newLoopName = mysqli_real_escape_string($con, $input["newLoopName"]);

if($input["action"] === 'edit')
{
 $query = "
 UPDATE loops 
 SET loops = '".$newLoopName."'
 WHERE id = '".$loopName."'
 ";

 mysqli_query($con, $query);

}
if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM loops 
 WHERE id = '".$loopName."'
 ";
 mysqli_query($con, $query);
}

echo json_encode($input);

?>