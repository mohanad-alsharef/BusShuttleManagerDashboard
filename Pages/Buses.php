<?php
require '../Database/connect.php';

$busNames = array();
$input = "";

if(isset($_POST['SubmitButton'])){
  $input = $_POST['inputText'];
  if($input != '') {
    postLoop($con, $input);
  }
  header('Location: Buses.php');
}

function makeList(&$busNames, $con) {
  $sql = sprintf("SELECT * FROM buses");

  if($result = mysqli_query($con,$sql)) {
    while($row = mysqli_fetch_assoc($result)) {
      array_push($busNames, $row);
    }
  } else {
    http_response_code(404);
  }
}

function postLoop($con, $input){
  $sql = sprintf("INSERT INTO `buses`(`busIdentifier`) VALUES ( '$input' )");
  if($result = mysqli_query($con,$sql))
  {
    // $text = 'Purple Loop';
    // $text = strip_tags($text);
    // $text = trim($text);
    // $text = htmlspecialchars($text);
  } else {
    echo "anything";
    http_response_code(404);
  }
}
?>
<?php 
require '../themepart/resources.php';
require '../themepart/sidebar.php';
require '../themepart/pageContentHolder.php';
?>
<html>
<head>

</head>
<body>
  <div align="center">

    <?php
    makeList($busNames, $con);
    ?>


    <div class="d-flex justify-content-center"><p><h3>Create a New Bus</h3></p></div>

    <br>
    <div class="d-flex justify-content-center">
    <form action="" method="post">
      <div class="form-row align-items-center">
        <div class="col-auto">
          <label class="sr-only" for="inlineFormInput">Bus Name</label>
          <input type="text" input="text" class="form-control mb-2" name='inputText' id="inlineFormInput" placeholder="Enter New Bus">
           </div>
        <div class="col-auto">
          <button type="submit" name="SubmitButton" class="btn btn-dark mb-2">Submit</button>
        </div>
        </div>
    </form>
    </div>

    <table id="editable_table" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th>Bus</th>
      </tr>
     </thead>
     <tbody>
     <?php foreach ($busNames as $log): ?>
          <tr>
            <td><?php echo $log['busIdentifier']; ?></td>
            <td style="display:none;"><?php echo $log['id']; ?></td>
            <!-- <td><form action='edit.php?name="<?php echo $log['buses']; ?>"' method="post">
                  <input type="hidden" name="name" value="<?php echo $log['buses']; ?>">
                  <input type="submit" name="editButton" value="edit">
                </form>
            </td>
            <td>
            <form action='delete.php?name="<?php echo $log['buses']; ?>"' method="post">
                  <input type="hidden" name="name" value="<?php echo $log['buses']; ?>">
                  <input type="submit" name="editButton" value="delete">
                </form>
            </td> -->

          </tr>
        <?php endforeach; ?>
     </tbody>
    </table>
  </div>
</body>
<script>
$(document).ready(function(){
  $('#editable_table').Tabledit({
    url: '../Actions/actionBuses.php',
    columns: {
        identifier: [1, 'id'],
        editable: [[0,'busIdentifier']]
    }
  });
});

 </script>

</html>
<?php require '../themepart/footer.php'; ?>