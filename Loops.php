<?php
?>
<!DOCTYPE HTML>
<HTML LANG="EN">
<HEAD>
    <TITLE>Home</TITLE>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.13.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

</HEAD>

<body>
<div class="btn-group d-flex" role="group" aria-label="Home Buttons">
    <button type="button" onclick="window.location='/phpTest/Stops.php'"class="btn btn-secondary">Stops</button>
    <button type="button" onclick="window.location='/phpTest/Users.php'"class="btn btn-secondary">Users</button>
    <button type="button" onclick="window.location='/phpTest/Entries.php'" class="btn btn-secondary">Entries</button>
    <button type="button" onclick="window.location='/phpTest/Loops.php'" class="btn btn-secondary">Loops</button>
</div>

<?php
##This is to connect to my local connection and will need changed
const DBHOST = 'localhost';
const DBNAME = "test284829";
const DBUSER = "root";
const DBPWD = "";


$connect = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);


if (mysqli_connect_errno($connect)) {
    die("Failed to connect:" . mysqli_connect_error());
}

mysqli_set_charset($connect, "utf8");
  

echo "Connected successfully";

$sql = "SELECT * FROM LOOPS";
$result = $connect->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo $row["id"]. " " .$row["loops"];
    }
}

?>

<br>

<?php
$message = "is this working?"
?>



<textarea>Hello? <?php echo $message; ?></textarea>


</body>







</HTML>