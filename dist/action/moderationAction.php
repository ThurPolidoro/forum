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


		$processoID = null;
		$action = null;
		if (isset($_GET['action'])) {
			$action = $_GET['action'];
		}
		if (isset($_GET['id'])) {
			$processoID = $_GET['id'];
		}
		$getProcess = $con->_getProcess($processoID, $cargo);

		if($action == 'hide'){
			if ($permInfo['hideProcess'] == 1) {				
				$update = $con->_query("UPDATE processos SET visibile= '0' WHERE id = '$processoID'");
				$con->_addLog($userID, "Deixou oculto o processo nº " . $processoID . ".", 'Processos');			
				header("Location: ../../processos/processo.php?id=" . $processoID);			
			}else{
				$con->_addLog($userID, "Tentou ocultar o processo nº " . $processoID . ". porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}
		}elseif ($action == 'show') {
			if ($permInfo['showProcess'] == 1) {
				$update = $con->_query("UPDATE processos SET visibile= '1' WHERE id = '$processoID'");
				$con->_addLog($userID, "Deixou visivel o processo nº " . $processoID . ".", 'Processos');			
				header("Location: ../../processos/processo.php?id=" . $processoID);			
			}else{
				$con->_addLog($userID, "Tentou deixar visivel o processo nº " . $processoID . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}		
		}elseif ($action == 'lock') {
			if ($permInfo['lockProcess'] == 1) {
				$con->_addLog($userID, "Travou o processo nº " . $processoID . ".", 'Processos');
				$update = $con->_query("UPDATE processos SET access= '0' WHERE id = '$processoID'");			
				header("Location: ../../processos/processo.php?id=" . $processoID);			
			}else{
				$con->_addLog($userID, "Tentou travar o processo nº " . $processoID . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}		
		}elseif ($action == 'unlock') {
			if ($permInfo['unlockProcess'] == 1) {
				$con->_addLog($userID, "Destravou o processo nº " . $processoID . ".", 'Processos');
				$update = $con->_query("UPDATE processos SET access= '1' WHERE id = '$processoID'");			
				header("Location: ../../processos/processo.php?id=" . $processoID);			
			}else{
				$con->_addLog($userID, "Tentou destravar o processo nº " . $processoID . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}		
		}elseif ($action == 'move') {
			if ($permInfo['moveProcess'] == 1) {
				$newArea = $_GET['area'];
				$con->_addLog($userID, "Moveu o processo nº " . $processoID . " para " . $newArea . ".", 'Processos');
				$update = $con->_query("UPDATE processos SET area='$newArea' WHERE id = '$processoID'");			
				header("Location: ../../processos/processo.php?id=" . $processoID);
			}else{		
				$con->_addLog($userID, "Tentou mover o processo nº " . $processoID . " para " . $newArea . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");		
			}		
		}elseif ($action == 'getprocess') {
			if ($getProcess == true) {
				$update = $con->_query("UPDATE processos SET respID='$userID', status='Em andamento' WHERE id = '$processoID'");			

				$comentario = "6d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf4";
				date_default_timezone_set('America/Sao_Paulo');
				$data = date('d/m/Y');
				$hora = date('H:i:s');
				$ip = $_SERVER['REMOTE_ADDR'];
				$insert = $con->_query("INSERT INTO comentarios (idProcess, userID,  comentario, ip, data, hora, editado) VALUES ('$processoID', '$userID',  '$comentario','$ip','$data', '$hora', '0')");

				$con->_addLog($userID, "Pegou o processo nº " . $processoID . " para analisar.", 'Processos');
				header("Location: ../../processos/processo.php?id=" . $processoID);
			}else{		
				$con->_addLog($userID, "Tentou pegar o processo nº " . $processoID . " para analisar, porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");		
			}		
		}elseif($action == 'requestJuri'){			
			if ($getProcess == true) {
				$update = $con->_query("UPDATE processos SET juri='1' WHERE id = '$processoID'");		


				$comentario = "27c47b28fb5f4545bda5d276ab55d84ccf9cc790581904c72fecdb4d623ce049396a14ab206e2b44e03c4e00393e948cce36a6b0f0d7489cb46d944b33ad51c8";
				date_default_timezone_set('America/Sao_Paulo'); 
				$data = date('d/m/Y');
				$hora = date('H:i:s');
				$ip = $_SERVER['REMOTE_ADDR'];
				$insert = $con->_query("INSERT INTO `comentarios` (`idProcess`, `userID`,  `comentario`, `ip`, `data`, `hora`, `editado`) VALUES ('$processoID', '$userID',  '$comentario', '$ip', '$data', '$hora', '0')");

				$con->_addLog($userID, "Solicitou JURI o processo nº " . $processoID . " para analisar.", 'Processos');
				header("Location: ../../processos/processo.php?id=" . $processoID);
			}else{		
				$con->_addLog($userID, "Tentou solicitar um JURI o processo nº " . $processoID . ". porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");		
			}
		}elseif($action == 'delete'){
			if ($permInfo['getDel'] == 1) {
				$update = $con->_query("UPDATE processos SET deletado= '1' WHERE id = '$processoID'");

				$con->_addLog($userID, "Deletou o processo nº " . $processoID . " para analisar.", 'Processos');
				header("Location: ../../processos/processo.php?id=" . $processoID);			
			}else{
				$con->_addLog($userID, "Tentou deletar o processo nº " . $processoID . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}	
		}elseif($action == 'restore'){
			if ($permInfo['getRestore'] == 1) {
				$update = $con->_query("UPDATE processos SET deletado= '0' WHERE id = '$processoID'");
				$con->_addLog($userID, "Restaurou o processo nº " . $processoID . " para analisar.", 'Processos');
				header("Location: ../../processos/processo.php?id=" . $processoID);
			}else{				
				$con->_addLog($userID, "Tentou restaurar o processo nº " . $processoID . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}	
		}elseif($action == 'returnDecision'){
			if ($permInfo['getRestore'] == 1) {
				$update = $con->_query("UPDATE processos SET status= 'Em andamento' WHERE id = '$processoID'");

				$ver = $con->_query("SELECT * FROM punicao WHERE id_process = '$processoID'");
				if (@mysqli_num_rows > 0)
					$ver = $con->_query("DELETE FROM punicao WHERE id_process = '$processoID'");

				$con->_addLog($userID, "Revolgou a sentença do processo nº " . $processoID . " para analisar.", 'Processos');
				header("Location: ../../processos/processo.php?id=" . $processoID);			
			}else{
				$con->_addLog($userID, "Tentou revolgar a sentença do processo nº " . $processoID . ", porém não tem permissão para isto.", 'Arquivo de Ações');
				header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");			
			}	
		}elseif($action == 'example'){

			header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");
		}else{
			header("Location: ../../processos/processo.php?id=" . $processoID . "&error=200");	
		}

	}else{
    	$con->_addAlert($userID, 5);
		$con->_addLog($userID, "Tentou acessar uma área restrita para administradores.", 'Invasão');
		header("Location: ../../index.php");
	}
}else{
	header("Location: ../../index.php");
}



?>