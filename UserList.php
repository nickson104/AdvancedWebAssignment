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

$usernameFilter = "";
$adminFilter = isset($_POST['adminFilter']) && $_POST['adminFilter']  ? 1 : 0;

$actions = [];
$action = new ListAction("View", "User", "View / Edit User", []);
$actions[] = $action;
$action = new ListAction("Delete", "DeleteUser", "Delete User", []);
$actions[] = $action;

$filters = [];
$filter = new ListFilter("Admin", "Bool", $adminFilter);
$filters[] = $filter;

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty(trim($_POST["usernameFilter"]))){
		$usernameFilter = trim($_POST["usernameFilter"]);
		$filter = new ListFilter("Username", "String", $usernameFilter);
		$filters[] = $filter;
	}
}
?>


<html>
	<h1>Users</h1>
	<div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<label style="margin-left:20px">Username</label>
			<input type="text" name="usernameFilter" value="<?php echo $usernameFilter; ?>">
			<label style="margin-left:20px">Administrator</label>
			<?php
			if($adminFilter == 1)
			{
				echo "<input type='checkbox' name='adminFilter' value='yes' checked='checked'>";
			}
			else
			{
				echo "<input type='checkbox' name='adminFilter' value='yes'>"; 
			}
			?>
			<input style="margin-left:20px" type="submit" class="btn btn-primary" value="Refresh Data">
        </form>
	</div>
</html>


<?php
$userDataList = new DataList($username, "user", "Username", $conn);
$userDataList->PopulateActions($actions);
$userDataList->BuildFilter($filters);
$userDataList->GetData();
?>

<html>
<a href="NewUser.php"><input id="btnNewUser" type="button" value="New User"/></a>
</html>
