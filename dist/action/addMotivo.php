<?php
require_once '../../includes/functions.php';
$con = new conDB();
require_once '../../includes/conexao.php';
session_start();
if(isset($_SESSION['userConectado'])){
	if($_SESSION['isAdmin'] == true){
		$userConectado = $_SESSION['userConectado'];
		$userID = $_SESSION['userID'];
		$cargo = $_SESSION['cargo'];

		$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
		$permInfo = mysqli_fetch_assoc($permConsulta);

		if ($permInfo['getCreateReason'] == 1) {
			$motivo = $_POST['motivo'];
			$motivoValue = $_POST['motivoValue'];
			$con->_query("INSERT INTO permissoes (motivo, motivoValue) VALUES ('$motivo','$motivoValue')");
			$con->_addLog($userID, "Criou um novo motivo (" . $motivo .") com sucesso.", 'Motivo' );
			header("Location: ../../administrativo/motivos.php?sucess=101");
		}else{
			header("Location: ../../administrativo/motivos.php?error=102");
			$con->_addLog($userID, "Tentou criar um novo motivo (" . $motivo ."), mas o mesmo não tem permissão.", 'Motivo' );
		}
	}else{
    	$con->_addAlert($userID, 4);
		$con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Invasão');
		header("Location: ../../index.php");
	}
}
else{
	header("Location: ../../index.php");
}
?>