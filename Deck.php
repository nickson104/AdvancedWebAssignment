<?php
require_once  "Banner.php";
require_once "config.php";
require_once 'DataList.php';
require_once 'ListFilter.php';
require_once 'ListAction.php';
require_once 'QueryStringItem.php';

use \Main\DataList;
use \Main\ListAction;
use \Main\ListFilter;
use \Main\QueryStringItem;

$username = $_SESSION["username"];

$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);

$deckId = "";
$deckId = $queries['id'];

$querystringItems = [];
$qsItem = new QueryStringItem("deck", $deckId);
$querystringItems[] = $qsItem;

$filters = [];
$cardNameFilter = $cardDescriptionFilter = "";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty(trim($_POST["cardNameFilter"]))){
		$cardNameFilter = trim($_POST["cardNameFilter"]);
		$filter = new ListFilter("Name", "String", $cardNameFilter);
		$filters[] = $filter;
	}
	    if(!empty(trim($_POST["cardDescriptionFilter"]))){
		$cardDescriptionFilter = trim($_POST["cardDescriptionFilter"]);
		$filter = new ListFilter("Name", "String", $cardDescriptionFilter);
		$filters[] = $filter;
	}
}
?>

<html>
	<h1>Current Cards</h1>
</html>

<?php
$actions = [];
$action = new ListAction("Add", "AddCopyDeckCard", "Add Copy", $querystringItems);

$actions[] = $action; 
$action = new ListAction("Delete", "DeleteDeckCard", "Remove Copy", $querystringItems);
$actions[] = $action; 

$deckDataList = new DataList($username, "deckCards", "Id", $conn);
$deckListSQL = "Select c.Name, Max(dc.Id) as Id, Count(*) as Copies from DeckCard dc join Card c on dc.Card = c.Id where dc.Deck = $deckId group by c.Name";
$deckDataList->PopulateActions($actions);
$deckDataList->GetDataManualSQL($deckListSQL);
?>

<html>
	<h1>Add New Cards</h1>
	<div>
        <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
			<label style="margin-left:20px">Card Name</label>
			<input type="text" name="cardNameFilter" value="<?php echo $cardNameFilter; ?>">
			<label style="margin-left:20px">Card Description</label>
			<input type="text" name="cardDescriptionFilter" value="<?php echo $cardDescriptionFilter; ?>">
			<input style="margin-left:20px" type="submit" class="btn btn-primary" value="Refresh Data">
        </form>
	</div>
</html>

<?php

$cardActions = [];
$action = new ListAction("AddCard", "AddDeckCard", "Add card to deck", $querystringItems);
$cardActions[] = $action;

$cardDataList = new DataList($username, "card", "Id", $conn);
$cardDataList->PopulateActions($cardActions);
$cardDataList->BuildFilter($filters);
$cardDataList->GetData();

?>