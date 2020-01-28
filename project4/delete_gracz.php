<?php
	include "database.php";

	$con = Database::connect();

	if (isset($_GET['id'])) {
		$stmt = $con->prepare("DELETE FROM Gracz WHERE id=:id");
		$stmt->execute(['id' => $_GET['id']]);
		$stmt = null;
	}

	Database::disconnect();
	header('Location: index.php');
?>