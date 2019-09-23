<?php
	require_once "pdo.php";
	session_start();

	if ( ! isset($_SESSION['name']) ) {
    	die('ACCESS DENIED');
	}

	if( isset($_POST['Cancel'])){
		header('Location: index.php');
		return;
	}

	if ( isset($_POST['make']) && isset($_POST['model'])
     && isset($_POST['year']) && isset($_POST['mileage'])) {
	    // Data validation
	    if ( strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 
	    	|| is_null($_POST['year']) || is_null($_POST['mileage'])) {
	        $_SESSION['error'] = 'All fields are required';
	        header("Location: add.php");
	        return;
	    }
	    if ( !is_numeric($_POST['year']) ) {
	        $_SESSION['error'] = 'Year must be an integer';
	        header("Location: add.php");
	        return;
	    }
	    if ( !is_numeric($_POST['mileage']) ) {
	        $_SESSION['error'] = 'Mileage must be an integer';
	        header("Location: add.php");
	        return;
	    }
	    $sql = "UPDATE autos SET make = :make, model = :model, year = :year, mileage = :mileage
	    		WHERE autos_id = :autos_id";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':make' => $_POST['make'],
	        ':model' => $_POST['model'],
	        ':year' => $_POST['year'],
	    	':mileage' => $_POST['mileage'],
			':autos_id' => $_POST['autos_id']));
	    $_SESSION['success'] = 'Record updated';
	    header( 'Location: index.php' ) ;
	    return;
	}

	if ( ! isset($_GET['autos_id']) ) {
	  $_SESSION['error'] = "Missing autos_id";
	  header('Location: index.php');
	  return;
	}
	$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :xyz");
	$stmt->execute(array(":xyz" => $_GET['autos_id']));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ( $row === false ) {
	    $_SESSION['error'] = 'Bad value for autos_id';
	    header( 'Location: index.php' ) ;
	    return;
	}

	if(isset($_SESSION['error'])) {
		echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
		unset($_SESSION['error']);
	}

	$make = htmlentities($row['make']);
	$model = htmlentities($row['model']);
	$year = htmlentities($row['year']);
	$mileage = htmlentities($row['mileage']);
	$autos_id = $row['autos_id'];


?>
<!DOCTYPE html>
<html>
	<head>
		<title>Edgar Solis Edit Page</title>
		<?php require_once "bootstrap.php"; ?> 
	</head>
	<body>
		<div class="container">
			<?php
					echo '<h1>Tracking Autos for ';
					echo htmlentities($_SESSION['name']);
					echo '</h1>';
			?>

			<?php
				if(isset($_SESSION['error']) ){
					echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
					unset($_SESSION['error']);
				} 
			?>

			<form method="post">
				<p>Make:
					<input type="text" name="make" size="40" value="<?= htmlentities($make) ?>"/></p>
				<p>Model:
					<input type="text" name="model" size="40" value="<?= htmlentities($model) ?>"/></p>
				<p>Year:
					<input type="numeric" name="year" size="20" value="<?= htmlentities($year) ?>"/></p>
				<p>Mileage:
					<input type="numeric" name="mileage" size="20" value="<?= htmlentities($mileage) ?>"/></p>
				<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
				<p><input type="submit" value="Save"></p>
				<p><input type="submit" value="Cancel"></p>
			</form>
		</div>
		
	</body>
</html>