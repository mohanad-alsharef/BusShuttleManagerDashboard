<?php
require '../Database/connect.php';

$entries  = array();
$boarded = "";
$stop = "";
$timestamp = "";
$date = "";
$loop = "";
$driver = "";

if(isset($_POST['SubmitButton'])){
  $boarded = $_POST['boarded'];
  $stop = $_POST['stop'];
  $timestamp = $_POST['timestamp'];
  $date = $_POST['date'];
  $loop = $_POST['loop'];
  $driver = $_POST['driver'];
  $id = $_POST['id'];
  if($boarded != '' || $stop != '' || $timestamp != '' || $date != '' || $loop != '' || $driver != '') {
    postLoop($con, $boarded, $stop, $timestamp, $date, $loop, $driver, $id);
  }
  header('Location: Entries.php');
}

function makeList(&$entries, $con) {
  $sql = sprintf("SELECT * FROM entries");

  if($result = mysqli_query($con,$sql)) {
    while($row = mysqli_fetch_assoc($result)) {
      array_push($entries, $row);
    }
  } else {
    http_response_code(404);
  }
}

function postLoop($con, $boarded, $stop, $timestamp, $date, $loop, $driver, $id){
  $sql = sprintf("INSERT INTO `entries`(`boarded`, `stop`, `timestamp`, `date`, `loop`, `driver`) VALUES ( '$boarded', '$stop', '$timestamp', '$date', '$loop', '$driver', '$id' )");
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
  ?>

</head>
<body>

<div class="d-flex justify-content-center"><p><h3>Today's entries listed below.</h3></p></div>

<br>

    <table id="editable_table" class="table table-bordered table-striped">
     <thead>
      <tr>
       <th># Boarded</th>
       <th>Stop</th>
       <th>Timestamp</th>
       <th>Date</th>
       <th>Loop</th>
       <th>Driver</th>
      </tr>
     </thead>
     <tbody>
     <?php foreach ($entries as $log): ?>
          <tr>
          	<td style="display:none;"><?php echo $log['id']; ?></td>
            <td><?php echo $log['boarded']; ?></td>
            <td><?php echo $log['stop']; ?></td>
            <td><?php echo $log['timestamp']; ?></td>
            <td><?php echo $log['date']; ?></td>
            <td><?php echo $log['loop']; ?></td>
            <td><?php echo $log['driver']; ?></td>
          </tr>
        <?php endforeach; ?>
     </tbody>
    </table>
  </div>
</body>

<script>  
$(document).ready(function(){  
  $('#editable_table').Tabledit({
    url: '../Actions/actionEntries.php',
    columns: {
        identifier: [0, 'id'],
        editable: [[1,'boarded'], [2,'stop'], [3,'timestamp'], [4,'date'], [5,'loop'], [6,'driver']]
    }
});
 
});  
 </script>
</html>
<?php require '../themepart/footer.php'; ?>