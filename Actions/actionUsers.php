<?php
require_once(dirname(__FILE__) . '/../Configuration/config.php');

$input = filter_input_array(INPUT_POST);

$firstName = filter_var(trim($input["firstname"]), FILTER_SANITIZE_STRING);
$lastName = filter_var(trim($input["lastname"]), FILTER_SANITIZE_STRING);
$id = filter_var(trim($input["id"]), FILTER_SANITIZE_STRING);
$AccessLayer = new AccessLayer();

if($input["action"] === 'edit') {
    $AccessLayer->update_user($id, $firstName, $lastName);
}
if($input["action"] === 'delete') {
    $AccessLayer->remove_user($id);
}

//echo json_encode($input);

?>
