<?php  
require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

$input = filter_input_array(INPUT_POST);

$busID = filter_var(trim($input["id"]), FILTER_SANITIZE_STRING);
$bus = filter_var(trim($input["busIdentifier"]), FILTER_SANITIZE_STRING);
$AccessLayer = new AccessLayer();

if($input["action"] === 'edit') {
    $AccessLayer->update_bus($busID, $bus);
}
if($input["action"] === 'delete') {
    $AccessLayer->remove_bus($busID);
}
