<?php
$servername = "localhost";
$username = "CardLibraryUser";
$password = "j7URSbWCwdLJNXcu";
$database = "cardgame";

$conn = new mysqli($servername, $username, $password, $database) or die("Connect failed: %s\n". $conn -> error);
?>