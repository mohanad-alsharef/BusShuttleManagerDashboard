<?php
require 'connect.php';

$loopNames = array();

function makeList(&$loopNames) {
    require 'connect.php';


    $sql = sprintf("SELECT * FROM loops");

    if($result = mysqli_query($con,$sql))
    {


      while($row = mysqli_fetch_assoc($result))
      {
        array_push($loopNames, $row);
      }


    } else {
      http_response_code(404);
    }
}




?>

<html>
<head>
  
  <?php
  require './themepart/navbar.php';
  ?>

    <script type="text/javascript">
        function addTextArea(){
            var div = document.getElementById('new_loop');
            div.innerHTML += "<p>Enter new Loop name here:</p><textArea name='new_quote[]' />";
            div.innerHTML += "\n<br />"
        }
    </script>


</head>


<body>


<div align="center">

<?php
makeList($loopNames);
?>

<table>
   <tr>
    <th>Loops</th>
  </tr>
<ul id="ListOfLogs">
<?php foreach ($loopNames as $log): ?>
 <tr>
     <td>
       <?php echo $log['loops']; ?>
       <?php echo "<button type = 'button' class='btn btn-secondary'> edit</button>"?>
      </td>
     
 </tr>
<?php endforeach; ?>
</ul>
</table>



<button type='button' id="addButton" class='btn btn-secondary'>Add</button>

<div class="newLoop">
<p>Enter new Loop name here:</p>
<textArea id="loopName"></textArea>
<button type='button' id="submit" onClick="<?php echo postLoop() ?>"class='btn btn-secondary'>Submit</button>
</div>




</div>

<?php
    require 'connect.php';
    function postLoop(){

    $sql = sprintf("INSERT INTO `loops`(`loops`) VALUES ('purple loop')");

    if($result = mysqli_query($con,$sql))
    {
        // $text = 'Purple Loop';

        // $text = strip_tags($text);
        // $text = trim($text);
        // $text = htmlspecialchars($text);

        
        $con->query($sql);
    } else {
      http_response_code(404);
    }
        



        echo 'here';
    }

?>

</body>

</html>
