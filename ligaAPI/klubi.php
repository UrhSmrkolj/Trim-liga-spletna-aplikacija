<?php
$DEBUG = true;							

include("orodja.php"); 					

$zbirka = dbConnect();					

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');	

switch($_SERVER["REQUEST_METHOD"])			
{
	case 'GET':
		if(!empty($_GET["liga"]))
		{
			lestvica_liga($_GET["liga"]);
		}
		else
		{
			http_response_code(400);
			//pripravi_odgovor_napaka("1");
		}
		break;
	default:
		http_response_code(405);	
		break;
}

function lestvica_liga($liga)
{
	global $zbirka;
	$liga=mysqli_escape_string($zbirka, $liga);
	$odgovor=array();
	
	if(liga_obstaja($liga))
	{
		$poizvedba="SELECT klub FROM klub WHERE liga='$liga';";
		
		$result=mysqli_query($zbirka, $poizvedba);

		while($vrstica = mysqli_fetch_assoc($result))
		{
			$odgovor[]=$vrstica;
		}

		http_response_code(200);		
		echo json_encode($odgovor);
	}
	else
	{
		http_response_code(400);
	}
		
}



?>