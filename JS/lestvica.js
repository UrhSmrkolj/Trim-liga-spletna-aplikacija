function lestvica(){
	var liga = document.getElementById("obrazec")['liga'].value;
	
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			try{
				var odgovorJSON = JSON.parse(this.responseText);
			}
			catch(e){
				console.log("Napaka pri razčlenjevanju podatkov");
				return;
			}
			prikazi(odgovorJSON);
		}
		if(this.readyState == 4 && this.status != 200)
		{
			document.getElementById("odgovor").innerHTML = "Ni uspelo: " + this.status;
		}
	};
	 
	httpRequest.open("GET", "ligaAPI/lestvica_liga/"+liga, true);
	httpRequest.send();
}

function prikazi(odgovorJSON){
	var fragment = document.createDocumentFragment();		//zaradi učinkovitosti uporabimo fragment
	//console.log(odgovorJSON[0].klub);
	//za vsak element polja v JSONu ustvarimo novo vrstico v tabeli (tr)
	for (var i=0; i<odgovorJSON.length; i++) {
		var tr = document.createElement("tr");	
		
		//za vsako polje v vrstici ustvarimo novo celico v vrstici (td) ...
		for(var stolpec in odgovorJSON[i])		
		{
			var td = document.createElement("td");
			td.innerHTML=odgovorJSON[i][stolpec];	//...in vanj zapišemo prebrano vrednost
			tr.appendChild(td);						//celico dodamo v vrstico tabele
		}
		
		fragment.appendChild(tr);					//vrstico tabele dodamo v fragment
	}
	document.getElementById("tabela").innerHTML="<tr><th>Mesto</th><th>Klub</th><th>Točke</th></tr>";//pripravimo glavo tabele
	document.getElementById("tabela").appendChild(fragment);	//fragment dodamo v tabelo
}

function ponastaviLestvico()
{
	var result = confirm("Želite dokončno ponastaviti klubske lestvice?");
	if(result)
	{
		var httpRequest = new XMLHttpRequest();
		httpRequest.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				try{
					var odgovorJSON = JSON.parse(this.responseText);
				}
				catch(e){
					console.log("Napaka pri razčlenjevanju podatkov");
					return;
				}
			}
			if(this.readyState == 4 && this.status != 200)
			{
				document.getElementById("odgovor").innerHTML = "No Content " + this.status;
			}
		};

		httpRequest.open("PUT", "ligaAPI/lestvica_liga/", true);
		httpRequest.send();
		//document. location. reload();
	}
}