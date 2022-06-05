<?php
$DEBUG = true;							

include("orodja.php"); 					

$zbirka = dbConnect();					

header('Content-Type: application/json');	
header('Access-Control-Allow-Origin: *');	
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');		

switch($_SERVER["REQUEST_METHOD"])		
{
	case 'GET':
		if(!empty($_GET["ID"]))
		{
			http_response_code(400);
		}
		else
		{
			pridobi_vse_igralce();
					
		}
		break;
		
	case 'POST':
		dodaj_igralca();
		break;
		
	case 'PUT':
		if(!empty($_GET["ID"]))
		{
			posodobi_igralca($_GET["ID"]);
		}
		else
		{
			/* http_response_code(400); */
			ponastaviStatistiko();
		}
		break;
		
	case 'DELETE':
		if(!empty($_GET["ID"]))
		{
			izbrisi_igralca($_GET["ID"]);
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


function pridobi_vse_igralce()
{
	global $zbirka;
	$odgovor=array();
	
	$poizvedba="CALL vsi_igralci";	
	
	$rezultat=mysqli_query($zbirka, $poizvedba);
	
	while($vrstica=mysqli_fetch_assoc($rezultat))
	{
		$odgovor[]=$vrstica;
	}
	
	http_response_code(200);		
	echo json_encode($odgovor);
}


function dodaj_igralca()
{
	global $zbirka, $DEBUG;
	
	$podatki = json_decode(file_get_contents('php://input'), true);
	
	if(isset($podatki["ime"], $podatki["priimek"], $podatki["klub"]))
	{
		/*$ID = mysqli_escape_string($zbirka, $podatki["ID"]); //ID ne potrebujemo!!! izbrisi....*/
		$ime = mysqli_escape_string($zbirka, $podatki["ime"]);
		$priimek = mysqli_escape_string($zbirka, $podatki["priimek"]);
		$klub = mysqli_escape_string($zbirka, $podatki["klub"]);
		/* $gol = mysqli_escape_string($zbirka, $podatki["gol"]);
		$karton = mysqli_escape_string($zbirka, $podatki["karton"]); */
			
		if(klub_obstaja($klub))
		{
			$poizvedba="CALL dodaj_igralca('$ime', '$priimek', '$klub')";
			
			if(mysqli_query($zbirka, $poizvedba))
			{
				http_response_code(201);	
				$odgovor=URL_vira($ime);
				echo json_encode($odgovor);
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
	else
	{
		http_response_code(400);
		pripravi_odgovor_napaka("Tu smo!");		
	}
}

function posodobi_igralca($ID)
{
	global $zbirka, $DEBUG;
	
	$ID = mysqli_escape_string($zbirka, $ID);
	
	$podatki = json_decode(file_get_contents("php://input"),true);
		
	if(igralec_obstaja($ID))
	{
		if(isset($podatki["klub"]))
		{
			$klub = mysqli_escape_string($zbirka, $podatki["klub"]);
			
			if(klub_obstaja($klub))
			{
				$poizvedba = "UPDATE igralec SET klub='$klub' WHERE ID='$ID'";
				
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
		else
		{
			http_response_code(400);	
		}
	}
	else
	{
		http_response_code(404);	
	}
}	
	
function izbrisi_igralca($ID)
{	
	global $zbirka, $DEBUG;
	$ID=mysqli_escape_string($zbirka, $ID);

	if(igralec_obstaja($ID))
	{
		$poizvedba="DELETE FROM igralec WHERE ID='$ID'";
		
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
		http_response_code(404);
		pripravi_odgovor_napaka("Tukaj se zatakne");
	}
}


function ponastaviStatistiko()
{
	global $zbirka, $DEBUG;

	$poizvedba="UPDATE igralec SET gol=0, karton = 0;";
	
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

?>