<?php

require_once '../../includes/functions.php';
$site = new conDB();
$site->conexao('localhost', 'brasi386_Site2', '167F$+Jw)Xo#', 'brasi386_Site2');

$forum = new conDB();
$forum->conexao('localhost', 'brasi386_ipbUser', 'L2GnAFgEtFV1', 'brasi386_ipbForum');


$user = $_POST['login'];
$senha = $_POST['senha'];
$resposta = $_POST['resposta'];
$resultado = $_POST['resultado'];
$custo = '13';


if($resultado == $resposta){
	//CONSULTA
	$forumUser = $forum->_query("SELECT * FROM core_members WHERE name = '$user' LIMIT 1");
	if(@mysqli_num_rows($forumUser) == 0)
		header('Location:../../index.php?erro=101');
	//INFO
	$forumUserInfo = mysqli_fetch_array($forumUser);	
	$salt = $forumUserInfo['members_pass_salt'];
	$hashDB = $forumUserInfo['members_pass_hash'];
	$hash = crypt($senha, '$2a$' . $custo . '$' . $salt . '$');

	if ($hash == $hashDB){
		$emailF = $forumUserInfo['email'];
		$idF = $forumUserInfo['member_id'];
		$nameF = $forumUserInfo['name'];

		$siteUser = $site->_query("SELECT * FROM usuarios WHERE idForum='".$idF."'");
		
		if(@mysqli_num_rows($siteUser) == 0)
			$site->_query("INSERT INTO usuarios (idForum, name, senha, email, salt, grupo) VALUES ('$idF','$nameF', '$hashDB', '$emailF', '$salt','0')");	

		$siteUserInfo = mysqli_fetch_array($siteUser);
		$grupoID = $siteUserInfo['grupo'];
		
		if(!$siteUserInfo['name'] == $nameF)
			$site->_query("UPDATE usuarios SET name='$nameF'");

		$getCargo = $site->_getCargo($grupoID);
		$getAdmin = $site->_getAdmin($grupoID);
		

	//Verificando se é admin
		session_start();
		if($getAdmin == 0)
			$_SESSION['isAdmin'] = false;
		else
			$_SESSION['isAdmin'] = true;

		//Info da Sessão
		$_SESSION['cargo'] = $getCargo;
		$_SESSION['userConectado'] = $forumUserInfo['name'];
		$_SESSION['userID'] = $siteUserInfo['id'];

		header('Location:../../processos/index.php');
	}else{
		header('Location:../../index.php?erro=101');



	}
}else{
	header('Location:../../index.php?erro=100');
}
?>