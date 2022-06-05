const formToJSON = elements => [].reduce.call(elements, (data, element) => 
{
	if(element.name!="")
	{
		data[element.name] = element.value;
	}
  return data;
}, {});
 
function dodajIgralca()
{
	const data = formToJSON(document.getElementById("obrazec").elements);	// vsebino obrazca pretvorimo v objekt
	var JSONdata = JSON.stringify(data, null, "  ");						// objekt pretvorimo v znakovni niz v formatu JSON
	
	var xmlhttp = new XMLHttpRequest();										// ustvarimo HTTP zahtevo
	 
	xmlhttp.onreadystatechange = function()									// določimo odziv v primeru različnih razpletov komunikacije
	{
		if (this.readyState == 4 && this.status == 201)						// zahteva je bila uspešno poslana, prišel je odgovor 201
		{
			document.getElementById("odgovor").innerHTML="Dodajanje uspelo!";
		}
		if(this.readyState == 4 && this.status != 201)						// zahteva je bila uspešno poslana, prišel je odgovor, ki ni 201
		{
			document.getElementById("odgovor").innerHTML="Dodajanje ni uspelo: "+this.status;
		}
	};
	 
	xmlhttp.open("POST", "/ligaAPI/igralci", true);							// določimo metodo in URL zahteve, izberemo asinhrono zahtevo (true)
	xmlhttp.send(JSONdata);													// priložimo podatke in izvedemo zahtevo
}