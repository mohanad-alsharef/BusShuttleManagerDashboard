<?php
/**
 * Returns the list of logs.
 */
require 'connect.php';

$logs = [];

$currentDate = date("Y/m/d");

$sql = sprintf("SELECT * from Entries WHERE Date='$currentDate' ORDER BY id DESC");

echo "The time is " . date("h:i:sa" .".");
echo nl2br(" \n Showing results from TODAY only.");


if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $logs[$cr]['boarded'] = $row['boarded'];
    $logs[$cr]['stop'] = $row['stop'];
    $logs[$cr]['timestamp'] = $row['timestamp'];
    $logs[$cr]['date'] = $row['date'];
    $logs[$cr]['loop'] = $row['loop'];
    $logs[$cr]['driver'] = $row['driver'];
    $logs[$cr]['id'] = $row['id'];
    $cr++;
  }

//   echo json_encode(['data'=>$logs]);
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
   <? foreach ($logs as $logs): ?>
    <tr>
        <td><?= $logs["boarded"] ?></td>
        <td><?= $logs["stop"] ?></td>
        <td><?= $logs["timestamp"] ?></td>
        <td><?= $logs["date"] ?></td>
        <td><?= $logs["loop"] ?></td>
        <td><?= $logs["driver"] ?></td>
        <td><?= $logs["id"] ?></td>
    </tr>
   <? endforeach ?>
  </ul>
  </table>
 </body>
</html>
