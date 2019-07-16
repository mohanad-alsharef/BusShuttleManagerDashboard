<?php  

require '../Database/connect.php';

$input = filter_input_array(INPUT_POST);

$busID = mysqli_real_escape_string($con, $input["id"]);
$buses = mysqli_real_escape_string($con, $input["busIdentifier"]);

$query = "SELECT * FROM buses WHERE busIdentifier='".$buses."'";

$result = mysqli_query($con, $query);

if($result) {
    
if($input["action"] === 'edit')
{
 $query = "
 UPDATE buses 
 SET busIdentifier = '".$buses."'
 WHERE id = '".$busID."'
 ";

 mysqli_query($con, $query);

}


if($input["action"] === 'edit')
{
 $query = "
 UPDATE buses 
 SET busIdentifier = '".$buses."'
 WHERE id = '".$busID."'
 ";

 mysqli_query($con, $query);

}
if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM buses 
 WHERE id = '".$busID."'
 ";
 mysqli_query($con, $query);
}
if($input["action"] === 'restore')
{

}
}
?>