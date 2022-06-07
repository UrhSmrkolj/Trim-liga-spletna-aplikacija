<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>Igra - Prva stran</title>
		<link rel="stylesheet" type="text/css" href="stil.css" />
	</head>
	<body>
		<div class="center">
			<?php include 'Meni.php'; ?>
			<h2>Stran za ligaške administratorje.</h2>
			<p>Na tej strani je na kratko predstavljen projekt trim liga. Na spletnem administratorskem vmesniku lahko
			ligaški aministratorji strbijo za ažurnost podatkov (klubske točke, igralčevi goli...), urejajo igralčeve podatke
			, dodajajo in odstranjujejo igralce in podobno.</p><br>
			<p>Spodaj je vidna tudi tabela APIjev uporabljenih v spletni in mobilni aplikaciji, ki služijo za povezavo frontenda z backendom (php + mySql baza). Pod tabelo je vidna projektna arhitektura, pod tem
			pa tudi posnetki zaslona mobilne aplikacije, ki služi za spremljanje rezultatov. V prihodnosti bi se lahko uporabniku servirala 
			personalizirana vsebina na podlagi njegovega najljubšega kluba.</p><br>
			<h3>REST API</h3>
			<div class="apidiv">
			<img class="api" src="slike/API.png"/>
			</div><br>
			<h3>ARHITEKTURA</h3>
			<div class="apidiv">
			<img class="api" src="slike/arhitektura.png"/>
			</div>
			<h3>POSNETKI ZASLONA</h3>
			<div class="apidiv">
			<img class="api" src="slike/API.png"/>
			</div>
		</div>
	</body>
</html>

