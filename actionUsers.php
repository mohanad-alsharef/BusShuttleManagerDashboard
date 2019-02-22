<?php
//action.php$connect = mysqli_connect('localhost', 'root', '', 'testing');
require 'connect.php';

$input = filter_input_array(INPUT_POST);

$firstName = mysqli_real_escape_string($con, $input["firstname"]);
$lastName = mysqli_real_escape_string($con, $input["lastname"]);
$id = mysqli_real_escape_string($con, $input["id"]);

if($input["action"] === 'edit')
{
 $query = "
 UPDATE `users`
 SET `firstname` = '".$firstName."',
 `lastname` = '".$lastName."'
 WHERE `id` = '".$id."'
 ";

 mysqli_query($con, $query);

}
if($input["action"] === 'delete')
{
 $query = "
 DELETE FROM users
 WHERE id = '".$id."'
 ";
 mysqli_query($con, $query);
}
echo json_encode($input);

?>
