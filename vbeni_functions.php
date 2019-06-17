<?php
function dbconnect()
{
	$host='localhost';
	$port='5432';
	$dbname='vbeni';
	$user='vbeni';
	$password='újjelszó';
	$connect=pg_connect('host=\''.$host.'\' port=\''.$port.'\' dbname=\''.
	    $dbname.'\' user=\''.$user.'\' password=\''.$password.'\'');
	return($connect);
}

function addMenu($connect)
{
	
	
	
	
	$sql='INSERT INTO menu (date,name,price,description) 
	VALUES (\''.$_POST["date"].'\', \''.$_POST["name"].'\',\''.$_POST["price"].'\', \''.$_POST["description"].'\' )';
	
	pg_query($connect,$sql);
	

}


function modifyMenu($connect)
{
	
	
	$sql='UPDATE menu SET date=\''.$_POST["date"].'\', name=\''.$_POST["name"].'\', price=\''.$_POST["price"].'\', description=\''.$_POST["description"].'\'';
	pg_query($connect,$sql);
}
?>