<?php  
require_once(dirname(__FILE__) . '/../Configuration/config.php');

$input = filter_input_array(INPUT_POST);

$loopID = filter_var(trim($input["id"]), FILTER_SANITIZE_STRING);
$loop = filter_var(trim($input["loop"]), FILTER_SANITIZE_STRING);
$AccessLayer = new AccessLayer();
    
if($input["action"] === 'edit') {
    $AccessLayer->update_loop($loopID, $loop);
}

if($input["action"] === 'delete') {
    $AccessLayer->remove_loop($loopID);
}


?>