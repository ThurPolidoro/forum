<?php


require_once '../../includes/functions.php';
$con = new conDB();
require_once '../../includes/conexao.php';

$user = $_POST['login'];
$senha = hash('whirlpool', $_POST['senha']);
$resposta = $_POST['resposta'];
$resultado = $_POST['resultado'];

if($resultado == $resposta){
	$sql = $con->_query("SELECT * FROM usuarios WHERE nickname='".$user."'");
	$dados=mysqli_fetch_assoc($sql);
	$senhaDB = $dados['senha'];
	if ($senha == $senhaDB){
		session_start();
		$_SESSION['userConectado'] = $dados['nickname'];
		$_SESSION['userID'] = $dados['id'];
		$getCargo = $con->_getCargo($dados['grupo']);
		$_SESSION['cargo'] = $getCargo;
		$getAdmin = $con->_getAdmin($dados['grupo']);

		if($getAdmin == 0)
			$_SESSION['isAdmin'] = false;
		else
			$_SESSION['isAdmin'] = true;


		header('Location:../../processos/index.php');	
	}else{	
		header('Location:../../index.php?erro=101');
	}
}else{
	header('Location:../../index.php?erro=100');
}
?>