<?php

//Get Info
$permi = $_POST['perm_list'];

//Variaveis
$getPlayer = null;
$getLider = null;
$getStaff = null;
$getCheater = null;
$getCaloteiro = null;
$getForum = null;
$getTS = null;
$getJuiz = null;
$getDel = null;
$getViewDel = null;
$getDelPerm = null;
$getCreateReason = null;
$getRemoveReason = null;
$getCreateRole = null;
$getDeleteRole = null;
$getManagerPermition = null;
$getGiveRole = null;
$getRemoveRole = null;
$getViewLogs = null;
$getViewPunishment = null;


//Rules
if($permi[0] == '0'){$getPlayer = 0;}else{$getPlayer = 1;}
if($permi[1] == '0'){$getLider = 0;}else{$getLider = 1;}
if($permi[2] == '0'){$getStaff = 0;}else{$getStaff = 1;}
if($permi[3] == '0'){$getCheater = 0;}else{$getCheater = 1;}
if($permi[4] == '0'){$getCaloteiro = 0;}else{$getCaloteiro = 1;}
if($permi[5] == '0'){$getForum = 0;}else{$getForum = 1;}
if($permi[6] == '0'){$getTS = 0;}else{$getTS = 1;}
if($permi[7] == '0'){$getJuiz = 0;}else{$getJuiz = 1;}
if($permi[8] == '0'){$getDel = 0;}else{$getDel = 1;}
if($permi[9] == '0'){$getViewDel = 0;}else{$getViewDel = 1;}
if($permi[10] == '0'){$getDelPerm = 0;}else{$getDelPerm = 1;}
if($permi[11] == '0'){$getCreateReason = 0;}else{$getCreateReason = 1;}
if($permi[12] == '0'){$getRemoveReason = 0;}else{$getRemoveReason = 1;}
if($permi[13] == '0'){$getCreateRole = 0;}else{$getCreateRole = 1;}
if($permi[14] == '0'){$getDeleteRole = 0;}else{$getDeleteRole = 1;}
if($permi[15] == '0'){$getManagerPermition = 0;}else{$getManagerPermition = 1;}
if($permi[16] == '0'){$getGiveRole = 0;}else{$getGiveRole = 1;}
if($permi[17] == '0'){$getRemoveRole = 0;}else{$getRemoveRole = 1;}
if($permi[18] == '0'){$getViewLogs = 0;}else{$getViewLogs = 1;}
if($permi[19] == '0'){$getViewPunishment = 0;}else{$getViewPunishment = 1;}


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

		if ($permInfo['getManagerPermition'] == 1) {
			$idCargo = $_GET['id'];
			$update = $con->_query("UPDATE permissoes SET getPlayer = '$getPlayer', getLider = '$getLider', getStaff = '$getStaff', getCheater = '$getCheater', getCaloteiro = '$getCaloteiro', getForum = '$getForum', getTS = '$getTS', getJuiz = '$getJuiz', getDel = '$getDel', getViewDel = '$getViewDel', getDelPerm = '$getDelPerm', getCreateReason = '$getCreateReason', getRemoveReason = '$getRemoveReason', getCreateRole = '$getCreateRole', getDeleteRole = '$getDeleteRole', getManagerPermition = '$getManagerPermition', getGiveRole = '$getGiveRole', getRemoveRole = '$getRemoveRole', getViewLogs = '$getViewLogs', getViewPunishment = '$getViewPunishment' WHERE id = '$idCargo'");
			$con->_addLog($userID, "Atualizou as permissões do cargo de ID ". $idCargo .".", 'Punição');
			header("Location: ../../administrativo/cargo.php?success=101");

		}else{
			$con->_addLog($userID, "Tentou atualizar as permissões do cargo de ID ". $idCargo .", porém o mesmo não tem permissão para isto.", 'Punição');
			header("Location: ../../administrativo/cargo.php?error=102");
		}
	}else{
		$con->_addLog($userID, "Tentou acessar uma área restrita ('Aplicar Punição') para administradores.", 'Invasão');
		header("Location: ../../index.php");
	}
}
else{
	header("Location: ../../index.php");
}









?>