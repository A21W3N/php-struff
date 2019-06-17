<meta charset="utf-8">
<?php
mb_internal_encoding("utf-8");
session_start();
$error_contact["email"]=false;
$error_contact["insert"]=false;

if (isset($_POST["regbarmi"]))
{

	
	
	require_once('vbeni_functions.php');
	$connect=dbconnect();

	if (filter_var($_POST["email"],	    FILTER_VALIDATE_EMAIL)===false || 	    mb_strlen($_POST["email"])>45)
	{
		$error_contact["email"]=true;
	}
	if (!in_array(true,$error_contact))
	{

		$sql='INSERT INTO subscription  VALUES (\''.$_POST["email"].'\')';
		$to=$_POST["email"];
		$subject="Hírlevélre feliratkozás";
		$message="Hírlevélre feliratkozott, leiratkozás az alábbi linken lehetséges:\n\r
		<a href=\"http://c-ta-php.ttk.pte.hu/~vbeni/hazi_feladat/hirtorles.php?$torol&email=".$_POST["email"]."\">";
		print "Leiratkozás";
		print "</a>";
		//mail($to, $subject, $message );
	if (!pg_query($connect,$sql))
		{
			$error_contact["insert"]=true;
		}
		$sql='UPDATE visitors SET name=\''.$_POST["email"].'\' WHERE name=\''.$_COOKIE["visitor"].'\'';
		if (!pg_query($connect,$sql))
		{
			$error_contact["insert"]=true;
		}
	
	}
	$_SESSION["error_contact"]=$error_contact;
	header("Location: vbeni_index.php");
		var_dump($error_contact);
}
else
{
	header("Location: login.php");
}
?>