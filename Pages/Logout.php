<?php
   session_start();
   
   //Ends the session
   if(session_destroy()) {
      header("Location: Login.php");
   }
?>