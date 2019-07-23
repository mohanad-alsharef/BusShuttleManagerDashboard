<?php 

require '../Database/connect.php';

$position = $_POST['position'];
$i=1;

foreach($position as $k=>$v){
    $sql = sprintf("UPDATE stop_loop SET displayOrder= $i WHERE `loop`= $v[1] AND `stop`=$v[0] AND `id`=$v[2] ");
    if($result = mysqli_query($con,$sql))
    {
    } else {
      http_response_code(404);
    }
	$i++;
}
?>