<?php
session_start();
if(isset($_SESSION['userConectado'])){
	require_once '../../includes/functions.php';
	$con = new conDB();
	require_once '../../includes/conexao.php';
	$userConectado = $_SESSION['userConectado'];
	$userID = $_SESSION['userID'];
	date_default_timezone_set('America/Sao_Paulo'); 
	$data = date('d/m/Y'); //Data
	$hora = date('H:i:s'); //HORA
	$ip = $_SERVER['REMOTE_ADDR'];
	$idProcess = $_GET['id']; 
	$comentario = $_POST['comentario']; //Descrição

	$insert = $con->_query("INSERT INTO comentarios (idProcess, userID,  comentario, ip, data, hora, editado) VALUES ('$idProcess', '$userID',  '$comentario','$ip','$data', '$hora', '0')");
	header("Location: ../../processos/processo.php?id=" . $idProcess . "&scroll=end");
}
else{
	header("Location: ../../index.php");
}
?>