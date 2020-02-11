<?php
require_once  "Banner.php";
require_once "config.php";

$cardName = $cardText = "";
$cardName_err = "";

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
    if(empty(trim($_POST["cardName"]))){
        $cardName_err = "Please enter a name.";     
    } else{
        $cardName = trim($_POST["cardName"]);
    }
	
	$cardText = trim($_POST["cardText"]);
		
    if(empty($cardName_err)){
        $sql = "Update card Set Name = ?, Text = ? Where Id = ?";
        		
        if($statement = $conn->prepare($sql)){
            $statement->bind_param("ssi", $cardName, $cardText, $id);  
			if($statement->execute())
			{
				if($statement->affected_rows === 0) 
				{
					echo "Card was not updated for some reason";
				}
				else
				{
					header("location: CardList.php");
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
	$sql = "SELECT * FROM card WHERE id = ?";
	try{
		if($statement = $conn->prepare($sql)){
			$statement->bind_param("i", $id);
			if($statement->execute()){
				$statement->store_result();
				if($statement->num_rows == 1)
				{                    
                    $statement->bind_result($id, $cardName, $cardText);
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
        <h1>Update Card</h1>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
            <div>
                <label>Card Name</label>
                <input type="text" name="cardName" value="<?php echo $cardName; ?>">
				<span class="help-block"><?php echo $cardName_err; ?></span>
            </div>    
            <div>
                <label>Card Text</label>
                <input type="text" name="cardText" value="<?php echo $cardText; ?>">
				
            </div>
            <div>
                <input type="submit" class="btn btn-primary" value="Update">
            </div>
        </form>
    </div>    
</html>