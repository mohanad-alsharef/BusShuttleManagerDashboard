<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require '../Database/connect.php';

$input = filter_input_array(INPUT_POST);

$boarded = mysqli_real_escape_string($con, $input["boarded"]);
$stop = mysqli_real_escape_string($con, $input["stop"]);
$timestamp = mysqli_real_escape_string($con, $input["timestamp"]);
$date = mysqli_real_escape_string($con, $input["date"]);
$loop = mysqli_real_escape_string($con, $input["loop"]);
$driver = mysqli_real_escape_string($con, $input["driver"]);
$id = mysqli_real_escape_string($con, $input["id"]);

if($input["action"] === 'edit')
{
 $query = "
 UPDATE `entries`
 SET `boarded` = '".$boarded."',
 `stop` = '".$stop."',
 `timestamp` = '".$timestamp."',
 `date` = '".$date."',
 `loop` = '".$loop."',
 `driver` = '".$driver."'
 WHERE `id` = '".$id."'
 ";

 mysqli_query($con, $query);

}
if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM entries
 WHERE id = '".$id."'
 ";
 mysqli_query($con, $query);
}
echo json_encode($input);

?>