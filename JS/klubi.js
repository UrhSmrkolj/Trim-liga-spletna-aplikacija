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
			//POČISTI, ČE JE KAJ NOTRI
			document.getElementById("klubi").innerHTML = "";
			//DODA NOVE OPCIJE
			populateSelect(odgovorJSON)
		}
		if(this.readyState == 4 && this.status != 200)
		{
			document.getElementById("odgovor").innerHTML = "Ni uspelo: " + this.status;
		}
	};
	 
	httpRequest.open("GET", "ligaAPI/klubi/"+liga, true);
	httpRequest.send();
}


function populateSelect(array) {
	// THE JSON ARRAY --> odgovorJSON

	var ele = document.getElementById('klubi');
	for (var i = 0; i < array.length; i++) {
		// POPULATE SELECT ELEMENT WITH JSON.
		ele.innerHTML = ele.innerHTML +
			'<option value="' + array[i]['klub'] + '">' + array[i]['klub'] + '</option>';
	}
}

function show(ele) {
	// GET THE SELECTED VALUE FROM <select> ELEMENT AND SHOW IT.
	var msg = document.getElementById('msg');
	msg.innerHTML = 'Izbran klub: <b>' + ele.options[ele.selectedIndex].text + '</b> </br>' +
		'klub: <b>' + ele.value + '</b>';
}

