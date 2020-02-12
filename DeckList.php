<?php
require_once  "Banner.php";
require_once "config.php";
require_once 'DataList.php';
require_once 'ListFilter.php';
require_once 'ListAction.php';

use \Main\DataList;
use \Main\ListFilter;
use \Main\ListAction;

$username = $_SESSION["username"];

$deckNameFilter = "";

$actions = [];
$action = new ListAction("View", "Deck", "View / Edit Deck", []);
$actions[] = $action;
$action = new ListAction("Delete", "DeleteDeck", "Delete Deck", []);
$actions[] = $action; 

$filters = [];
$filter = new ListFilter("User", "StringStrict", $username);
$filters[] = $filter;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty(trim($_POST["deckNameFilter"]))){
		$deckNameFilter = trim($_POST["deckNameFilter"]);
		$filter = new ListFilter("Name", "String", $deckNameFilter);
		$filters[] = $filter;
	}
}
?>


<html>
	<h1>Your Decks</h1>
	<div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<label style="margin-left:20px">Deck Name</label>
			<input type="text" name="deckNameFilter" value="<?php echo $deckNameFilter; ?>">
			<input style="margin-left:20px" type="submit" class="btn btn-primary" value="Refresh Data">
        </form>
	</div>
</html>


<?php
$deckDataList = new DataList($username, "deck", "Id", $conn);
$deckDataList->PopulateActions($actions);
$deckDataList->BuildFilter($filters);
$deckDataList->GetData();
?>

<html>
<a href="NewDeck.php"><input id="btnNewDeck" type="button" value="Create New Deck"/></a>
</html>
