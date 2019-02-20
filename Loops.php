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


    <script type="text/javascript">
        function addTextArea(){
            var div = document.getElementById('new_loop');
            div.innerHTML += "<p>Enter new Loop name here:</p><textArea name='new_quote[]' />";
            div.innerHTML += "\n<br />"
        }
    </script>



</HEAD>

<body>
<div class="btn-group d-flex" role="group" aria-label="Home Buttons">
    <button type="button" onclick="window.location='/phpTest/Stops.php'"class="btn btn-secondary">Stops</button>
    <button type="button" onclick="window.location='/phpTest/Users.php'"class="btn btn-secondary">Users</button>
    <button type="button" onclick="window.location='/phpTest/Entries.php'" class="btn btn-secondary">Entries</button>
    <button type="button" onclick="window.location='/phpTest/Loops.php'" class="btn btn-secondary">Loops</button>
</div>




<div align="center">
<?php
   
    ##This is to connect to my local connection and will need changed
     const DBHOST = 'localhost';
    const DBNAME = "test284829";
    const DBUSER = "root";
    const DBPWD = "";

function makeList() {

    $connect = new mysqli(DBHOST, DBUSER, DBPWD, DBNAME);

    if (mysqli_connect_errno($connect)) {
        die("Failed to connect:" . mysqli_connect_error());
    }

    mysqli_set_charset($connect, "utf8");

    $sql = "SELECT * FROM loops";
    $result = $connect->query($sql);

    $loopNames = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
           array_push($loopNames, $row["loops"]);
        }
    }else {
        echo "0 results";

    }
    foreach($loopNames as $name) {
        echo $name. " ";
        echo "<button type='button' class='btn btn-secondary'>edit</button>" ;
        echo "<br>";
    }

}

makeList();

?>


<div id="new_loop"></div>




<button type='button' onClick="addTextArea();" class='btn btn-secondary'>Add</button>

</div>




</body>







</HTML>