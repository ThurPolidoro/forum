<?php
session_start();
if(isset($_SESSION['userConectado'])){
	if($_SESSION['isAdmin'] == true){
		require_once '../../includes/functions.php';
		$con = new conDB();
		require_once '../../includes/conexao.php';
		$userConectado = $_SESSION['userConectado'];
		$userID = $_SESSION['userID'];
		$cargo = $_SESSION['cargo'];

		$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
		$permInfo = mysqli_fetch_assoc($permConsulta);

		if ($permInfo['getApplyPunish'] == 1) {
			$idProcess = $_GET['id'];
			$punishProve = $_GET['url'];
			$con->_query("UPDATE punicao SET apply = '1', provas='$punishProve' WHERE id_processo = '$idProcess'");
			$update = $con->_query("UPDATE processos SET status= 'Punição Aplicada' WHERE id = '$idProcess'");

			$con->_addLog($userID, "Confirmou a aplicação da sentença in-game no réu do processo ". $idProcess .".", 'Punição');
			header("Location: ../../processos/punicao.php?sucess=101");
		}else{
			$con->_addLog($userID, "Tentou confirma a aplicação da sentença in-game no réu do processo ". $idProcess .", porém não tem permissão para isso.", 'Punição');
			header("Location: ../../processos/punicao.php?error=102");
		}
	}else{
    	$con->_addAlert($userID, 4);
		$con->_addLog($userID, "Tentou acessar uma área restrita ('Aplicar Punição') para administradores.", 'Invasão');
		header("Location: ../../index.php");
	}
}
else{
	header("Location: ../../index.php");
}
?>