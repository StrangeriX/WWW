<?php include "database.php"; ?>

<?php
	$con 	= Database::connect();
	
	
	$userID = $_POST['nick'];
	$CP 	= $_POST['rola'];
	

	if (isset($_GET['id'])) {
		$stmt = $con->query('SELECT * FROM Gracz WHERE Gracz.id='.$_GET['id'].' LIMIT 1');
		$gracz = $stmt->fetch();
	}
	else {
		header('Location: index.php');
	}

	Database::disconnect();
	unset($stmt);
	unset($con);
?>
<?php
 
    if (isset($_POST['nick'])) {
		$id = $_GET['id'];
        $nick = $_POST['nick'];
		$rola = $_POST['rola'];
		$IDGrupa = $_POST['IDGrupa'];
 
        $con = Database::connect();
         
        $stmt = $con->prepare("UPDATE Gracz SET nick=:nick, rola=:rola, IDGrupa=:IDGrupa WHERE id=:id");
		$stmt->bindparam(':id', $id);
        $stmt->bindparam(':nick', $nick);
		$stmt->bindparam(':rola', $rola);
		if($IDGrupa == "Alfa"){
			$IDGrupa = '1';
			$stmt->bindparam(':IDGrupa',$IDGrupa);
		}else{
			$IDGrupa = '2';
			$stmt->bindparam(':IDGrupa',$IDGrupa);
		}
		$stmt->execute();
 
       header("Location: index.php");
 
        Database::disconnect();
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
<div class="container">
	<h2>Edytuj gracza</h2>

	<form action="" method="POST">
		<div class="form-group">
			<label for="nick">Nazwa gracz</label>
			<input type="text" class="form-control" id="nick" name="nick" value=<?php echo $gracz[1]; ?>>
		
		<div class="form-group">
            <label>rola gracza</label>
			<select name='rola'>
				<?php 
				$role = array("DD","TANK","HEAL");
				foreach ($role as $value): ?>
                
                    <?php echo "<option value=".$value.">$value</option>";?>
               
            <?php endforeach; ?>
			 </select>
			 <label>Grupa</label>
			 <select name='IDGrupa'>
				<?php 
				$grupy = array('Alfa',"Bravo");
				foreach ($grupy as $value): ?>
                
                    <?php echo "<option value=".$value.">$value</option>";?>
               
            <?php endforeach; ?>
			 </select>

        </div>
		
		<div class="form-group">
			<button type="submit" class="btn btn-primary">Zapisz</button>
			<a class="btn btn-primary" href="index.php">Cofnij</a>
		</div>
	</form>
</div>
</body>