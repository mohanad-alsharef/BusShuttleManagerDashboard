<?php
 require 'connect.php';

$loopNames = array();
$input = "";

if(isset($_POST['SubmitButton'])){
  $input = $_POST['inputText'];
  if($input != '') {
    
    postLoop($con, $input); 
  }
  header('Location: Loops.php');
}

  function makeList(&$loopNames, $con) {
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

  function postLoop($con, $input){
    var_dump($input);
    $sql = sprintf("INSERT INTO `loops`(`loops`) VALUES ( '$input' )");
    if($result = mysqli_query($con,$sql))
    {
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
</head>

<body>
  <div align="center">

    <?php
    makeList($loopNames, $con);
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
    <div class="newLoop">
      <p>Enter new Loop name here:</p>

      <form action="" method="post">
      <?php echo $input; ?>
        <input name="inputText" input="text" />
        <input type='submit' name="SubmitButton" class='btn btn-secondary'/>
      </form>

    </div>
  </div>
</body>

</html>
