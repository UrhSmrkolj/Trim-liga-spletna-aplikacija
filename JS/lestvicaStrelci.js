function lestvicaStrelci(){
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
			prikaziStrelce(odgovorJSON);
		}
		if(this.readyState == 4 && this.status != 200)
		{
			document.getElementById("odgovor").innerHTML = "Ni uspelo: " + this.status;
		}
	};
	 
	httpRequest.open("GET", "ligaAPI/lestvica_strelci/"+liga, true);
	httpRequest.send();
}

function prikaziStrelce(odgovorJSON){
	var fragment = document.createDocumentFragment();		//zaradi učinkovitosti uporabimo fragment
	//console.log(odgovorJSON[0].klub);
	//za vsak element polja v JSONu ustvarimo novo vrstico v tabeli (tr)
	for (var i=0; i<odgovorJSON.length; i++) {
		var tr = document.createElement("tr");	
		
		var tdNum = document.createElement("td");
		tdNum.innerHTML = String(i+1);
		tr.appendChild(tdNum);
		//za vsako polje v vrstici ustvarimo novo celico v vrstici (td) ...
		for(var stolpec in odgovorJSON[i])		
		{
			var td = document.createElement("td");
			
			td.innerHTML=odgovorJSON[i][stolpec];
			
														
			tr.appendChild(td);						
		}
		
		
		fragment.appendChild(tr);					//vrstico tabele dodamo v fragment
	}
	document.getElementById("tabela").innerHTML="<tr><th>Mesto</th><th>Ime</th><th>Priimek</th><th>Goli</th></tr>";//pripravimo glavo tabele
	document.getElementById("tabela").appendChild(fragment);	//fragment dodamo v tabelo
}