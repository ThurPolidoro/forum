<?php
session_start();
require_once '../../includes/functions.php';
$con = new conDB();
require_once '../../includes/conexao.php';
if(isset($_SESSION['userConectado'])){
	if($_SESSION['isAdmin'] == true){
		$userConectado = $_SESSION['userConectado'];
		$userID = $_SESSION['userID'];
		$cargo = $_SESSION['cargo'];

		$permConsulta = $con->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
		$permInfo = mysqli_fetch_assoc($permConsulta);
		
		$idProcess = $_POST['id'];
		$process = $con->_getInfoProcess($idProcess);
		$juiz = $process['respID'];


		if ($userID == $juiz) {
			$tipo = $_POST['tipo'];
			date_default_timezone_set('America/Sao_Paulo');
			$data = date('d/m/Y | H:i:s');
			if ($tipo == 'minutos') {				
				$minutos = $_POST['minutos'];
				$avisos = $_POST['avisos'];
				$autor = $process['autorID'];
				$reu = $process['reuID'];
				$motivo = $process['motivo'];
				$con->_query("INSERT INTO punicao (id_processo, data, juiz, autorID, reuID, motivo, gravidade, minutos, avisos) VALUES ('$idProcess', '$data', '$juiz', '$autor', '$reu', '$motivo', '0', '$minutos', '$avisos')");
				$con->_query("UPDATE processos SET status='Apurado' WHERE id = '$idProcess'");

				$comentario = "9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8";
				$data = date('d/m/Y');
				$hora = date('H:i:s');
				$ip = $_SERVER['REMOTE_ADDR'];
				$insert = $con->_query("INSERT INTO comentarios (idProcess, userID,  comentario, ip, data, hora, editado) VALUES ('$idProcess', '$userID',  '$comentario','$ip','$data', '$hora', '0')");

				$nick = $process['reuNick'];

				$con->_addLog($userID, "Aplicou a sentença em " . $nick . "no processo nº" . $idProcess . "", 'Processos');
				header("Location: ../../processos/processo.php?sucess=101&id=" . $idProcess);					
			}else{
				$gravidade = $_POST['gravidade'];
				$avisos = $_POST['avisos'];
				$autor = $process['autorID'];
				$reu = $process['reuID'];
				$motivo = $process['motivo'];
				$con->_query("INSERT INTO punicao (id_processo, data, juiz, autorID, reuID, motivo, gravidade, minutos, avisos) VALUES ('$idProcess', '$data', '$juiz', '$autor', '$reu', '$motivo', '$gravidade', '0', '$avisos')");
				$con->_query("UPDATE processos SET status='Apurado' WHERE id = '$idProcess'");

				$comentario = "9d8c1edf0a8c123da81e3947b349c03327dba532cc6f2147edfa4d76d97aaaf2f52d63231eb0dbaac689ec9147e4b131fc95ef92d5bc78135b22934b36d76bf8";
				$data = date('d/m/Y');
				$hora = date('H:i:s');
				$ip = $_SERVER['REMOTE_ADDR'];
				$insert = $con->_query("INSERT INTO comentarios (idProcess, userID,  comentario, ip, data, hora, editado) VALUES ('$idProcess', '$userID',  '$comentario','$ip','$data', '$hora', '0')");
				
				$con->_addLog($userID, "Aplicou a sentença em " . $nick . "no processo nº" . $idProcess . "", 'Processos');
				header("Location: ../../processos/processo.php?sucess=101&id=" . $idProcess);				
			}



		}else{				
			$con->_addLog($userID, "Tentou sentenciar " . $nick . "no processo nº" . $idProcess . ", mas não era o responsável pelo o processo.", 'Processos');
			header("Location: ../../processos/processo.php?error=102&id=" . $idProcess);
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