<?php
require_once  "Banner.php";
require_once "config.php";

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$id = "";
$id = $queries['id'];
 
if($id === "")
{
	echo "Oops! Something went wrong, there doesnt appear to be a query string";
}
else
{
	$sql = "Delete from Deck Where Id = ?";
			
	try{
		if($statement = $conn->prepare($sql)){
			$statement->bind_param("i", $id);
			if($statement->execute()){
				if($statement->affected_rows === 0) 
				{
					echo "Deck could not be removed";
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
?>

