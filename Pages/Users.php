<?php
require '../Database/connect.php';

$userNames = array();
$firstName = "";
$lastName = "";

if(isset($_POST['SubmitButton'])){
  $firstName = $_POST['firstName'];
  $lastName = $_POST['lastName'];
  $id = $_POST['id'];
  if($firstName != '' || $lastName != '') {
    postLoop($con, $firstName, $lastName, $id);
  }
  header('Location: Users.php');
}

function makeList(&$userNames, $con) {
  $sql = sprintf("SELECT * FROM users");

  if($result = mysqli_query($con,$sql)) {
    while($row = mysqli_fetch_assoc($result)) {
      array_push($userNames, $row);
    }
  } else {
    http_response_code(404);
  }
}

function postLoop($con, $firstName, $lastName, $id){
  $sql = sprintf("INSERT INTO `users`(`firstname`, `lastname`) VALUES ( '$firstName', '$lastName' )");
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

<html>
<head>
  <?php
  require '../themepart/resources.php';
  require '../themepart/sidebar.php';
  require '../themepart/pageContentHolder.php';
  ?>

</head>
<body>
    <?php
    makeList($userNames, $con);
    ?>
<div class="d-flex justify-content-center"><p><h3>Create a New User</h3></p></div>

<br>
<div class="d-flex justify-content-center">
<form action="" method="post">
  <div class="form-row align-items-center">
    <div class="col-auto">
      <label class="sr-only" for="inlineFormInput">First Name</label>
      <input type="text" class="form-control mb-2" name='firstName' id="inlineFormInput" placeholder="First Name">
       </div>
    <div class="col-auto">
      <label class="sr-only" for="inlineFormInputGroup">Last Name</label>
      <div class="input-group mb-2">
        <input type="text" class="form-control" name='lastName' id="inlineFormInputGroup" placeholder="Last Name">
      </div>
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
       <th>First Name</th>
       <th>Last Name</th>
      </tr>
     </thead>
     <tbody>
     <?php foreach ($userNames as $log): ?>
          <tr>
          	<td style="display:none;"><?php echo $log['id']; ?></td>
            <td><?php echo $log['firstname']; ?></td>
            <td><?php echo $log['lastname']; ?></td>
          </tr>
        <?php endforeach; ?>
     </tbody>
    </table>
  </div>
</body>

<script>  
$(document).ready(function(){  
  $('#editable_table').Tabledit({
    url: '../Actions/actionUsers.php',
    columns: {
        identifier: [0, 'id'],
        editable: [[1,'firstname'], [2,'lastname'] ]
    }
});
 
});  
 </script>
</html>
<?php require '../themepart/footer.php'; ?>