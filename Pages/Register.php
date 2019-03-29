<?php
require '../Database/connect.php';
 
$firstname = $lastname = $username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{

        $sql = "SELECT id FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($con, $sql)){

            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);

                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($stmt);
    }
    

    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $sql = "INSERT INTO admins (firstname, lastname, username, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($con, $sql)){
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            if(mysqli_stmt_execute($stmt)){
                header("location: Login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($con);
}
?>


<html>
    <head>
        <title>Setup An Account</title>
            <style>
                * {box-sizing: border-box}

                /* Add padding to containers */
                .container {
                  padding: 16px;
                }

                /* Style for input fields */
                input[type=text], input[type=password] {
                  width: 100%;
                  padding: 15px;
                  margin: 5px 0 22px 0;
                  display: inline-block;
                  border: none;
                  background: #f1f1f1;  
                }

                input[type=text]:focus, input[type=password]:focus {
                  background-color: #ddd;
                  outline: none;
                }

                /* Change default style of hr */
                hr {
                  border: 1px solid #f1f1f1;
                  margin-bottom: 25px;
                }

                /* Set a style for the submit/register button */
                .registerbtn {
                  background-color: #4CAF50;
                  color: white;
                  padding: 16px 20px;
                  margin: 8px 0;
                  border: none;
                  cursor: pointer;
                  width: 100%;
                  opacity: 0.9;
                }

                .registerbtn:hover {
                  opacity:1;
                }

                /* Add a blue text color to links */
                a {
                  color: blue;
                }

                /* Style for "sign in" section */
                .signin {
                  background-color: #f1f1f1;
                  text-align: center;
                }
            </style>
    </head>

    <body>

        <form >
            <div class="container">
                <h1>Register</h1>
                <p>Please fill in this form to create an account.</p>
                <hr>

                <label for="firstname"><b>First Name</b></label>
                <input type="text" placeholder="Enter First Name" name="firstname" required>

                <label for="lastname"><b>Last Name</b></label>
                <input type="text" placeholder="Enter Last Name" name="lastname" required>

                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <label for="confirm_password"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="confirm_password" required>
                <hr>
                <button type="submit" class="registerbtn">Submit</button>
            </div>

            <div class="container signin">
                <p>Already have an account? <a href="Login.php">Sign in</a>.</p>
            </div>
        </form>
    </body>
</html>