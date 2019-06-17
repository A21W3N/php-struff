<meta charset="utf-8">
<?php
session_start();
mb_internal_encoding("utf-8");
	require_once("vbeni_functions.php");
	$connect=dbconnect();
	if (isset($_GET["key"]) && isset($_GET["field"]) && 
	    isset($_GET["table"]))
	{
		$sql='DELETE FROM '.$_GET["table"].
		' WHERE '.$_GET["field"].'=\''.$_GET["key"].'\'';
		pg_query($connect,$sql);
	}