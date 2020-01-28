<?php include "database.php"; ?>

<?php
	$con = Database::connect();
	if (isset($_GET['id'])) {
		echo $_GET['id'];
		$grupy = $con->query('SELECT * FROM Grupy INNER JOIN Gracz ON Gracz.idGrupa=Grupy.id WHERE Grupy.id='.$_GET['id'].' ORDER BY rola');
		
	}
	else {
		//header('Location: index.php');
	}
	echo $_GET['Grupy.id'];
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
			<table class='table table-striped table bordered'>
			<thead class='thead-dark'>
				<tr>
					<th>Nazwa Gracza</th>
					<th>Rola</th>
				</tr>
			</thead >
			<tbody>
			 <?php foreach ($grupy as $grupa): ?>
				<tr>
					<td><?php echo $grupa['nick'];?></td>
					<td><?php echo $grupa['rola'];?></td>

				</tr>
				
			</tbody>
		 <?php endforeach; ?>
		</table>
		
		</div>
		<div class="form-group">
			<a class="btn btn-primary" href="index.php">Cofnij</a>
		</div>
	</form>
</div>
</body>