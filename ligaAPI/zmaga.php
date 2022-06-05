<?php
$DEBUG = true;							

include("orodja.php"); 					

$zbirka = dbConnect();					

header('Content-Type: application/json');	
header('Access-Control-Allow-Origin: *');	
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');		

switch($_SERVER["REQUEST_METHOD"])		
{
	case 'PUT':
		if(!empty($_GET["klub"]))
		{
			dodaj_zmago($_GET["klub"]);		
		}
		else
		{
			http_response_code(400);				
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


function dodaj_zmago($klub)
{
	global $zbirka;
	$klub=mysqli_escape_string($zbirka, $klub);
	
	if(klub_obstaja($klub))
	{
		$poizvedba="UPDATE klub SET točke = točke + 3 WHERE klub='$klub'";
		
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
		http_response_code(409);	
		pripravi_odgovor_napaka("Klub ne obstaja!");
	}

}


?>