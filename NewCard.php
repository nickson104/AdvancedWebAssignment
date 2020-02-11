<?php
require_once  "Banner.php";
require_once "config.php";

$cardName = $cardText = "";
$cardName_err = "";
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["cardName"]))){
        $cardName_err = "Please enter a name for the card.";
    } 
	else
	{
		$cardName = trim($_POST["cardName"]);
	}		
	
	$cardText = trim($_POST["cardText"]);

    if(empty($cardName_err)){
        $sql = "Insert into Card (Name, Text) values (?,?)";
        		
		try{
			if($statement = $conn->prepare($sql)){
				$statement->bind_param("ss", $cardName, $cardText);

				
				if($statement->execute()){
					if($statement->affected_rows === 0) 
					{
						echo "Card was not added for some reason";
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
		catch (Exception $e)
		{
			$errno = $conn->errno;
			echo "Oops! Something went wrong, Error Has Occurred: $errno";
		}
    }
}
?>

<html>
    <div>
        <h1>New Card</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Card Name</label>
                <input type="text" name="cardName" value="">
                <span class="help-block"><?php echo $cardName_err; ?></span>
            </div>    
			<div>
                <label>Card Description</label>
                <input type="text" name="cardText" value="">
            </div>    
            <div>
                <input type="submit" class="btn btn-primary" value="Create">
            </div>
        </form>
    </div>    
</html>