<?php 
require '../Database/connect.php';

$position = $_POST['position'];

$i=1;
foreach($position as $k=>$v){
    $sql = sprintf("UPDATE stop_loop SET displayOrder= $i WHERE stop= $v");
    if($result = mysqli_query($con,$sql))
    { http_response_code(200);
    } else {
      echo "anything";
      http_response_code(404);
    }
    
	$i++;
}
