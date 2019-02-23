<?php
require 'connect.php';

?>
<!DOCTYPE HTML>
<HTML LANG="EN">
<HEAD>
<?php
  require './themepart/navbar.php';
?>

<?php

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