<?php include "database.php"; ?>
<?php
 
    if (isset($_POST['nick'])) {
		$id = $_POST['id'];
        $nick = $_POST['nick'];
		$rola = $_POST['rola'];
		$idGrupa = $_POST['idGrupa'];
		
 
        $con = Database::connect();
         
        $stmt = $con->prepare("INSERT INTO Gracz (nick,rola,idGrupa) VALUES (:nick,:rola,:idGrupa)");
        $stmt->bindparam(':nick', $nick);
		$stmt->bindparam(':rola', $rola);
		$stmt->bindparam(':idGrupa',$idGrupa);
		
		$stmt->execute();
 
        header("Location: index.php");
 
        Database::disconnect();
    }
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
    <h2>Dodaj Gracza</h2>
 
    <form action="create_gracz.php" method="POST">
        <div class="form-group">
            <label for="nick">Nazwa gracza</label>
            <input type="text" class="form-control" id="nick" aria-describedby="help" name="nick" placeholder="Wprowadz nazwe roli...">

        </div>
		
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
			 <select name='idGrupa'>
                    <option value='1'>Alfa</option>
					<option value='2'>Bravo</option>
			
               

			 </select>

        </div>
		
        <div class="form-group">
            <button type="zapisz" class="btn btn-primary">Dodaj</button>
			<a class="btn btn-primary" href="index.php">Cofnij</a>
        </div>
    </form>
</div>
 
</body>