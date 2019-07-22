<?php  
require_once(dirname(__FILE__) . '/../Configuration/config.php');

$input = filter_input_array(INPUT_POST);

$routeID = filter_var(trim($input["id"]), FILTER_SANITIZE_STRING);
$route = filter_var(trim($input["stops"]), FILTER_SANITIZE_STRING);

$AccessLayer = new AccessLayer();

//Not used right now
if($input["action"] === 'edit') { }

if($input["action"] === 'delete')
{
   $AccessLayer->remove_route($routeID);
}

echo json_encode($input);
?>