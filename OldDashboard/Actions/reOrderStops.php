<?php 

require '../Database/connect.php';

$position = $_POST['position'];
$i=1;

foreach($position as $k=>$v){
    $sql = sprintf("UPDATE stops SET displayOrder= $i WHERE id= $v");
    if($result = mysqli_query($con,$sql))
    {
    } else {
      http_response_code(404);
    }
	$i++;
}
?>