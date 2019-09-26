<meta charset="utf-8">
<?php
session_start();
if (isset($_SESSION["admin"]))
{
	mb_internal_encoding("utf-8");
	require_once("vbeni_functions.php");
	print $_SESSION["admin"];
	print '<a href="vbeni_logout.php"> Kijelentkezés</a>';
	print '<hr>';
	print "<h1>Adminok kezelése</h1>";
	$connect=dbconnect();
	if (isset($_POST["adminaddoke"]))
	{
		$sql='SELECT * FROM puser WHERE email=\''.
		    $_POST["email"].'\'';
		$query=pg_query($connect,$sql);
		if (pg_numrows($query)===0)
		{
			$sql='INSERT INTO puser VALUES (\''.
			    $_POST["email"].'\', \''.
			    md5($_POST["password"]).'\')';
			if (pg_query($connect,$sql))
			{
				print "Admin hozzáadása sikeres";
			}
			else
			{
				print "Admin hozzáadása sikertelen";
			}
		}
		else
		{
			print "Már létező email cím";
		}
	}
	$sql='SELECT * FROM puser';
	$query=pg_query($connect,$sql);
	$admins=pg_fetch_all($query);
	print "<table border=\"1\">";
	foreach($admins as $admin)
	{
		print "<tr>";
		foreach($admin as $ertek)
		{
			print "<td>$ertek</td>";
		}
		print "<td>";
		if ($_SESSION["admin"]!==$admin["email"])
		{
			print "<a href=\"vbeni_torol.php?table=puser&
			field=email&key=".$admin["email"]."\">Törlés
			</a>";
		}
		print "</td>";
		print "</tr>";
	}
	print "</table>";
	print "<br />";
	print '<form name="adminadd" method="post" action="">';
	print 'Email: <input type="text" name="email"> ';
	print 'Password: <input type="password" name="password">';
	print '<input type="submit" name="adminaddoke" value="Add">';
	print '</form>';
	
	//Asztal foglalások
	
	
	print "<hr>";
	print "<h1>Foglalások kezelése</h1>";
	$sql='SELECT * FROM reservation ORDER BY id';
	$query=pg_query($connect,$sql);
	$result=pg_fetch_all($query);
	if ($result!==false)
	{
		print '<table border="1">';
		foreach ($result as $record)
		{
			print "<tr>";
			foreach ($record as $field)
			{
				print "<td>$field</td>";
				
			}
			
			if($field==='0')
				{
					print "<td>";
					print '<form name="login" method="post" action="">';
					
					$i=$record['id'];
					print "<a href=\"http://c-ta-php.ttk.pte.hu/~vbeni/hazi_feladat/vbeni_reservation.php?torol=".$i."\">";
					print "Elutasítás</a>";
					print " / ";
					print "<a href=\"http://c-ta-php.ttk.pte.hu/~vbeni/hazi_feladat/vbeni_reservation.php?elfogad=".$i."\">";
					print "Elfogad</a>";
					print "</form>";
					print "</td>";
					
					
				}
			if($field==='1')
			{
				print "<td>";
				print "Elutasítva";
				print "</td>";
			}
			if($field==='2')
			{
				print "<td>";
				print "Elfogadva";
				print "</td>";
			}

			
			print "</tr>";
		}
		
		
		print '</table>'; 
	}
		
//Menü módoítása
	print "<hr>";
	print "<h1>Menü kezelése</h1> ";
	
	if(isset($_POST["menuaddoke"]))
	{
		addMenu($connect);				
	}
		
	if(isset($_POST["menumodifyoke"]))
	{
		modifyMenu($connect);		
	}
	
	
		

	
	$sql='SELECT id,date,name,price,description
	FROM menu';
	$query=pg_query($connect,$sql);
	$result=pg_fetch_all($query);
	
	
	print "<table border=\"1\">";
	if ($result!==false)
	{
		print '<table border="1">';
		foreach ($result as $record)
		{
			print "<tr>";
			print '
				<form enctype="multipart/form-data" name="modifyEvent" method="post" action="">
				<td><input type="date" name="date" value="'.$record['date'].'"></td>
				
				<td><input type="text" name="name" value="'.$record['name'].'"></td>
				<td><input type="text" name="price" value="'.$record['price'].'"></td>
				<td><input type="text" name="description" value="'.$record['description'].'"></td>				
				<td><input type="submit" value="Módosítás" name="menumodifyoke"/></td>
				<td><a href="vbeni_torol.php?table=menu&field=id&key='.$record['id'].'">Törlés</a></td>
				<input type="hidden" name="table" value="menu" />
				<input type="hidden" name="field" value="id" />
				<input type="hidden" name="key" value="' . $record['id'] . '" />
				</form>';
			print"</td>";
			
			print "</tr>";
		}
		print '</table>';
	}
	
	print "<br />";
	print '<form enctype="multipart/form-data" name="eventadd" method="post" action="">';
	print 'Nap: <input type="date" name="date"> ';		
	print 'Név: <input type="text" name="name"> ';
	print 'Ár: <input type="text" name="price"> ';
	print 'Leírás: <input type="text" name="description"> ';	
	print '<input type="submit" name="menuaddoke" value="Add" method="post">';
	
	print "</table>";
	print "<br />";
	print '</form>';
	
	//Látogatások nyomonkövetése
	print "<hr>";
	print "<h1>Látogatók</h1>";
	$sql='SELECT * FROM visitors ORDER BY id';
	$query=pg_query($connect,$sql);
	$result=pg_fetch_all($query);
	print "<table border=\"1\">";
	if ($result!==false)
	{
		print '<table border="1">';
		foreach ($result as $record)
		{
			print "<tr>";
			foreach ($record as $field)
			{
				print "<td>$field</td>";
				
			}
			print"</tr>";
		}
		print '</table>';
	}
	
	
	
	
	
}
else
{
	header("Location: vbeni_login.php");
}
?>
