<?php
require_once  "Banner.php";
require_once "config.php";

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$id = "";
$id = $queries['id'];
$deck = "";
$deck = $queries['deck'];
 
if($id === "")
{
	echo "Oops! Something went wrong, there doesnt appear to be a query string";
}
else
{
	$sql = "Insert into deckcard (deck, card) values (?,?)";
	try
	{	
		if($statement = $conn->prepare($sql)){
			$statement->bind_param("ii", $deck, $id);
			if($statement->execute()){
					if($statement->affected_rows === 0) 
					{
						echo "DeckCard was not added for some reason";
					}
					else
					{
						header("location: Deck.php?id=$deck");
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

