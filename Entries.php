<?php
require 'connect.php';
?>
<!DOCTYPE HTML>
<HTML LANG="EN">
<?php
  require './themepart/navbar.php';
  ?>
<?php


if (mysqli_connect_errno($con)) {
    die("Failed to connect:" . mysqli_connect_error());
}

mysqli_set_charset($con, "utf8");
  

echo "Connected successfully";
?>
<br>

<textarea>You are in Entries</textarea>



</body>

</HTML>