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
            inscricao.validarSelecaoEstado();
            inscricao.watchCep();
            inscricao.watchCidade();
            administracao.paginarParticipantes(1);
            paginacao.eventoSelectNrRegistrosPorPagina(administracao.paginarParticipantes);
            administracao.eventosProcurarParticipantes();
            recurso.paginarRecursos(1);
            break;
        case "login.php":
            $('#modalLogin').modal('show');
            break;
    }
    $('input:text').setMask();
});

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Objeto literal de funções úteis para qualquer view.
 * @data: 21/06/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
utils = {
    validarEmail: function(){
        
    },
    dialogoConfirmacaoExcluir: function(evento){
        var gatilhos = document.querySelectorAll("a, button");
        for(var gatilho of gatilhos){
            if(gatilho.innerHTML.toLowerCase()=="excluir"){
                gatilho.addEventListener("click", function(evento){
                    if(!confirm("Confirma a exclusão do registro?")){
                        evento.preventDefault();
                        evento.returnValue = false;
                    }
                });
            }
        }
    },
    inserirElementoDepois: function(referenceNode, newNode) {
        var elExiste = document.querySelector(newNode.tagName+"[name="+newNode.getAttribute("name")+"]");
        if(elExiste==null){
            referenceNode.parentNode.insertBefore(newNode, referenceNode.nextSibling);
            //remove o elemento após 3 segundos
            setTimeout(function(){
                newNode.parentNode.removeChild(newNode);
            }, 3000);
        }
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
                                        if(key=="cid_cep_unico"){
                                            if(myObj[key]=="S"){
                                                document.querySelector("#cid_cep_unico").setAttribute("checked", true);
                                            }else{
                                                document.querySelector("#cid_cep_unico").removeAttribute("checked");
                                            }
                                        }else{
                                            document.getElementById(key).value = myObj[key];
                                        }
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
                                var desabilitados = document.querySelectorAll("*[readonly]");
                                var len = desabilitados.length;
                                for (var i=0; i<len; i++){
                                    desabilitados[i].removeAttribute("readonly");
                                }
                                desabilitados[0].focus();
                                
                                cep = cep.replace(".", "");
                                cep = cep.replace("-", "");
                                inscricao.buscarDadosPeloCepNaWeb(cep);
                            }
                        }
                    }
                    req.open("GET", "../ctrl/cadastro.php?processo=cep&cep="+cep, true);
                    req.send(null);
                /*}else{
                    if(cep.length==5){
                        document.getElementById("log_cep").value = cep + '-';
                    }*/
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
                        option.setAttribute("disabled", "");
                        option.setAttribute("selected", "");
                        selEstados.appendChild(option);

                        var objEstados = JSON.parse(req.responseText);
                        for(var est of objEstados){
                            let option = document.createElement("option");
                            let txtOption = document.createTextNode(est.est_nome);
                            option.appendChild(txtOption);
                            option.setAttribute ("value", est.est_id);
                            selEstados.appendChild(option);
                        }
                    }
                }
            }
            //Ativada a sinccronia, senão as opções não existem para outros métodos AJAX.
            req.open("GET", "../ctrl/cadastro.php?processo=estados", false);
            req.send(null);
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável por pegar um JSON e usá-lo para preencher a tela de inscrição.
     *             Usado quando dá erro na inscrição e na edição.
     * @data: ~14/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
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
                        if(key=="cid_cep_unico"){
                            if(objDados[key]=="S"){
                                document.querySelector("#cid_cep_unico").setAttribute("checked", true);
                            }
                        }else{
                            $(document.getElementById(key)).val(objDados[key]);
                        }
                    }
                }
            }
            this.definirProcessoDaInscricao();
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Método responsável alterar o valor do campo hidden processo para 'novo' ou 'editar'.
     *             Usado para a view inc_form_inscricao.php.
     * @data: 23/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    definirProcessoDaInscricao: function(){
        var parId = document.querySelector("#par_id[type=hidden]");
        if(parId){
            parId = parId.value;
            document.querySelector("#processo").value = (parId > 0 ? "editar" : "novo");
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Função para verificar a seleção de um estado, pois o required do select de estados não funciona.
     * @data: 23/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    validarSelecaoEstado: function(){
        if(document.querySelector("#cadCliente")){
            document.querySelector("#cadCliente").addEventListener("submit", function(evento){
                var estIdSelected = document.getElementById("est_id").selectedIndex;
                if(estIdSelected==0){
                    evento.preventDefault();
                    return false;
                }
            }, false);
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Função para buscar os dados de endereço quando não estão presentes no BD.
     * @data: 10/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    buscarDadosPeloCepNaWeb: function(cep){
        var req = new XMLHttpRequest();
        var urlcep = 'https://viacep.com.br/ws/' + cep + '/json/';
        req.onreadystatechange = function(){
            if(req.readyState==4 && req.status==200){
                var endereco = JSON.parse(req.responseText);
                if(!endereco.erro){//Existe dados
                    let logradouro = endereco.logradouro;
                    let tipo_logradouro = logradouro.substring(0, logradouro.indexOf(" ")).trim();
                    logradouro = logradouro.replace(tipo_logradouro, "").trim();
                    let bairro = endereco.bairro;
                    let cidade = endereco.localidade;
                    let estado = endereco.uf;
                    let formulario = document.querySelector("#cadCliente");

                    if(logradouro=="" && cidade!="" && estado!=""){
                        formulario.querySelector("#cid_cep_unico").setAttribute("checked", true);
                        formulario.querySelector("#cid_cep_unico").setAttribute("readonly", true);
                    }else{
                        formulario.querySelector("#cid_cep_unico").removeAttribute("checked");
                        formulario.querySelector("#cid_cep_unico").setAttribute("readonly", true);
                    }
                    formulario.querySelector("#log_tipo").value = tipo_logradouro;
                    formulario.querySelector("#log_nome").value = logradouro;
                    formulario.querySelector("#log_bairro").value = bairro;
                    formulario.querySelector("#cid_nome").value = cidade;
                    formulario.querySelector("#est_id").value = estado;
                }
            }
        };
        req.open("GET", urlcep, false);
        req.send(null);
    }
    
};

administracao = {
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Evento de Blur (saída de campo) para a digitação do nome da cidade. Quando deixar o campo buscar-se-a o estado.
     * @data: 22/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    ativarUsuario: function(){
        var tdSituacao = "";
        var lkSituacao = "";
        var params = "";
        var tRows = document.querySelectorAll("table tr");
        for(var row of tRows){
            tdSituacao = row.querySelector(".status");
            lkSituacao = row.querySelector(".chstatus");
            if(tdSituacao!=null && lkSituacao!=null){
                lkSituacao.addEventListener("click", function(evento){
                    var meuLink = this.parentNode.parentNode;
                    tdSituacao = meuLink.querySelector(".status");
                    lkSituacao = meuLink.querySelector(".chstatus");
                    params = lkSituacao.href.substring(lkSituacao.href.indexOf("?"), lkSituacao.href.length);
                    evento.preventDefault();
                    evento.returnValue = false;
                    //AJAX
                    var req = new XMLHttpRequest();
                    req.onreadystatechange = function(){
                        if(req.readyState == 4 && req.status == 200){
                            if(req.responseText!='false' && req.responseText!=""){
                                tdSituacao.innerHTML = tdSituacao.innerText.toLowerCase()=="ativo" ? "Inativo" : "Ativo";
                                lkSituacao.innerHTML = lkSituacao.innerText.toLowerCase()=="ativar" ? "Inativar" : "Ativar";
                            }
                        }
                    }
                    req.open("GET", "../ctrl/administracao.php"+params, true);
                    req.send(null);
                });
            }
        }
    },
    preencherCorpoTabelaParticipantes: function(jsonDados, pag){
        var quant = document.getElementById("selNrRegistrosPorPagina").value;
        var nrRegistros = 0;
        objDados = JSON.parse(jsonDados);
        var tBody = document.querySelector("table[id='tabParticipantes'] tbody");
        paginacao.limparConteudoTabela("tabParticipantes");
        //Criar as novas linhas
        for(var obj of objDados){
            nrRegistros = obj.quantidade;
            var cidade = (obj.cid_nome==null ? 'Sem endereço' : obj.cid_nome + " (" + obj.est_id + ")");
            var situacao = (obj.usu_status==null ? 'Sem acesso' : obj.usu_status + (obj.usu_status=='A' ? "tivo" : "nativo"));

            let tRow = document.createElement("tr");
            let tData = document.createElement("td");
            let txt = document.createTextNode(obj.par_nome);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            txt = document.createTextNode(obj.par_email);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            txt = document.createTextNode(obj.par_instituicao);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            txt = document.createTextNode(cidade);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            let data = obj.par_timestamp.split("-");
            data = (data[2].split(" ")[0]+"/"+data[1]+"/"+data[0]).trim();
            tData = document.createElement("td");
            txt = document.createTextNode(data);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            tData.className = "status";
            txt = document.createTextNode(situacao);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            let lkeditar = document.createElement("a");
            lkeditar.href = "administracao.php?processo=edusu&usu=" + obj.par_id;
            txt = document.createTextNode("Editar");
            lkeditar.appendChild(txt);
            let lkexcluir = document.createElement("a");
            lkexcluir.href = "administracao.php?processo=exusu&usu=" + obj.par_id;
            txt = document.createTextNode("Excluir");
            lkexcluir.appendChild(txt);
            let lksituacao = document.createElement("a");
            lksituacao.href = "administracao.php?processo=siusu&usu=" + obj.par_id;
            lksituacao.className = "chstatus";
            txt = document.createTextNode(obj.usu_status=='A' ? "Inativar" : "Ativar");
            lksituacao.appendChild(txt);

            tData.appendChild(lkeditar);
            tData.appendChild(lkexcluir);
            tData.appendChild(lksituacao);
            tRow.appendChild(tData);

            tBody.appendChild(tRow);            
        }
        paginacao.limparPaginacao("paginacao", "span");
        paginacao.criarPaginacao("paginacao", pag, nrRegistros, quant, administracao.paginarParticipantes);
        utils.dialogoConfirmacaoExcluir();
        administracao.ativarUsuario();
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Responsável por executar a chamada ao método no controller, 
     *             popular a tabela de acordo com o select de quantidade de resultados na view participantes.php.
     * @data: 29/06/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    paginarParticipantes: function(pag){
        if(document.querySelector("table[id='tabParticipantes']")){
            var quant = document.getElementById("selNrRegistrosPorPagina").value;
            var nrRegistros = 0;
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(req.readyState == 4 && req.status == 200){
                    if(req.responseText!='false' && req.responseText!=""){
                        //para armazenar os dados do formulario precisei tirar as aspas duplas, preciso recoloca-las
                        objDados = req.responseText.split(new RegExp('aspas', 'i')).join('\"');
                        administracao.preencherCorpoTabelaParticipantes(objDados, pag);
                    }
                }
            }
            //Ativada a sinccronia, senão as opções não existem para outros métodos AJAX.
            req.open("GET", "../ctrl/administracao.php?processo=ptp&pagina="+pag+"&quantidade="+quant, false);
            req.send(null);
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Responsável por desativar o submit do formulário e executar a procura usando AJAX 
     *             Populará a tabela com os valores achados.
     * @data: 03/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    procurarParticipantes: function(event){
        var elMsg = document.createElement("span");
        elMsg.setAttribute("name", "msgProcura");
        var outrasTeclas = ["ArrowLeft", "ArrowRight", "Home", "End", "PageDown", "PageUp", "Tab", "Insert", "PrintScreen", "CapsLock", "ShiftLeft", "ShiftRight", "ControlLeft", "ControlRight", "AltLeft", "AltRight"];
        var campoProcurar = document.querySelector("#procParticipante");
        var valorCampo = campoProcurar.value;
        campoProcurar.value = campoProcurar.value.replace(/[^a-zA-Zà-úÀ-Ú0-9\s-.]/g,'');
        //Somente fazer a requisição se o conteúdo for válido após o replace e a tecla for válida.
        if(valorCampo.length==campoProcurar.value.length && !outrasTeclas.includes(event.code.toString())){
            //O formulário de busca possui um evento atrelado ao submit. O campo de texto possui um evento atrelado de keyup.
            //Quando o Enter é pressionado no campo os dois eventos disparam, mas preciso de apenas um disparo.
            //Abaixo o if me restringe a um disparo. Contudo não está "bonito", observe que o corpo do if é vazio.
            if(event=='undefined' || event==null){}else{
                if(campoProcurar.value.length>2){
                    elMsg.appendChild(document.createTextNode("Procurando..."));
                    utils.inserirElementoDepois(campoProcurar, elMsg);
                    var processo = document.querySelector('form > input[name="processo"]');
                    var url = document.querySelector("form").action;
                    var req = new XMLHttpRequest();
                    req.onreadystatechange = function(){
                        if(req.readyState == 4 && req.status == 200){
                            if(req.responseText!='false' && req.responseText!=""){
                                //para armazenar os dados do formulario precisei tirar as aspas duplas, preciso recoloca-las
                                jsonDados = req.responseText.split(new RegExp('aspas', 'i')).join('\"');
                                administracao.preencherCorpoTabelaParticipantes(jsonDados, 0);
                                //Esconder a section referente a paginação
                                document.getElementById("selNrRegistrosPorPagina").parentNode.style.display = "none";
                            }
                        }
                    };
                    req.open("GET", url + "?" + processo.name + "=" + processo.value + "&p=" + campoProcurar.value, true);
                    req.send(null);
                }else{//O campo tem menos de 3 caracteres, quando tiver zero, mostrar a tabela "normal"
                    if(campoProcurar.value.length==0){
                        //Esconder a section referente a paginação
                        document.getElementById("selNrRegistrosPorPagina").parentNode.style.display = "block";
                        administracao.paginarParticipantes(1);
                    }
                }
            }
        }
    },
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Somente cria os eventos necessários para a procura de participantes.
     * @data: 03/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    eventosProcurarParticipantes: function(){
        var form = null;
        var campoProcurar = document.querySelector("#procParticipante");
        if(campoProcurar){
            campoProcurar.addEventListener("keyup", this.procurarParticipantes, true);

            form = campoProcurar.parentNode;
            form.addEventListener("submit", function(evento){
                if(!evento.defaultPrevented){
                    evento.preventDefault();
                    evento.returnValue = false;
                }
                this.procurarParticipantes();
            }, true);
        }
    }
};

/* 
 * @autor: Denis Lucas Silva.
 * @descrição: Objeto literal de funções úteis para a paginação de resultados com table.
 * @data: 01/07/2017.
 * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
 * @alterada por: nome, nome, nome, etc.
 */
paginacao = {
    limparConteudoTabela: function(strIdTable){
        var tBody = document.querySelector("table[id='"+strIdTable+"'] tbody");
        let linhas = tBody.querySelectorAll("tr");
        for(var linha of linhas){
            tBody.removeChild(linha);
        }
    },
    limparPaginacao: function(strIdContainer, strElPages){
        let secPaginacao = document.querySelector("#"+strIdContainer);
        let linksPag = secPaginacao.querySelectorAll(strElPages);
        for(var link of linksPag){
            secPaginacao.removeChild(link);
        }
    },
    criarPaginacao: function(strIdContainer, pag, nrTotalRegistros, quantPorPagina, funcOnClick){
        let secPaginacao = document.querySelector("#"+strIdContainer);
        var paginas = Math.ceil(nrTotalRegistros/quantPorPagina);
        if(paginas>1){
            for(var i=1; i<=paginas; i++){
                let span = document.createElement("span");
                if(pag==i){
                    span.className = "ativo";
                }
                let lkPagina = document.createElement("a");
                let txt = document.createTextNode(i+" | ");
                lkPagina.href = "#";
                lkPagina.data = i;
                lkPagina.appendChild(txt);
                lkPagina.addEventListener("click", function(){
                    funcOnClick(this.data);
                }, false);
                span.appendChild(lkPagina);
                secPaginacao.appendChild(span);
            }
        }
    },
    eventoSelectNrRegistrosPorPagina: function(funcPaginar){
        if(document.querySelector("#selNrRegistrosPorPagina")){
            document.querySelector("#selNrRegistrosPorPagina").addEventListener("change", function(){
                if(funcPaginar)
                    funcPaginar(1);
            });
        }
    }
};

recurso = {
    /* 
     * @autor: Denis Lucas Silva.
     * @descrição: Responsável por executar a chamada ao método no controller, 
     *             popular a tabela de acordo com o select de quantidade de resultados na view recursosView.php.
     * @data: 10/07/2017.
     * @alterada em: dd/mm/aaaa, dd/mm/aaaa, dd/mm/aaaa, etc.
     * @alterada por: nome, nome, nome, etc.
     */
    paginarRecursos: function(pag){
        if(document.querySelector("table[id='tabRecursos']")){
            var quant = document.getElementById("selNrRegistrosPorPagina").value;
            var nrRegistros = 0;
            var req = new XMLHttpRequest();
            req.onreadystatechange = function(){
                if(req.readyState == 4 && req.status == 200){
                    if(req.responseText!='false' && req.responseText!=""){
                        //para armazenar os dados do formulario precisei tirar as aspas duplas, preciso recoloca-las
                        objDados = req.responseText.split(new RegExp('aspas', 'i')).join('\"');
                        recurso.preencherCorpoTabelaRecursos(objDados, pag);
                    }
                }
            }
            //Ativada a sinccronia, senão as opções não existem para outros métodos AJAX.
            req.open("GET", "../ctrl/recursoCRT.php?processo=listar&pagina="+pag+"&quantidade="+quant, false);
            req.send(null);
        }
    },
    preencherCorpoTabelaRecursos: function(jsonDados, pag){
        var quant = document.getElementById("selNrRegistrosPorPagina").value;
        var nrRegistros = 0;
        objDados = JSON.parse(jsonDados);
        var tBody = document.querySelector("table[id='tabRecursos'] tbody");
        paginacao.limparConteudoTabela("tabRecursos");
        //Criar as novas linhas
        for(var obj of objDados){
            nrRegistros = obj.quantidade;

            let tRow = document.createElement("tr");
            let tData = document.createElement("td");
            let txt = document.createTextNode(obj.rec_patrimonio=="" ? "s/n" : obj.rec_patrimonio);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            txt = document.createTextNode(obj.rec_nome);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            txt = document.createTextNode(obj.rec_descricao);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            let data = obj.rec_timestamp.split("-");
            data = (data[2].split(" ")[0]+"/"+data[1]+"/"+data[0]).trim();
            tData = document.createElement("td");
            txt = document.createTextNode(data);
            tData.appendChild(txt);
            tRow.appendChild(tData);

            tData = document.createElement("td");
            let lkeditar = document.createElement("a");
            lkeditar.href = "recursoCRT.php?processo=editar&rec=" + obj.rec_id;
            txt = document.createTextNode("Editar");
            lkeditar.appendChild(txt);
            let lkexcluir = document.createElement("a");
            lkexcluir.href = "recursoCRT.php?processo=excluir&rec=" + obj.rec_id;
            txt = document.createTextNode("Excluir");
            lkexcluir.appendChild(txt);

            tData.appendChild(lkeditar);
            tData.appendChild(lkexcluir);
            tRow.appendChild(tData);

            tBody.appendChild(tRow);            
        }
        paginacao.limparPaginacao("paginacao", "span");
        paginacao.criarPaginacao("paginacao", pag, nrRegistros, quant, recurso.paginarRecursos);
        utils.dialogoConfirmacaoExcluir();
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