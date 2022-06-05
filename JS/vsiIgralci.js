function vsiIgralci(){
		
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
	};
	 
	httpRequest.open("GET", "/main/ligaAPI/igralci.php", true);
	httpRequest.send();
}

function prikazi(odgovorJSON){
	var fragment = document.createDocumentFragment();		//zaradi učinkovitosti uporabimo fragment
	
	//console.log(odgovorJSON)
	//za vsak element polja v JSONu ustvarimo novo vrstico v tabeli (tr)
	for (var i=0; i<odgovorJSON.length; i++) {
		var tr = document.createElement("tr");
		//tr.setAttribute("id",i);
		tr.id = i;
		//tr.setAttribute("class", "vrstica");
		
		//za vsak stolpec v vrstici ustvarimo novo celico (td) ...
		for(var stolpec in odgovorJSON[i]){
			var td = document.createElement("td");
			td.setAttribute("class", "vrstica");
			td.innerHTML=odgovorJSON[i][stolpec];		//...in vanjo zapišemo prebrano vrednost
			tr.appendChild(td);						//celico dodamo v vrstico tabele
		}
		var tdButton = document.createElement("td");
		tdButton.innerHTML = "<Button onClick='izbrisiIgralca()' class='button button3'>Izbriši igralca</Button>   <Button onClick='posodobiIgralca()' class='button button2'>Posodobi klub</Button>   <input type='text' maxlength='2' size='9' placeholder='ŠT. GOL' onkeydown='dodajGol(this)'>   <input type='text' maxlength='2' size='9' placeholder='ŠT. KARTON' onkeydown='dodajKarton(this)'>";
		tr.appendChild(tdButton);
		fragment.appendChild(tr);					//vrstico tabele dodamo v fragment
	}
	document.getElementById("tabela").appendChild(fragment);	//fragment dodamo v tabelo
}

function filterFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("tabela");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}

function izbrisiIgralca(){
	var result = confirm("Želite dokončno izbrisati igralca?");
	if(result){
		var rowId = event.target.parentNode.parentNode.id;
		//console.log(rowId);
		
		var podatki = document.getElementById(rowId).querySelectorAll(".vrstica");
		var idIgralca = podatki[5];
		//console.log("Id igralca je "+idIgralca.innerHTML);
		
		var ID = String(idIgralca.innerHTML);
		
		var httpRequest = new XMLHttpRequest();
		httpRequest.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{
				try{
					//var odgovorJSON = JSON.parse(this.responseText);
					//console.log("OK");
				}
				catch(e){
					console.log("Napaka pri razčlenjevanju podatkov");
					return;
				}
			}
			if(this.readyState == 4 && this.status != 200)
			{
				//document.getElementById("odgovor").innerHTML = "No Content " + this.status;
				console.log("OK2");
			}
		};
		 
		httpRequest.open("DELETE", "ligaAPI/igralci/"+ID, true);
		httpRequest.send();
		document. location. reload();
	}

}

function posodobiIgralca(){

	var rowId = event.target.parentNode.parentNode.id;
	//console.log(rowId);
	
	var podatki = document.getElementById(rowId).querySelectorAll(".vrstica");
	var idIgralca = podatki[5];
	var klubIgralca = podatki[2];
	//console.log("Id igralca je "+idIgralca.innerHTML);
	
	var ID = String(idIgralca.innerHTML);
	var klub = String(klubIgralca.innerHTML);
	
    let novKlub = prompt("Prosim napiši igralčev klub.", klub);
    if (novKlub != null) {
		//console.log(novKlub);
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
				document.getElementById("odgovor").innerHTML = "Status: " + this.status;
			}
		};
		
		const data = '{"klub": "'+ novKlub + '"}'; 
		httpRequest.open("PUT", "ligaAPI/igralci/"+ID, true);
		httpRequest.send(data);
		}
}

function dodajIgralca(){
	var klub = document.getElementById("obrazec")['klubi'].value;
	var ime =  document.getElementById("obrazec")['fname'].value;
	var priimek = document.getElementById("obrazec")['lname'].value;
	const data = '{"ime": "' + ime + '",' + '"priimek": "' + priimek + '",' + '"klub": "' + klub + '"}';
		
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
	
	httpRequest.open("POST", "ligaAPI/igralci", true);
	httpRequest.send(data);
	
}

function dodajGol(ele) {
    if(event.key === 'Enter') {
		if (isNaN(ele.value)){
			alert("Vnos ni število!")
		}
		else{
			var goli = Number(ele.value);

			var result = confirm("Želite dodati zadetke?");
			if(result){
				var rowId = event.target.parentNode.parentNode.id;
				
				var podatki = document.getElementById(rowId).querySelectorAll(".vrstica");
				var idIgralca = podatki[5];
				
				var ID = String(idIgralca.innerHTML);
				
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
				
				const data = '{"gol": '+ goli + '}';
				httpRequest.open("PUT", "ligaAPI/fuzbaler_gol/"+ID, true);
				httpRequest.send(data);
				//document. location. reload();
			}
			
		}
               
    }
}

function dodajKarton(ele) {
    if(event.key === 'Enter') {
		if (isNaN(ele.value)){
			alert("Vnos ni število!")
		}
		else{
			var kartoni = Number(ele.value);

			var result = confirm("Želite dodati kartone?");
			if(result){
				var rowId = event.target.parentNode.parentNode.id;
				
				var podatki = document.getElementById(rowId).querySelectorAll(".vrstica");
				var idIgralca = podatki[5];
				
				var ID = String(idIgralca.innerHTML);
				
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
				
				const data = '{"karton": '+ kartoni + '}';
				httpRequest.open("PUT", "ligaAPI/fuzbaler_karton/"+ID, true);
				httpRequest.send(data);
				//document. location. reload();
			}
			
		}
               
    }
}

function ponastaviStatistiko()
{
	var result = confirm("Res želite ponastaviti statistiko igralcev?");
	if(result){
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

		httpRequest.open("PUT", "ligaAPI/igralci/", true);
		httpRequest.send();
		//document. location. reload();
	}
}