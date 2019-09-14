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

		if ($permInfo['getGiveAdmin'] == 1) {
			$id = $_POST['id'];
			$cargoNew = $_POST['cargoNew'];

			$nick = $con->_getNickName($id);

			$con->_query("UPDATE usuarios SET grupo='$cargoNew' WHERE id = '$id'");
			$con->_addLog($userID, "Atualizou o cargo do administrador " . $nick ." com sucesso.", 'Administradores' );
			header("Location: ../../administrativo/administradores.php?sucess=101");
		}else{
			header("Location: ../../administrativo/administradores.php?error=102");
			$con->_addLog($userID, "Tentou atualizar o cargo de administrador, mas o mesmo não tem permissão.", 'Administradores' );
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