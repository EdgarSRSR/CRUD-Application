<?php
	require_once "pdo.php";
	session_start();

	$make = "";
	$model = "";
	$year = "";
	$mileage = "";


	if ( ! isset($_SESSION['name']) ) {
    	die('ACCESS DENIED');
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

	    if( isset($_POST['Cancel'])){
			header('Location: index.php');
			return;
		}
	    $sql = "INSERT INTO autos (make, model, year, mileage)
	              VALUES (:make, :model, :year, :mileage)";
	    $stmt = $pdo->prepare($sql);
	    $stmt->execute(array(
	        ':make' => $_POST['make'],
	        ':model' => $_POST['model'],
	        ':year' => $_POST['year'],
	    	':mileage' => $_POST['mileage']));
	    $_SESSION['success'] = 'Record Added';
	    header( 'Location: index.php' ) ;
	    return;
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Edgar Solis Add Page</title>
		<?php require_once "bootstrap.php"; ?> 
	</head>
	<body>
		<div class="container">
			<?php
					echo '<h1>Tracking Automobiles for ';
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
				<p><input type="submit" value="Add"></p>
				<p><input type="submit" value="Cancel"></p>
			</form>
		</div>
		
	</body>
</html>