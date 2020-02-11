<?php
require_once  "Banner.php";
require_once "config.php";

$password = "";
$admin = 0;
$password_err = "";

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$id = "";
$id = $queries['id'];
 

if($id === "")
{
	echo "Oops! Something went wrong, there doesnt appear to be a query string";
}
else if($_SERVER["REQUEST_METHOD"] == "POST")
{   
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } else{
        $password = trim($_POST["password"]);
    }

	$admin = isset($_POST['admin']) && $_POST['admin']  ? 1 : 0;
		
    if(empty($password_err)){
        $sql = "Update user Set password = ?, admin = ? Where username = ?";
        		
        if($statement = $conn->prepare($sql)){
            $statement->bind_param("sis", $password, $admin, $id);  
			if($statement->execute())
			{
				if($statement->affected_rows === 0) 
				{
					echo "User was not updated for some reason";
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
}
else
{	
	$sql = "SELECT * FROM user WHERE username = ?";
	try{
		if($statement = $conn->prepare($sql)){
			$statement->bind_param("s", $id);
			if($statement->execute()){
				$statement->store_result();
				if($statement->num_rows == 1)
				{                    
                    $statement->bind_result($id, $password, $admin);
					$statement->fetch();
				}
				else
				{
					echo "Oops! Something went wrong. Please try again later.";
				}				
			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}
		}
		$conn->close();
	}
	catch (Exception $e)
	{
		$errno = $conn->errno;
		echo "Oops! Something went wrong, Error Has Occurred: $errno";
	}
}
?>


<html>
    <div>
        <h1>Update User</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" disabled="disabled" name="username" value="<?php echo $id; ?>">
            </div>    
            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?php echo $password; ?>">
				<span class="help-block"><?php echo $password_err; ?></span>
            </div>
			<div>
                <label>Administrator</label>
				<?php
					if($admin == 1)
					{
						echo "<input type='checkbox' name='admin' value='yes' checked='checked'>";
					}
					else
					{
						echo "<input type='checkbox' name='admin' value='yes'>"; 
					}
                ?>
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>    
</html>