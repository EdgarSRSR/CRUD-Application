<?php
	session_start();

	$salt =  'XyZzy12*_';
	$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';

	if(isset($_POST['email']) && isset($_POST['pass'])){
			if(strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1){
				$_SESSION['error'] = "User name and password are required";
				header("Location: login.php");
				return;
			}else {
				$check = hash('md5', $salt.$_POST['pass']);
				if($check == $stored_hash){
					$_SESSION['name'] = $_POST['email'];
					error_log("Login success ".$_POST['email']);
					header("Location: index.php");
					return;
				} else {
					$_SESSION['error'] = "Incorrect password";
					error_log("Login fail ".$_POST['email']." $check");
					header("Location: login.php");
					return;
				}
			}
	}  

	if(isset($_POST['Cancel'])){
		header("Location: index.php");
		return;
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<?php require_once "bootstrap.php"; ?>
		<title>Edgar Solis Log In Page</title>
	</head>
	<body>
		<div class="container">
			<h1>Please Log In</h1>
			<?php
				if ( isset($_SESSION['error']) ) {
    				echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
    				unset($_SESSION['error']);
				}
			?>
			<form method="POST">
				<label for="nam">User Name</label>
				<input type="text" name="email" id="name"><br/>
				<label for="contrasena">Password</label>
				<input type="text" name="pass" id="contrasena">
				<br>
				<input type="submit" value="Log In">
				<input type="submit" value="Cancel">
			</form>
			<p>For a password hint, view source and find a password hint in the HTML Comments </p>
			<!--The bloody password is php123 -->
		</div>
		
	</body>
</html>