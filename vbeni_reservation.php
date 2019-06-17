<meta charset="utf-8">
<?php
	
	session_start();
	mb_internal_encoding("utf-8");
	require_once("vbeni_functions.php");
	
	$connect=dbconnect();
	
	if(isset($_POST["resoke"]))
	{
		
		print "belép</br>";
		
	
	$error_reservation["name"]=false;
	
	$error_reservation["email"]=false;
	
	$error_reservation["people"]=false;	
	$error_reservation["date"]=false;
	$error_reservation["time"]=false;
	
	if ($_POST["name"]==="" || 
	    mb_strlen($_POST["name"])>35)
	{
		$error_reservation["name"]=true;
	}
	
	if (filter_var($_POST["email"],
	    FILTER_VALIDATE_EMAIL)===false || 
	    mb_strlen($_POST["email"])>35)
	{
		$error_reservation["email"]=true;
	}
	if (!in_array(true,$error_reservation))
	{
		//accepted>el van e fogadva 0 nincs döntés 1 elfogadva 2 elutasítva
		$sql='INSERT INTO reservation (name, email, people, date, time, accepted)  VALUES (\''.$_POST["name"].'\',
		\''.$_POST["email"].'\',
		\''.$_POST["people"].'\',
		\''.$_POST["date"].'\',
		\''.$_POST["time"].'\',0		
		)';
		
		if (!pg_query($connect,$sql))
		{
			$error_reservation["insert"]=true;
		}
		$sql='UPDATE visitors SET name=\''.$_POST["email"].'\' WHERE name=\''.$_COOKIE["visitor"].'\'';
		pg_query($connect,$sql);
	}
	}
	//$_SESSION["error_reservation"]=$error_reservation;
	header("Location: vbeni_index.php");
		//var_dump($error_reservation);
	if (isset($_GET["torol"]))	
	{
		$torol=$_GET["torol"];
		$sql='UPDATE reservation SET accepted=\'1\' WHERE id=\''.$torol.'\'';
		$to=$torol['email'];
		
					
		$subject="Asztal foglalása";
		$message="Sajnos a foglalását elutasítottuk";
		pg_query($connect,$sql);
		mail($to, $subject, $message );
		header("Location: vbeni_admin.php");
	}
	if (isset($_GET["elfogad"]))	
	{
		$elfogad=$_GET["elfogad"];
		$sql='UPDATE reservation SET accepted=\'2\' WHERE id=\''.$elfogad.'\'';
		$to=$elfogad['email'];
		$subject="Asztal foglalása";
		$message="Örömmel tájékoztatom, hogy foglalását elfogadtuk";
		mail($to, $subject, $message );

		pg_query($connect,$sql);
		header("Location: vbeni_admin.php");
	}	
?>