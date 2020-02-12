<?php
require_once  "Banner.php";

?>

<html>
<h1>What would you like to do?</h1>
<div>
<a href="CardList.php"><input id="btnListCards" type="button" value="View Card Library"/></a>
<a href="DeckList.php"><input id="btnListDecks" type="button" value="View Your Decks"/></a>

<?php
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
echo "<a href='UserList.php'><input id='btnUsers' type='button' value='Administrate Users'/></a>";
}
?>

</div>
</html>