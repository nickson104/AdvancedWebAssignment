<?php
// since this is going to be on all pages if we make sure to persist the session here it will be available in every page
session_start();
?>

<html>
	<div>
		<div style="text-align:right;">
			<a href="Logout.php"><input id="btnLogout" type="button" value="Log Out"/></a>
		</div>
		<div>
			<?php
				$currentpage = $_SERVER['REQUEST_URI'];
				if ($currentpage != "/MainMenu.php"){
				 echo "<a href='MainMenu.php'><input id='btnMainMenu' type='button' value='Return To Main Menu'/></a>";
				}
			?>
		</div>
		<hr/>
	</div>
</html>
