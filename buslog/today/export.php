<?php
require 'connect.php';

$db_record = 'Entries';

$currentDate = "'".date("Y/m/d")."'";

$where = 'ORDER BY id DESC';

$csv_filename = 'db_export_'.$db_record.'_'.date('Y-m-d').'.csv';

if (mysqli_connect_errno()) {
    die("Failed to connect to MySQL: " . mysqli_connect_error());
}

$csv_export = '';
$query = mysqli_query($con, "SELECT * FROM ".$db_record." ".$where);
$field = mysqli_field_count($con);

for($i = 0; $i < $field; $i++) {
    $csv_export.= mysqli_fetch_field_direct($query, $i)->name.',';
}

$csv_export.= '';

while($row = mysqli_fetch_array($query)) {
    // create line with field values
    for($i = 0; $i < $field; $i++) {
        $csv_export.= '"'.$row[mysqli_fetch_field_direct($query, $i)->name].'",';
    }
    $csv_export.= '
';
}

header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=".$csv_filename."");
echo($csv_export);
