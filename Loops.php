<?php

require 'connect.php';

function makeList() {

    $loopNames = array();

    $sql = sprintf("SELECT * FROM loops");

    if($result = mysqli_query($con,$sql))
    {

      while($row = mysqli_fetch_assoc($result))
      {
        array_push($logs, $row);
      }


    } else {
      http_response_code(404);
    }

    foreach($loopNames as $name) {
        echo $name. " ";
        echo "<button type='button' class='btn btn-secondary'>edit</button>" ;
        echo "<br>";
    }
}



?>
<html>
<head>
  <?php
  require '/themepart/navbar.php';
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
makeList();
?>


<div id="new_loop"></div>




<button type='button' onClick="addTextArea();" class='btn btn-secondary'>Add</button>

</div>




</body>







</html>
