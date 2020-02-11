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

$cardNameFilter = $cardDescriptionFilter = "";

$actions = [];
$action = new ListAction("View", "Card", "View / Edit Card", []);
$actions[] = $action;
$action = new ListAction("Delete", "DeleteCard", "Delete Card", []);
$actions[] = $action; 

$filters = [];

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
	<div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<label style="margin-left:20px">Card Name</label>
			<input type="text" name="cardNameFilter" value="<?php echo $cardNameFilter; ?>">
			<label style="margin-left:20px">Card Description</label>
			<input type="text" name="cardDescriptionFilter" value="<?php echo $cardDescriptionFilter; ?>">
			<input style="margin-left:20px" type="submit" class="btn btn-primary" value="Refresh Data">
        </form>
	</div>
</html>


<?php
$cardDataList = new DataList("card", "Id", $conn);
$cardDataList->PopulateActions($actions);
$cardDataList->BuildFilter($filters);
$cardDataList->GetData();
?>

<html>
<a href="NewCard.php"><input id="btnNewCard" type="button" value="Create New Card"/></a>
</html>
