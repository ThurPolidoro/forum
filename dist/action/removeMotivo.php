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

		if ($permInfo['getRemoveReason'] == 1) {
			$motivoID = $_POST['motivoID'];
			$con->_query("DELETE FROM motivo WHERE id = '$motivoID'");
			$con->_addLog($userID, "Deletou o motivo ID (" . $motivoID . ").", 'Motivo');
			header("Location: ../../administrativo/cargo.php?sucess=101");
		}else{
			$con->_addLog($userID, "Tentou deletar um motivo ID (" . $motivoID . "), porém não tem permissão para isso.", 'Motivo');
			header("Location: ../../administrativo/cargo.php?error=102");
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