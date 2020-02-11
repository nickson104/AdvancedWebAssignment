<?php
require_once  "Banner.php";
require_once "config.php";

$deckName = "";
$deckName_err = "";

$username = $_SESSION["username"];
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    if(empty(trim($_POST["deckName"]))){
        $deckName_err = "Please enter a name for the deck.";
    } 
	else
	{
		$deckName = trim($_POST["deckName"]);
	}		

    if(empty($deckName_err)){
        $sql = "Insert into Deck (User, Name) values (?,?)";
        		
		try{
			if($statement = $conn->prepare($sql)){
				$statement->bind_param("ss", $username, $deckName);

				
				if($statement->execute()){
					if($statement->affected_rows === 0) 
					{
						echo "Deck was not added for some reason";
					}
					else
					{
						header("location: DeckList.php");
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
        <h1>New Deck</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Deck Name</label>
                <input type="text" name="deckName" value="">
                <span class="help-block"><?php echo $deckName_err; ?></span>
            </div>    
            <div>
                <input type="submit" class="btn btn-primary" value="Create">
            </div>
        </form>
    </div>    
</html>