<?php


require_once '../../includes/functions.php';
$con = new conDB();
$con2 = new conDB();
$con2->conexao('localhost', 'root', '', 'forummgy');
require_once '../../includes/conexao.php';


$user = $_POST['login'];
$senha = hash('whirlpool', $_POST['senha']);
$resposta = $_POST['resposta'];
$resultado = $_POST['resultado'];
$custo = '13';


if($resultado == $resposta){

	$saltPegar = $con2->_query("SELECT * FROM core_members WHERE name = '$user' LIMIT 1");
	if(@mysqli_num_rows($saltPegar) == 0){
		header('Location:../../index.php?erro=101');
	}
	$saltDados=mysqli_fetch_assoc($saltPegar);
	$saltFim = $saltDados['members_pass_salt'];
	$hash = crypt($senha, '$2y$' . $custo . '$' . $saltFim . '$');

	$sql = $con->_query("SELECT * FROM core_members WHERE name='".$user."'");
	$dados=mysqli_fetch_assoc($sql);
	$senhaDB = $dados['members_pass_hash'];
	if ($hash == $senhaDB){
		session_start();
		$_SESSION['userConectado'] = $dados['name'];
		$_SESSION['userID'] = $dados['member_id'];

		$sql = $con->_query("SELECT * FROM usuarios WHERE nickname='".$user."'");
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