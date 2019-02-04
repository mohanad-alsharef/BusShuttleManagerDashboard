<?php
/**
 * Returns the list of logs.
 */
require 'connect.php';

$logs = array();

$currentDate = date("Y/m/d");
$yesterdayDate = date('Y-m-d', strtotime('-1 day', strtotime($currentDate)));

$sql = sprintf("SELECT * from Entries WHERE Date='$yesterdayDate' ORDER BY id DESC");
echo (" \n Showing YESTERDAY'S results.");

if($result = mysqli_query($con,$sql))
{
  
  while($row = mysqli_fetch_assoc($result))
  {
    array_push($logs, $row);
  }

}
else
{
  http_response_code(404);
}

?>
<html>
 <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
 <style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
 </head>
 <body>

   <input type="button" class="btn btn-success center-block" value="Export to CSV" id="btnHome"
 onClick="document.location.href='export.php'" />
 <table>
   <tr>
    <th>Boarded</th>
    <th>Stop</th>
    <th>Timestamp</th>
    <th>Date</th>
    <th>Loop</th>
    <th>Driver</th>
    <th>ID</th>
  </tr>
  <ul id="ListOfLogs">
   <?php foreach ($logs as $log): ?>
    <tr>
        <td><?php echo $log["boarded"]; ?></td>
        <td><?php echo $log["stop"]; ?></td>
        <td><?php echo $log["timestamp"]; ?></td>
        <td><?php echo $log["date"]; ?></td>
        <td><?php echo $log["loop"]; ?></td>
        <td><?php echo $log["driver"]; ?></td>
        <td><?php echo $log["id"]; ?></td>
    </tr>
   <?php endforeach; ?>
  </ul>
  </table>
 </body>
</html>
