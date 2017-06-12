inscricao = {
    carregarEstados: function(){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(req.readyState == 4 && req.status == 200){
                if(req.responseText!='false' && req.responseText!=""){
                    document.querySelector('#est_id').innerHTML = req.responseText;
                }
            }
        }
        req.open("GET", "../ctrl/cadastro.php?processo=estados", true);
        req.send(null);
    }
};

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

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Evento de KeyUp para a digitação do CEP no cadastro. Quando nove digitos forem inseridos buscar-se-a os dados de endereço.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
document.getElementById("log_cep").addEventListener("keyup", function(){
    var cep = document.getElementById("log_cep").value;
    console.log(cep);
    if(cep.length > 8){
        var req = new XMLHttpRequest();
        req.onreadystatechange = function(){
            if(req.readyState == 4 && req.status == 200){
                if(req.responseText!='false' && req.responseText!=""){
                    alert(req.responseText);
                    var myObj = JSON.parse(req.responseText);
                    for (var key in myObj) {
                        if(document.getElementById(key)){
                            document.getElementById(key).value = myObj[key];
                        }
                        console.log(key + ' is ' + myObj[key] + ' - ' + typeof(key));
                    }

                    var vazios = document.querySelectorAll("input");
                    var len = vazios.length;
                    if(len>0){
                        //vazios[0].focus();
                        for (var i=0; i<len; i++){
                            if(vazios[i].value==""){
                                vazios[i].focus();
                                break;
                            }
                        }
                    }
                }else{//habilitar campos de logradouro
                    document.getElementById('log_id').value = '';
                    var desabilitados = document.querySelectorAll("input[readonly]");
                    var len = desabilitados.length;
                    for (var i=0; i<len; i++){
                        desabilitados[i].removeAttribute("readonly");
                    }
                    desabilitados[0].focus();
                }
            }
        }
        req.open("GET", "../ctrl/cadastro.php?processo=cep&cep="+cep, true);
        req.send(null);
    }else{
        if(cep.length==5){
            document.getElementById("log_cep").value = cep + '-';
        }
    }
});

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Evento de KeyUp para a digitação do CEP no cadastro. Quando nove digitos forem inseridos buscar-se-a os dados de endereço.
 * @data: 08/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
/*document.getElementById("cadCliente").addEventListener("load", function(){
    var dados = document.getElementById("dados").value;
    alert(dados);
});*/

//FUNÇÃO IMEDIATA
(function(){
    inscricao.carregarEstados();
})();