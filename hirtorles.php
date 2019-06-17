<meta charset="utf-8">
<?php
mb_internal_encoding("utf-8");
session_start();
if (isset($_GET["email"]))
{
	require_once("vbeni_functions.php");
	$connect=dbconnect();
	
		$sql='DELETE FROM  subscription WHERE email=\''.$_GET["email"].'\'';
		pg_query($connect,$sql);


}



?>