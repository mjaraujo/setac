<?php
require_once '../dto/MenusDTO.php';
require_once '../dao/MenusDAO.php';
require_once '../dto/PermissoesDTO.php';
require_once '../bo/permissaoBO.php';
require_once '../dao/PermissoesDAO.php';;
session_start();
isset($_SESSION['par_id']) ? '': header("location:./../index.php");
//$arqReq = $_SERVER["REQUEST_URI"];
//$posDotPhp = strpos($arqReq, ".php")+4;
//$idx = strripos($arqReq, "/")+1;
//$arqReq = substr($arqReq, $idx, $posDotPhp-$idx);
//echo $arqReq;
$evento = get_class($this).'php' ?? header("location:./../index.php");
$processo = $opcao ?? '';
$menuDTO = new MenusDTO(NULL);
$menuDTO->setMen_evento($evento);
$menuDTO->setMen_processo($processo);
$menuDAO = new MenusDAO();
$menuDTO->fillObjMenus($menuDAO->buscarMenusEventoProcesso($menuDTO));
$permBO = new permissaoBO();
if($permBO->buscarPermissao($menuDTO->getMen_id(), $_SESSION['par_id'])==NULL){
    header("location:./../index.php");
}

