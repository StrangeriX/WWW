<?php include "database.php"; ?>

<?php
	$con 	= Database::connect();
	if (isset($_GET['id'])) {
	
		$stmt = $con->query('SELECT * FROM Gracz INNER JOIN Grupy ON Gracz.idGrupa=Grupy.id  WHERE Gracz.id='.$_GET['id'].' LIMIT 1');
		$gracz = $stmt->fetch();
	}
	else {
		header('Location: index.php');
	}
	echo $_GET['Gracz.id'];
	Database::disconnect();
	unset($stmt);
	unset($con);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="uft-8">
    <title>Document</title>
 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">

	<form action="" method="POST">
		<div class="form-group">
			<h1 class='text-center font-weight-bold'>Nazwa gracz</h1>
			<h2 class='text-center text-monoscope'><?php echo $gracz[nick];?></h2>
			<br>
			<h1 class='text-center font-weight-bold'>Rola</h1>
			<h2 class='text-center text-monoscope'><?php echo $gracz[rola]; ?><h2>
			<br>
			<h1 class='text-center font-weight-bold'>Dru¿yna</h1>
			<h2 class='text-center text-monoscope'><?php echo $gracz[nazwa];?></h2>
		
		</div>
		<div class="form-group">
			<a class="btn btn-primary" href="index.php">Cofnij</a>
		</div>
	</form>
</div>
</body>