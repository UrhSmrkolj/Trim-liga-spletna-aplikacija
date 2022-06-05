function podatkiIgralca(){
	var vzdevek=document.getElementById("obrazec")['vzdevek'].value;
	
	document.getElementById('posodobitev').style.display="none";
	document.getElementById('odgovor').innerHTML="";
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function()
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
			//prikazi(odgovorJSON);
			prikaziZaUrejanje(odgovorJSON);
		}
		if(this.readyState == 4 && this.status != 200)
		{
			document.getElementById("odgovor").innerHTML="Ni uspelo: "+this.status;
		}
	};

	xmlhttp.open("GET", "/ligaAPI/igralci/"+vzdevek, true);
	xmlhttp.send();
}

function prikazi(odgovorJSON)
{
	var fragment = document.createDocumentFragment();		//zaradi učinkovitosti uporabimo fragment
	
	for(var stolpec in odgovorJSON)		
	{
		var div = document.createElement("div");			// Za vsak stolpec ustvarimo lasten razdelek 'div'
		div.innerHTML = stolpec + ": " + odgovorJSON[stolpec];	//...in vanj zapišemo vrednost stolpca
		fragment.appendChild(div);							// Razdelek dodamo v fragment.
	}
	document.getElementById("odgovor").innerHTML="";			//pobrišemo morebitno obstoječo vsebino
	document.getElementById("odgovor").appendChild(fragment);	//fragment dodamo v pripravljen element
}

function prikaziZaUrejanje(odgovorJSON)
{
	var obrazec = document.getElementById('posodobitev');
	obrazec.style.display="block";
	
	obrazec.ime.value = odgovorJSON['ime'];
	obrazec.priimek.value = odgovorJSON['priimek'];
	obrazec.email.value = odgovorJSON['email'];
}

const formToJSON = elements => [].reduce.call(elements, (data, element) => 
{
	if(element.name!="")
	{
		data[element.name] = element.value;
	}
  return data;
}, {});

function posodobiPodatke()
{
	const data = formToJSON(document.getElementById("posodobitev").elements);	// vsebino obrazca pretvorimo v objekt
	var JSONdata = JSON.stringify(data, null, "  ");						// objekt pretvorimo v znakovni niz v formatu JSON
	
	var xmlhttp = new XMLHttpRequest();										// ustvarimo HTTP zahtevo
	 
	xmlhttp.onreadystatechange = function()									// določimo odziv v primeru različnih razpletov komunikacije
	{
		if (this.readyState == 4 && this.status == 204)						// zahteva je bila uspešno poslana, prišel je odgovor 204
		{
			document.getElementById("odgovor").innerHTML="Posodobitev uspela!";
		}
		if(this.readyState == 4 && this.status != 204)						// zahteva je bila uspešno poslana, prišel je odgovor, ki ni 204
		{
			document.getElementById("odgovor").innerHTML="Posodobitev ni uspela: "+this.status;
		}
	};
	
	var vzdevek = document.getElementById('obrazec').vzdevek.value;
	
	xmlhttp.open("PUT", "/ligaAPI/igralci/"+vzdevek, true);							// določimo metodo in URL zahteve, izberemo asinhrono zahtevo (true)
	xmlhttp.send(JSONdata);
}



