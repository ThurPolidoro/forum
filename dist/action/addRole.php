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

		if ($permInfo['getCreateRole'] == 1) {
			$nameRole = $_POST['nameRole'];
			$con->_query("INSERT INTO permissoes (name) VALUES ('$nameRole')");
			header("Location: ../../administrativo/cargo.php?sucess=101");
			$con->_addLog($userID, "Criou um novo cargo (" . $nameRole . ").", 'Cargos');
		}else{
			$con->_addLog($userID, "Tentou criar um novo cargo (" . $nameRole . "), porém não tem permissão para isso.", 'Cargos');
			header("Location: ../../administrativo/cargo.php?error=102");
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