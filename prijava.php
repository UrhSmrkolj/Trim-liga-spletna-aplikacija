<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Igra - Vpis igralca</title>
		<link rel="stylesheet" type="text/css" href="stil.css" />
		<script src="JS/prijava.js"></script>
	</head>
	<body>
		<div class="center">
			<?php include "Meni.php"?>
			<?php
				if (!isset($_SESSION['username'])){ 
			?>
			<h2>Prijava</h2>
			<div class="prijavni-obrazec">
				<form id="obrazec" onsubmit="prijava(); return false;">
				<label for="fname">Ime:</label><br>
				<input type="text" id="username" name="username" placeholder="Vpiši uporabniško ime..."><br>
				<label for="lname">Priimek:</label><br>
				<input type="password" id="geslo" name="geslo" placeholder="Vpiši prijavno geslo..."><br><br>
				<input type="submit" value="Prijavi se" />
				</form>
			<?php
				}
				else {
					header("location:index.php", true);
					exit();
				}
			?>
			</div>
			<div id="odgovor"></div> 
		</div>
	</body>
</html>