<?php
    ini_set( 'error_reporting', E_ALL );
    ini_set( 'display_errors', true );
?>
 
<?php include "database.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="uft-8">
    <title>Document</title>
 
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<body>
 
<?php
    $con = Database::connect();
 
    $gracze = $con->query("SELECT Gracz.nick,Gracz.id,Gracz.rola,Grupy.nazwa from Gracz INNER JOIN Grupy ON Gracz.idGrupa=Grupy.id");
	$grupy = $con->query("SELECT Grupy.id,Grupy.nazwa, COUNT(Gracz.id) AS count FROM Grupy INNER JOIN Gracz ON Gracz.idGrupa=Grupy.id GROUP BY Grupy.nazwa");
 
    Database::disconnect();
	unset($con);
?>
 
<div class="container">
    <h2>Gracze</h2>
    <div>
        <a class="btn btn-success" role="button" href="create_gracz.php">Dodaj Gracza</a>
    </div>
 
    <table class="table table-striped table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>UserID</th>
                <th>Rola</th>
				<th>Funkcje</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($gracze as $gracz): ?>
                <tr>
                    <td><?php echo $gracz['nick']; ?></td>
                    <td><?php echo $gracz['rola']; ?></td>

                    <td>
                        <a class="btn btn-info" role="button" href=<?php echo "read_gracz.php?id=".$gracz['id']; ?>>Podgl¹d</a>
                        <a class="btn btn-primary" role="button" href=<?php echo "edit_gracz.php?id=".$gracz['id']; ?>>Edytuj</a>
                        <a class="btn btn-danger" role="button" href=<?php echo "delete_gracz.php?id=".$gracz['id']; ?>>Usuñ</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
		</table>
		<table class='table table-striped table bordered'>
			<thead class='thead-dark'>
				<tr>
					<th>Nazwa Grupy</th>
					<th>Iloœæ graczy</th>
					<th>Funkcje</th>
				</tr>
			</thead >
			<tbody>
			<?php $nazwy = array();?>
			<?php $uczestnicy = array();?>
			<?php foreach ($grupy as $grupa): ?>
			 
				<tr>
					<td><?php echo $grupa['nazwa']; array_push($nazwy, $grupa['nazwa']);?></td>
					<td><?php echo $grupa['count']; array_push($uczestnicy, $grupa['count']);?></td>
					<td>
                        <a class="btn btn-info" role="button" href=<?php echo "read_grupa.php?id=".$grupa['id']; ?>>Podgl¹d</a>
                    </td>
				</tr>
				
			</tbody>
		 <?php endforeach; ?>
		</table>

 <div id="chartContainer" style="height: 370px; width: 100%;"></div>
</div>



 <script src="https://canvasjs.com/assets/script/canvasjs.min.js"> </script>
<script src='main.js'></script>
<script>
var nazwy = <?php echo json_encode($nazwy);?>;
var uczestnicy = <?php echo json_encode($uczestnicy);?>
</script>
</body>