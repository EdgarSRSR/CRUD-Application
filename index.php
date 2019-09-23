<?php
	require_once "pdo.php";
	session_start();
?>


<!DOCTYPE html>
<html>
	<head>
		<title>Edgar Solis - Index</title>
		<?php require_once "bootstrap.php"; ?>
	</head>
	<body>
		<div class="container">
			<h1>Welcome to the Automobiles Database</h1>
		
		<?php

			if (isset($_SESSION['success'])) {

				echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    			unset($_SESSION['success']);
    		}

			if (isset($_SESSION['name'])) {
			
				echo ('<table border="1">'."\n");
				$stmt = $pdo -> query("SELECT make, model, year, mileage, autos_id FROM autos");
				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
					echo "<tr><td>";
					echo (htmlentities($row['make']));
					echo ("</td><td>");
					echo (htmlentities($row['model']));
					echo ("</td><td>");
					echo (htmlentities($row['year']));
					echo ("</td><td>");
					echo (htmlentities($row['mileage']));
					echo ("</td><td>");
					echo ('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a>/');
					echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
	    			echo("</td></tr>\n");
				}
				echo ('</table>'."\n");
				echo ('<a href="add.php">Add New Entry</a>');
				echo ('<br>');
				echo ('<a href="logout.php">Logout</a>');
			} else{
				echo ('<a href="login.php">Please log in</a>'."\n");
				echo ('<p>Attempt to <a href="add.php">add data</a> without logging in</p>');

			}
		?>
		</div>
	</body>

</html>