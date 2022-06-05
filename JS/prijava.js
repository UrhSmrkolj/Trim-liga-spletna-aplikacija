function prijava(){
	
	var username = document.getElementById("obrazec")['username'].value;
	var geslo =  document.getElementById("obrazec")['geslo'].value;
	//console.log(username);
		
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
			if(this.status == 409){
				alert("Geslo/up. ime je napačno");
			}
		}	
	};
	
	const data = '{"username": "' + username + '",' + '"geslo": "' + geslo + '"}';
	httpRequest.open("PUT", "/main/ligaAPI/prijava.php", true);
	httpRequest.send(data);
	document. location. reload();
	
}