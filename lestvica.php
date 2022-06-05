<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Igra - Lestvica</title>
		<link rel="stylesheet" type="text/css" href="stil.css" />
		<script src="JS/lestvica.js"></script>
		<script src="JS/lestvicaStrelci.js"></script>
	</head>
	<body>
		<div class="center">
			<?php include "Meni.php"?>
			<?php
				if (isset($_SESSION['username'])){ 
			?>
			<h2>Pregled ligaških lestvic</h2>
			<p>Na tej strani lahko vidimo posamezne ligaške lestvice in lestvice strelcev v posameznih ligah.</p>
			<form id="obrazec">
				<label for="liga">Izberite težavnost:</label>
				<select name="liga" class='dropdown'>
					<option value="1">Prva liga</option>
					<option value="2">Druga liga</option>
				</select> 
				<input type="button" onClick="lestvica(); return false" value="Klubi">
				<input type="button" onClick="lestvicaStrelci(); return false" value="Strelci">
			</form>
			<table id="tabela"></table>
			<p>Resetiranje tabele</p>
			<button onClick="ponastaviLestvico(); return false" class='button button3'>Ponastavi lestvico</button>
			<?php
				}
				else {
					header("location:prijava.php");
				}
			?>
			<div id="odgovor"></div>
		</div>
	</body>
</html>
