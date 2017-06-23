/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Função JQuery chamada quando a página estiver carregada por completo.
 * @data: 12/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
$(document).ready(function(){
    //Captura do arquivo PHP chamado
    var windowLoc = $(location).attr('pathname');
    windowLoc = windowLoc.split('/');
    windowLoc = windowLoc[windowLoc.length-1];

    //Escolha de ações para um determinado arquivo
    switch(windowLoc){
        case "administracao.php":
        case "cadastro.php":
          inscricao.carregarEstados();
          inscricao.preencherDadosFormulario();
          inscricao.watchCep();
          inscricao.watchCidade();
          utils.mascaraRG();
          break;
        case "alert.php":
          //code here
          break;
    }
});

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Objeto literal de funções úteis para qualquer view.
 * @data: 21/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
utils = {
    mascaraRG: function(){
        if(document.querySelector("input[id$='_rg']")){
            document.querySelector("input[id$='_rg']").addEventListener("blur", function(){
                var rg, element;
                element = $(this);
                element.unmask();
                rg = element.val().replace(/\D/g, '');
                if(rg.length < 9) {
                    element.mask("9.999.999-*");
                }else{
                    element.mask("99.999.999-*");
                }
            });
        }
    },
    mascaraCPF: function(){
        
    },
    mascaraCEP: function(){
        //esta na função watchCep do objeto literal inscricao.
    },
    validarEmail: function(){
        
    }
};

inscricao = {
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Evento de KeyUp para a digitação do CEP no cadastro. Quando nove digitos forem inseridos buscar-se-a os dados de endereço.
     * @data: 08/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    watchCep: function(){
        if(document.querySelector("input[id$='_cep']")){
            //document.getElementById("log_cep").addEventListener("keyup", function(){
            document.querySelector("input[id$='_cep']").addEventListener("keyup", function(){
                var elForm = '#' + this.form.id;
                var cep = document.getElementById("log_cep").value;
                //console.log(cep);
                if(cep.length > 8){
                    var req = new XMLHttpRequest();
                    req.onreadystatechange = function(){
                        if(req.readyState == 4 && req.status == 200){
                            if(req.responseText!='false' && req.responseText!=""){
                                var myObj = JSON.parse(req.responseText);
                                for (var key in myObj) {
                                    if(document.getElementById(key)){
                                        document.getElementById(key).value = myObj[key];
                                    }
                                }

                                var emFoco = false;
                                var vazios = document.querySelectorAll(elForm + " input");
                                var len = vazios.length;
                                if(len>0){
                                    for(var i=0; i<len; i++){
                                        if(vazios[i].value.trim()=='' && vazios[i].type!='hidden'){
                                            vazios[i].focus();
                                            emFoco = true;
                                            break;
                                        }
                                    }
                                }
                                if(!emFoco){
                                    document.querySelector("button[type='submit']").focus();
                                }
                            }else{//dados de endereço não achados - habilitar campos de logradouro
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
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Evento de Blur (saída de campo) para a digitação do nome da cidade. Quando deixar o campo buscar-se-a o estado.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    watchCidade: function(){
        if(document.querySelector("#cid_nome")){
            document.querySelector("#cid_nome").addEventListener("blur", function(){
                var cidNome = document.getElementById("cid_nome").value;
                if(cidNome.length > 0){
                    var req = new XMLHttpRequest();
                    req.onreadystatechange = function(){
                        if(req.readyState == 4 && req.status == 200){
                            if(req.responseText!='false' && req.responseText!=""){
                                var myObj = JSON.parse(req.responseText);
                                for (var key in myObj) {
                                    if(document.getElementById(key)){
                                        document.getElementById(key).value = myObj[key];
                                    }
                                }
                            }
                        }
                    }
                    req.open("GET", "../ctrl/cadastro.php?processo=cidade&cidade="+cidNome, true);
                    req.send(null);
                }
            });
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Evento de Blur (saída de campo) para a digitação do nome da cidade. Quando deixar o campo buscar-se-a o estado.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    carregarEstados: function(){
        var selEstados = document.querySelector('#est_id');
        if(selEstados){
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(req.readyState == 4 && req.status == 200){
                    if(req.responseText!='false' && req.responseText!=""){
                        let option = document.createElement("option");
                        let txtOption = document.createTextNode("Selecione...");
                        option.appendChild(txtOption);
                        option.setAttribute ("disabled", true);
                        option.setAttribute ("selected", true);
                        selEstados.appendChild(option);

                        var objEstados = JSON.parse(req.responseText);
                        for(var est of objEstados){
                            let option = document.createElement("option");
                            let txtOption = document.createTextNode(est.est_nome);
                            option.appendChild(txtOption);
                            option.setAttribute ("value", est.est_id);
                            selEstados.appendChild(option);
                        }
                        //document.querySelector('#est_id').innerHTML = req.responseText;
                    }
                }
            }
            req.open("GET", "../ctrl/cadastro.php?processo=estados", true);
            req.send(null);
        }
    },
    preencherDadosFormulario: function(){
        if(document.querySelector('#dados')){
            var objDados = null;
            var jsonDados = $('#dados').val();
            if(jsonDados.length>0){
                //para armazenar os dados do formulario precisei tirar as aspas duplas, preciso recoloca-las
                jsonDados = jsonDados.split(new RegExp('aspas', 'i')).join('\"');
                objDados = JSON.parse(jsonDados);
                for (var key in objDados) {
                    if(document.getElementById(key)){
                        //$(document.getElementById(key)).val(objDados[key]);
                        var campo = document.getElementById(key);
                        if(campo.tagName == "SELECT"){
                            var opt = document.querySelector("#"+key+" > [value=" + objDados[key] + "]");
                            //console.log(document.querySelectorAll("#"+key+" option").length);
                            console.dir(document.getElementById(key).childNodes.length);
                            if(opt){
                                opt.setAttribute("selected", true);
                            }
                        }else{
                            campo.value = objDados[key];
                        }
                    }
                }
            }
        }
    }
};

window.addEventListener('scroll', function resizeHeaderOnScroll() {
    const distanceY = window.pageYOffset || document.documentElement.scrollTop;
    const tamanhoTela = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    shrinkOn = 80;
    navbar = document.getElementById('nav-fixa');
    logo = document.getElementById("logo-setac");

    if(navbar){
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