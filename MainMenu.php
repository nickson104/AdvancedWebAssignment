<?php
require_once  "Banner.php";

?>

<html>
<div>
<a href="CardList.php"><input id="btnListCards" type="button" value="View Card Library"/></a>
<a href="DeckList.php"><input id="btnListDecks" type="button" value="View Your Decks"/></a>

<?php
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true){
echo "<a href='UserList.php'><input id='btnUsers' type='button' value='User Administration'/></a>";
}
?>

</div>
</html>