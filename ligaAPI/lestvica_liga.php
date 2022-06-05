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
	case 'PUT':
		if(!empty($_GET["liga"]))
		{
			http_response_code(400);
		}
		else
		{
			ponastaviLestvico();
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
		$poizvedba="SELECT (@row_number:=@row_number + 1) AS num, klub, točke FROM klub, (SELECT @row_number:=0) AS t WHERE liga='$liga' GROUP BY klub ORDER BY MAX(točke) DESC LIMIT 10;";
		
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

function ponastaviLestvico()
{
	global $zbirka, $DEBUG;

	$poizvedba="UPDATE klub SET točke=0;";
	
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