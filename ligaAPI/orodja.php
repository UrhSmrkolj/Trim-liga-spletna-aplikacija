<?php


function dbConnect()
{
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "liga";

	$conn = mysqli_connect($servername, $username, $password, $dbname);
	mysqli_set_charset($conn,"utf8");
	
	if (mysqli_connect_errno())
	{
		printf("Povezovanje s podatkovno bazo ni uspelo: %s\n", mysqli_connect_error());
		exit();
	} 	
	return $conn;
}


function pripravi_odgovor_napaka($vsebina)
{
	$odgovor=array(
		'status' => 0,
		'error_message'=>$vsebina
	);
	echo json_encode($odgovor);
}


function klub_obstaja($klub)
{	
	global $zbirka;
	$klub=mysqli_escape_string($zbirka, $klub);
	
	$poizvedba="SELECT * FROM klub WHERE klub='$klub'";
	
	if(mysqli_num_rows(mysqli_query($zbirka, $poizvedba)) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}	
}

function igralec_obstaja($ID)
{	
	global $zbirka;
	$ID=mysqli_escape_string($zbirka, $ID);
	
	$poizvedba="SELECT * FROM igralec WHERE ID='$ID'";
	
	if(mysqli_num_rows(mysqli_query($zbirka, $poizvedba)) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}	
}

function admin_obstaja($username, $geslo)
{	
	global $zbirka;
	$username=mysqli_escape_string($zbirka, $username);
	$geslo=mysqli_escape_string($zbirka, $geslo);
	
	$poizvedba="SELECT * FROM admin WHERE (username='$username' && geslo='$geslo')";
	
	if(mysqli_num_rows(mysqli_query($zbirka, $poizvedba)) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}	
}

/*
function geslo_obstaja($geslo, $username)
{	
	global $zbirka;
	$geslo=mysqli_escape_string($zbirka, $geslo);
	$username=mysqli_escape_string($zbirka, $username);
	
	$poizvedba="SELECT username FROM admin WHERE geslo='$geslo'";
	$rezultat = mysqli_query($zbirka, $poizvedba);
	
	if($rezultat)
	{
		while($vrstica=mysqli_fetch_assoc($rezultat))
			{
				$odgovor[]=$vrstica;
			}
			if(substr_compare($odgovor[1],$username,1))
			{
				return true;
			}
	}
	else
	{
		return false;
	}	
}
*/

function liga_obstaja($liga)
{	
	global $zbirka;
	$liga=mysqli_escape_string($zbirka, $liga);
	
	$poizvedba="SELECT * FROM klub WHERE liga='$liga'";
	
	if(mysqli_num_rows(mysqli_query($zbirka, $poizvedba)) > 0)
	{
		return true;
	}
	else
	{
		return false;
	}	
}


function URL_vira($vir)
{
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
	{
		$url = "https"; 
	}
	else
	{
		$url = "http"; 
	}
	$url .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $vir;
	
	return $url; 
}

function upImeObstaja($conn, $upIme){
	$sql = "SELECT * FROM admin WHERE username = ?;";
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt, $sql)){
		header("location: ../prijava.php?error=stmtfailed");
		exit();
	}
}

function emptyInputLogin($upIme, $geslo){
	$result;
	if (empty($username) || empty($geslo)){
		$result = true;
	}
	else{
		$result = false;
	}
	return $result;
}

function prijavaUp($conn, $upIme, $geslo){
	$upImeObstaja = upImeObstaja($conn, $username);
	
	if($upImeObstaja === false){
		header("location:../prijava.php?error=wronglogin");
		exit();
	}
	
	$gesloBaza = $upImeObstaja["geslo"];
	$preveriGeslo = password_verify($geslo, $gesloBaza);
	
	if($preveriGeslo === false){
		header("location:../prijava.php?error=wronglogin");
		exit();
	}
	else if($preveriGeslo === true){
		session_start();
		$_SESSION["upIme"] = $upImeObstaja["username"];
		header("location:../index.php?error=wronglogin");
		exit();
	}	
}

?>