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

    <?php
    require './themepart/navbar.php';
    ?>


</HEAD>

<body>


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
?>
<br>

<textarea>You are in Stops</textarea>



</body>

</HTML>