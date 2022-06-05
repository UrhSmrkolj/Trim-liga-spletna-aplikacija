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
			lestvica_strelci($_GET["liga"]);
		}
		else
		{
			http_response_code(400);	
		}
		break;
	default:
		http_response_code(405);	
		break;
}

function lestvica_strelci($liga)
{
	global $zbirka;
	$tezavnost=mysqli_escape_string($zbirka, $liga);
	$odgovor=array();

	if(liga_obstaja($liga))
	{
		$poizvedba="select ime,priimek,gol from igralec where klub in ( select klub from klub where liga = '$liga' ) group by ID order by max(gol) desc limit 10";

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