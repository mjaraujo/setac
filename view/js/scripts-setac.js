window.addEventListener('scroll', function resizeHeaderOnScroll() {
	const distanceY = window.pageYOffset || document.documentElement.scrollTop;
	const tamanhoTela = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	shrinkOn = 80;
	navbar = document.getElementById('nav-fixa');
	logo = document.getElementById("logo-setac");

	if(tamanhoTela >= 768){
		if (distanceY > shrinkOn){
			navbar.style.padding = "0";
			navbar.style.backgroundColor = "rgba(254,204,0,1)";
			logo.style.color = "rgba(255,255,255,1)";
		}else{
			navbar.style.padding = "20px 0";
			navbar.style.backgroundColor = "rgba(254,155,0,0)";
			logo.style.color = "rgba(254,204,0,1)";
		}
	}
});


function contagemRegressiva() {
	var YY = 2017;
	var MM = 10;
	var DD = 08;
	var HH = 08;
	var MI = 00;
	var SS = 00; 

	var hoje = new Date();  
	var futuro = new Date(YY,MM-1,DD,HH,MI,SS); 

	var ss = parseInt((futuro - hoje) / 1000);  
	var mm = parseInt(ss / 60);  
	var hh = parseInt(mm / 60);  
	var dd = parseInt(hh / 24);   
	ss = ss - (mm * 60);  
	mm = mm - (hh * 60);  
	hh = hh - (dd * 24);   

	document.getElementById('cont-dias').innerHTML = dd;
	document.getElementById('cont-horas').innerHTML = hh;  
	document.getElementById('cont-minutos').innerHTML = mm;  
	document.getElementById('cont-segundos').innerHTML = ss;  

	setTimeout(contagemRegressiva,1000);
}