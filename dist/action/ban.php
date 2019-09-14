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
			$nick = $_POST['nick'];

			$id = $con->_getIDReu($nick);

			$con->_query("UPDATE usuarios SET alert='40' WHERE name = '$nick'");
  			$con->_query("INSERT INTO banidos (idForum, ip) VALUES ('$id', '0')");
			$con->_addLog($userID, "Adicionou um banimento manual em " . $nick ."  com sucesso.", 'Banidos' );
			header("Location: ../../administrativo/banidos.php?sucess=101");
		}else{
			header("Location: ../../administrativo/banidos.php?error=102");
			$con->_addLog($userID, "Tentou adicionar um banimento manual, mas o mesmo não tem permissão.", 'Banidos' );
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