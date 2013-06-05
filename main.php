<?php
	session_start();
	$sid  = session_id();
if(!isset($_SESSION["Uin"])){
    echo "login";
    die();
}
echo $_SESSION["Uin"];
?>