<?php
	require_once "pdo.php";
	session_start();

	if(isset($_POST['delete'])){
		$sql = "DELETE FROM autos WHERE autos_id = :zip";
		$stmt = $pdo -> prepare($sql);
		$stmt -> execute(array(':zip' => $_POST['autos_id']));
		$_SESSION['success'] = 'Record deleted';
		header('Location: index.php');
		return;
	}

	if(!isset($_GET['autos_id'])){
		$_SESSION['error'] = "Missing autos_id";
		header('Location: index.php');
		return;
	}

	$stmt = $pdo->prepare("SELECT model, autos_id FROM autos WHERE autos_id = :xyz");
	$stmt -> execute(array(":xyz" => $_GET['autos_id']));
	$row = $stmt -> fetch(PDO::FETCH_ASSOC);
	if($row === false){
		$_SESSION['error'] = 'Bad value for autos_id';
		header('Location: index.php');
		return;
	}
?>
<!DOCTYPE html>
<html>
	<p>Confirm: Deleting <?= htmlentities($row['model']) ?></p>

	<form method="post">
		<input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
		<input type="submit" value="Delete" name="delete">
		<a href="index.php">Cancel</a>
	</form>
	
</html>