<?php  
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require '../Database/connect.php';

$input = filter_input_array(INPUT_POST);

$id = mysqli_real_escape_string($con, $input["id"]);
$stop = mysqli_real_escape_string($con, $input["stop"]);
$time = mysqli_real_escape_string($con, $input["timestamp"]);
$date = mysqli_real_escape_string($con, $input["date"]);
$loop = mysqli_real_escape_string($con, $input["loop"]);
$driver = mysqli_real_escape_string($con, $input["driver"]);
$leftbehind = mysqli_real_escape_string($con, $input["leftBehind"]);

$query = "SELECT * FROM Entries WHERE id='".$id."'";

$result = mysqli_query($con, $query);

if($result) {
    
if($input["action"] === 'edit')
{
 $query = "
 UPDATE `Entries` 
 SET `boarded` = '".$boarded."',
 `stop` = '".$stop."',
 `timestamp` = '".$time."',
 `date` = '".$date."',
 `loop` = '".$loop."',
 `driver` = '".$driver."',
 `leftBehind` = '".$leftBehind."'
 WHERE `id` = '".$id."'
 ";

 mysqli_query($con, $query);

}

if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM Entries 
 WHERE id = '".$id."'
 ";
 mysqli_query($con, $query);
}
if($input["action"] === 'restore')
{

}
}
?>