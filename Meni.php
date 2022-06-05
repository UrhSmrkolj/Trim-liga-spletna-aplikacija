	<?php
		session_start();
	?>
	
	<div class="float1">
		<img id="logo" src="slike/zoga.jpg"/>
	</div>
	<div class="float2">
		<img id="logo" src="slike/zoga.jpg"/>
	</div>
	<div class="clearFloat"></div>
	<h1 id="title">Liga - administratorski vmesnik</h1>
	<ul>
	<li><a href="index.php" class="active">Domaca stran</a></li>
	<?php
		if(isset($_SESSION["username"])) {
			echo "<li><a href='dodajTocke.php'>Točke</a></li> ";
			echo "<li><a href='vsiIgralci.php'>Igralci</a></li> ";
			echo "<li><a href='lestvica.php'>Lestvica</a></li> ";
			echo "<li><a href='ligaAPI/odjava.php'>Odjava</a></li>";
			
		}
		else {
			echo "<li><a href='prijava.php'>Prijava</a></li> ";
		}
	?>
	</ul>
	<hr/>