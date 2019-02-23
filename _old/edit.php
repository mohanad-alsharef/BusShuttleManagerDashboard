<?php

require 'connect.php';

$delete = $_POST['name'];

$sql = sprintf("UPDATE MyGuests SET lastname='Doe' WHERE id=2");
if($result = mysqli_query($con,$sql))
{
  // $text = 'Purple Loop';
  // $text = strip_tags($text);
  // $text = trim($text);
  // $text = htmlspecialchars($text);
  header('Location: Loops.php');
} else {
  echo "anything";
  http_response_code(404);
}

  if(empty($delete))
  {
    echo("You didn't select any boxes.");
  }
  else
  {
    $i = count($delete);
    echo("You selected $i box(es): <br>");
    for($j = 0; $j < $i; $j++)
    {
      echo $delete . "<br>";
    }
  }


  ?>