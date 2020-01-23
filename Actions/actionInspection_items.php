<?php  
require_once(dirname(__FILE__) . '/../DataLink/AccessLayer.php');

$input = filter_input_array(INPUT_POST);

$InspectionItemID = filter_var(trim($input["id"]), FILTER_SANITIZE_STRING);
$InspectionItem = filter_var(trim($input["inspection_item_name"]), FILTER_SANITIZE_STRING);
$AccessLayer = new AccessLayer();

if($input["action"] === 'edit') {
    $AccessLayer->update_inspection_items($InspectionItemID, $InspectionItem);
}
if($input["action"] === 'delete') {
    $AccessLayer->remove_inspection_items($InspectionItemID);
}
