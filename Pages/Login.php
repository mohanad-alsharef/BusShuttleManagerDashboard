<?php

session_start();
 
//Checks if user is signed in, otherwise takes them back to login page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: Entries.php");
    exit;
}

require '../Database/connect.php';
 
$username = $password = "";
$username_err = $password_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){

    //Checks if text fields were left blank
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    //Validate credentials
    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT id, username, password FROM admins WHERE username = ?";

        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);

                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            session_start();
                            
                            
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            header("location: Entries.php");
                        } else{

                            //Displays error if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    //Displays error message if username can't be found
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        mysqli_stmt_close($stmt);
    }
    
    mysqli_close($con);
}
?>

<html>
   <head>
      <title>Login</title>
      
      
      <style>
         /* Border style around form */
         form {
            border: 3px solid #f1f1f1;
         }

         /* Style for inputs */
         input[type=text], input[type=password] {
            width: 80%;
            padding: 12px 20px;
            margin: auto;
            display: block;
            border: 1px solid #ccc;
            box-sizing: border-box;
         }

         /* Set style for button */
         button {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: auto;
            border: none;
            cursor: pointer;
            width: 80%;
            display: block;
         }

         /* Hover effect for button */
         button:hover {
            opacity: 0.8;
         }

         /* Add padding style to containers */
         .container {
            padding: 16px;
            width: 50%;
            margin: auto;
         }

         /* Change default style of hr */
         hr {
            border: 1px solid #f1f1f1;
            margin-bottom: 25px;
            width: 90%;
         }
         
         /* Styles for headings*/
         h1, h4{
            text-align: center;
            color: #000000;
         }

         a {
            color: blue;
         }
      </style>
      
   </head>
	
   <body>
      
      <h1>Shuttle Bus Log Collection</h1>
      <h1>Admin Desktop</h1> 
      
      <div class = "container">
      
         <form actio="" method="post">

            <div class="container">
               <label for="username"><b>Username:</b></label>
               <input type="text" placeholder="Enter Username" name="username" required>
               <br>
               <label for="password"><b>Password:</b></label>
               <input type="password" placeholder="Enter Password" name="password" required>
               <hr>
               <button type="submit">Login</button>

            </div>
         </form>
         <h4>Need an account? Register <a href ="Register.php">here</a>.</h4>

      </div> 
      
   </body>
</html>