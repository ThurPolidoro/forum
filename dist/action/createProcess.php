<?php

session_start();
if(isset($_SESSION['userConectado'])){
	require_once '../../includes/functions.php';
	$con = new conDB();
	require_once '../../includes/conexao.php';
	$userConectado = $_SESSION['userConectado'];
	$userID = $_SESSION['userID'];

	/*VARIAVEIS*/
	$area = $_POST['areaProcess']; //Area processos
	$autorNick = $userConectado;//Anti Injection de falsos processos
	$autorID = $userID;
	$autorOrg = $_POST['autorOrg']; //Org Autor
	$status = 'Aguardando';
	$reuID = null;
	$reuNick = $_POST['reuNick']; //Nick Reu
	$reuOrg = null;
	if (isset($_POST['reuOrg'])) {
		$reuOrg = $_POST['reuOrg']; //Org Reu
	}elseif (isset($_POST['reuOrg1'])) {
		$reuOrg = $_POST['reuOrg1']; //Org Reu
	}elseif (isset($_POST['reuOrg2'])) {
		$reuOrg = $_POST['reuOrg2']; //Org Reu
	}elseif (isset($_POST['reuOrg3'])) {
		$reuOrg = $_POST['reuOrg3']; //Org Reu
	}elseif (isset($_POST['reuOrg4'])) {
		$reuOrg = $_POST['reuOrg4']; //Org Reu
	}
	$provas = $_POST['provas']; //Provas
	$motivos = $_POST['motivo']; //Motivos
	date_default_timezone_set('America/Sao_Paulo');
	$data = date('d/m/Y'); //Data
	$hora = date('H:i:s'); //HORA
	$edit = date('U'); //HORA
	$ip = $_SERVER['REMOTE_ADDR'];
	$descricao = $_POST['descricao']; //Descrição
	/*--------*/

	$reuID = $con->_getIDReu($reuNick);
	if ($reuID == null) {
		$reuID = 0;
	}
	$insert = $con->_query("INSERT INTO processos (area, data, edit, ip, hora, motivo, provas, descricao, status, autorID, autorNick, autorOrg, reuID, reuNick, reuOrg) VALUES ('$area', '$data', '$edit', '$ip', '$hora','$motivos', '$provas', '$descricao', '$status', '$autorID', '$autorNick', '$autorOrg', '$reuID', '$reuNick', '$reuOrg')");
	$idProcesso = $con->_getIDProcess($autorID);
	header("Location: ../../processos/processo.php?id=" .  $idProcesso);

}else{
	header("Location: ../../index.php");
}