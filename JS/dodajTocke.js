function zmaga(){
	var klubi = document.getElementById("obrazecKlubi")['klubi'].value;
	
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
	 
	httpRequest.open("PUT", "ligaAPI/zmaga/"+klubi, true);
	httpRequest.send();
}

function remi(){
	var klubi = document.getElementById("obrazecKlubi")['klubi'].value;
	
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
	 
	httpRequest.open("PUT", "ligaAPI/remi/"+klubi, true);
	httpRequest.send();
}


