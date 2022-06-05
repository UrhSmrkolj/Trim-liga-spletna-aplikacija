<?php
$DEBUG = true;							

include("orodja.php"); 					

$zbirka = dbConnect();					

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');	

switch($_SERVER["REQUEST_METHOD"])			
{
	case 'PUT':
		if(!empty($_GET["prijava"]))
		{
			http_response_code(400);
			//pripravi_odgovor_napaka("Do sem pridem");
		}
		else
		{	
			prijava();
			//pripravi_odgovor_napaka("1");
		}
		break;
	default:
		http_response_code(405);	
		break;
}


function prijava()
{
	global $zbirka, $DEBUG;
	
	$podatki = json_decode(file_get_contents('php://input'), true);
	
	if(isset($podatki["username"], $podatki["geslo"]))
	{
		$username = mysqli_escape_string($zbirka, $podatki["username"]);
		$geslo = mysqli_escape_string($zbirka, $podatki["geslo"]);
			
		if(admin_obstaja($username, $geslo))
		{
			http_response_code(201);	
			$odgovor= "Prijava je uspela!";
			echo json_encode($odgovor);
			
			session_start();
			$_SESSION["username"] = $username;
	        exit();
	
		}
		else
		{
			http_response_code(409);	
			pripravi_odgovor_napaka("Uporabiško ime ali geslo je nepravilno!");
		}
	}
	else
	{
		http_response_code(400);	
	}
}



?>