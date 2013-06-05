<?php
	session_start();
	$sid  = session_id();
if(!isset($_SESSION["Uin"])){
    header( "Location: index.php" );
    die();
}
echo $_SESSION["Uin"];
?>