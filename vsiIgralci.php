<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Igra - Vsi igralci</title>
		<link rel="stylesheet" type="text/css" href="stil.css" />
		<script src="JS/vsiIgralci.js"></script>
		<script src="JS/klubi.js"></script>
	</head>
	<body onload="vsiIgralci();">
		<div class="center">
			<?php include "Meni.php"?>
			<?php
				if (isset($_SESSION['username'])){ 
			?>
		<h2>Spisek igralcev</h2>
		<p>Ta stran omogoča upravljanje z igralci. Glede na naše iskanje, nam stran filtrira igralce po imenu.
		Igralcu je mogoče posodobiti klub, v katerem igra. Poleg tega lahko igralcu dodamo zadeteke in kartone. V prihodnosti
		bi lahko vključil avtomatsko opozarjanje ob prekoračitvi števila kartonov.</p><br>
		<p>Pod spiskom igralcev je obrazec za dodajanje novega igralca, ki mu je potrebno določiti klub. Čisto spodaj lahko resetiramo
		statistiko igralcev (npr. ob končanem prvestvu/ligi).</p>
		<input type="text" id="myInput" onkeyup="filterFunction()" placeholder="Išči po imenih..." title="Type in a name">
		<br>
			<table id="tabela">
				<tr>
					<th>Ime</th>
					<th>Priimek</th>
					<th>Klub</th>
					<th>Goli</th>
					<th>Kartoni</th>
					<th>Index</th>
					<th>Administracija</th>
				</tr>
			</table>
			<div id="dodajanje">
			<h2> Dodajanje novega igralca </h2>
			<form id="obrazec" onsubmit="lestvica(); return false;">
				<label for="fname"><p>Ime:</p></label><br>
					<input type="text" id="fname" name="fname" placeholder="Ime..."><br>
				<label for="lname"><p>Priimek:</p></label><br>
					<input type="text" id="lname" name="lname" placeholder="Priimek..."><br>
				<label for="liga"><p>Izberite ligo:</p></label><br>
					<select name="liga" class='dropdown'>
						<option value="1">Prva liga</option>
						<option value="2">Druga liga</option>
					</select>
					<input type="submit" value="Filtriraj" /><br>
				<label for="klubi"><p>Izberi klub:</p></label><br>
					<select name="klubi" id="klubi" class='dropdown'>
					</select>
					<input type="button" onClick="dodajIgralca(); return false" value="Dodaj igralca">
			</form></div>
			<div id="resetiranje">
			<h2> Resetiranje statistike igralcev. </h2>
			<button onClick="ponastaviStatistiko(); return false" class='button button3'>Ponastavi statistiko</button>
			<?php
				}
				else {
					header("location:prijava.php");
				}
			?>
			</div>
			<div id="odgovor"></div>
		</div>
	</body>
</html>
