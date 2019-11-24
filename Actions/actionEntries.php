<?php  
require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

$input = filter_input_array(INPUT_POST);

$entryID = filter_var(trim($input["id"]), FILTER_SANITIZE_STRING);
$boarded = filter_var(trim($input["boarded"]), FILTER_SANITIZE_STRING);
$leftBehind = filter_var(trim($input["leftBehind"]), FILTER_SANITIZE_STRING);
$AccessLayer = new AccessLayer();

    
if($input["action"] === 'edit')
{
    $AccessLayer->update_entries_boarded_and_leftbehind($boarded, $leftBehind, $entryID);
}

if($input["action"] === 'delete')
{
    //Do nothing as of right now.
}

?>