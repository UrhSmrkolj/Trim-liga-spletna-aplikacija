<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Igra - Vpis igralca</title>
		<link rel="stylesheet" type="text/css" href="stil.css" />
		<script src="JS/klubi.js"></script>
		<script src="JS/dodajTocke.js"></script>
	</head>
	<body>
		<div class="center">
			<?php include "Meni.php"?>
			<?php
				if (isset($_SESSION['username'])){ 
			?>
			<h2>Dodajanje klubskih točk</h2>
			<p>Tukaj lahko dodamo zmago (3 točke) ali pa remi (1 točka) posameznemu klubu. V prihodnosti bi
			stvar lahko avtomatiziral do te mere, da bi administrator zabeležil izid tekme, točke pa bi se same dodale.
			Hkrati bi se izid zabeležil v podatkovno bazo.</p>
			<form id="obrazec" onsubmit="lestvica(); return false;">
				<label for="liga">Izberite ligo:</label>
				<select name="liga" class='dropdown'>
					<option value="1">Prva liga</option>
					<option value="2">Druga liga</option>
				</select> 
				<input type="submit" value="OK" />
			</form>
			<form id="obrazecKlubi">
				<label for="klubi">Izberi klub:</label>
				<select name="klubi" id="klubi" class='dropdown'>

				</select>
				<input type="button" onClick="zmaga(); return false" value="Zmaga">
				<input type="button" onClick="remi(); return false" value="Remi">
			</form>
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

