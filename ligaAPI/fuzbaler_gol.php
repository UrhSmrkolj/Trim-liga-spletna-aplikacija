<?php
$DEBUG = true;							

include("orodja.php"); 					

$zbirka = dbConnect();					

header('Content-Type: application/json');	
header('Access-Control-Allow-Origin: *');	
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, UPDATE');		

switch($_SERVER["REQUEST_METHOD"])		
{
	case 'PUT':
		if(!empty($_GET["ID"]))
		{
			dodaj_gol($_GET["ID"]);		
		}
		else
		{
			http_response_code(400);
			pripravi_odgovor_napaka("napaka je tukaj 1");
			
		}
		break;		
		
	case 'OPTIONS':						
		http_response_code(204);
		break;
		
	default:
		http_response_code(405);		
		break;
}

mysqli_close($zbirka);					


function dodaj_gol($ID)
{
	global $zbirka;
	$ID=mysqli_escape_string($zbirka, $ID);
	
	$podatki = json_decode(file_get_contents("php://input"),true);
	
	if(igralec_obstaja($ID))
	{
		if(isset($podatki["gol"]))
		{
			$gol = mysqli_escape_string($zbirka, $podatki["gol"]);
			$poizvedba = "UPDATE igralec SET gol = gol + '$gol' WHERE ID='$ID'";
			
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(204);	
			}
			else
			{
				http_response_code(500);	
				
				if($DEBUG)	
				{
					pripravi_odgovor_napaka(mysqli_error($zbirka));
				}
			}
			
		}
		else
		{
			http_response_code(400);
			pripravi_odgovor_napaka("napaka je tukaj 2");			
		}
	}
	else 
	{
		http_response_code(409);	
		pripravi_odgovor_napaka("Igralec ne obstaja!");
	}

}


?>