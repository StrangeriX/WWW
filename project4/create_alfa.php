<?php include "database.php"; ?>

<?php
    $con = Database::connect();
 
    $gracze = $con->query("SELECT * from Gracz");
	$alfa = $con->query('SELECT * from Alfa INNER JOIN Gracz ON Alfa.IDGracz=Gracz.id');
 
    Database::disconnect();
	unset($con);
?>
<?php
 
    if (isset($_POST['nick'])) {
		$id = $_POST['id'];
        $nick = $_POST['IDgracz'];
		
 
        $con = Database::connect();
         
        $stmt = $con->prepare("INSERT INTO Alfa (idGracz) VALUES (:IDGracz)");
        $stmt->bindparam(':IDGracz', $IDGracz);
		
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
    <h2>Dodaj Role</h2>
 
    <form action="create_alfa.php" method="POST">
        <div class="form-group">
            <label for="nick">Nazwa gracza</label>
            <?php 
				
				foreach ($alfa as $value): ?>
                
                   <br> <?php echo $value['nick'];?>
				   <br> 
               
            <?php endforeach; ?>
        </div>
		<div class="form-group">
            <label for="roleName">rola gracza</label>
			<select name='rola'>
				<?php 
				$role = array("DD","TANK","HEAL");
				foreach ($role as $value): ?>
                
                    <?php echo "<option value=".$value.">$value</option>";?>
               
            <?php endforeach; ?>
			 </select>

        </div>
		
        <div class="form-group">
            <button type="zapisz" class="btn btn-primary">Dodaj</button>
        </div>
    </form>
</div>
 
</body>