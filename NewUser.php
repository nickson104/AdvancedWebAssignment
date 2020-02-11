<?php
require_once  "Banner.php";
require_once "config.php";

$username = $password = "";
$admin = 0;
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
	
	$admin = isset($_POST['admin']) && $_POST['admin']  ? 1 : 0;

    if(empty($username_err) && empty($password_err)){
        $sql = "Insert into user (Username, Password, Admin) values (?,?,?)";
        		
		try{
			if($statement = $conn->prepare($sql)){
				$statement->bind_param("ssi", $username, $password, $admin);

							
				$param_username = $username;
				
				if($statement->execute()){
					if($stmt->affected_rows === 0) 
					{
						echo "User was not added for some reason";
					}
					else
					{
						header("location: UserList.php");
					}				
				} else{
					echo "Oops! Something went wrong. Please try again later.";
				}
			}
			$conn->close();
		}
		catch (Exception $e)
		{
			if($conn->errno === 1062){
				echo "User with that username already exists. Please choose another username.";
			}
			else
			{
				$errno = $conn->errno;
				echo "Oops! Something went wrong, Error Has Occurred: $errno";
			}
		}
    }
}
?>

<html>
    <div>
        <h1>New User</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" value="">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div>
                <label>Password</label>
                <input type="password" name="password">
				<span class="help-block"><?php echo $password_err; ?></span>
            </div>
			<div>
                <label>Administrator</label>
                <input type="checkbox" name="admin">
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Create">
            </div>
        </form>
    </div>    
</html>