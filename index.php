<?php
require_once "config.php";

require_once "TextLogger.php";

use \Interfaces\TextLogger;

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: MainMenu.php");
    exit;
}
 
$username = $password = "";
$username_err = $password_err = "";
 
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } 
	else
	{
		$username = trim($_POST["username"]);
	}		
    
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } else{
        $password = trim($_POST["password"]);
    }

    if(empty($username_err) && empty($password_err)){
        $sql = "SELECT * FROM user WHERE username = ?";
        		
        if($statement = $conn->prepare($sql)){
            $statement->bind_param("s", $param_username);
            			
            $param_username = $username;
            
            if($statement->execute()){
                $statement->store_result();
                if($statement->num_rows == 1){                    
                    $statement->bind_result($username, $dbPassword, $admin);
                    if($statement->fetch()){
                        if($password == $dbPassword){
                            $_SESSION["loggedin"] = true;
                            $_SESSION["username"] = $username; 
							$_SESSION["admin"] = $admin == "1"; 							
                            
							$logger = new TextLogger($username);
							$logger->LogAccess();
							
                            header("location: MainMenu.php");
                        } else{
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    $username_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
		}
        $conn->close();
    }
}
?>
 
<!DOCTYPE html>
<html>
    <div>
        <h1>Login</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" value="">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control">
				<span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
        </form>
    </div>    
</html>