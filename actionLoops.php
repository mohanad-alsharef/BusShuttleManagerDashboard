<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require 'connect.php';

$input = filter_input_array(INPUT_POST);

$loopID = mysqli_real_escape_string($con, $input["id"]);
$loop = mysqli_real_escape_string($con, $input["loop"]);

if($input["action"] === 'edit')
{
 $query = "
 UPDATE loops 
 SET loops = '".$loop."'
 WHERE id = '".$loopID."'
 ";

 mysqli_query($con, $query);

}
if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM loops 
 WHERE id = '".$loopID."'
 ";
 mysqli_query($con, $query);
}

echo json_encode($input);

?>