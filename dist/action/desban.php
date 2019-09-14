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

		if ($permInfo['getBan'] == 1) {
			$id = $_POST['id'];

			$nick = $con->_getNickName($id);

			$con->_query("UPDATE usuarios SET alert='0' WHERE id = '$id'");
  			$con->_query("DELETE FROM banidos WHERE idForum = '$id'");
			$con->_addLog($userID, "Removeu o banimento de " . $nick ." com sucesso.", 'Banidos' );
			header("Location: ../../administrativo/banidos.php?sucess=101");
		}else{
			header("Location: ../../administrativo/banidos.php?error=102");
			$con->_addLog($userID, "Tentou remover um banimento, mas o mesmo não tem permissão.", 'Banidos' );
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