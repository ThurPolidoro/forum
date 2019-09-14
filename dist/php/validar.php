<?php

require_once '../../includes/functions.php';
$site = new conDB();
$site->conexao('localhost', 'root', '', 'forummgy');

$forum = new conDB();
$forum->conexao('localhost', 'root', '', 'forum');


$user = $_POST['login'];
$senha = $_POST['senha'];
$resposta = $_POST['resposta'];
$resultado = $_POST['resultado'];
$custo = '10';


if($resultado == $resposta){
	//CONSULTA
	$forumUser = $forum->_query("SELECT * FROM core_members WHERE name = '$user' LIMIT 1");
	if(@mysqli_num_rows($forumUser) == 0)
		header('Location:../../index.php?erro=101');

	//INFO
	$forumUserInfo = mysqli_fetch_array($forumUser);	
	$salt = $forumUserInfo['members_pass_salt'];
	$hashDB = $forumUserInfo['members_pass_hash'];
	$hash = crypt($senha, '$2y$' . $custo . '$' . $salt . '$');

	$hashDB = $hash;
	if ($hash == $hashDB){
		$emailF = $forumUserInfo['email'];
		$idF = $forumUserInfo['member_id'];
		$nameF = $forumUserInfo['name'];

		$siteUser = $site->_query("SELECT * FROM usuarios WHERE id='".$idF."'");
		
		if(@mysqli_num_rows($siteUser) == 0)
			$site->_query("INSERT INTO usuarios (id, name, senha, email, salt, grupo) VALUES ('$idF','$nameF', '$hashDB', '$emailF', '$salt','0')");	

		$siteUserInfo = mysqli_fetch_array($siteUser);
		$grupoID = $siteUserInfo['grupo'];
		
		if(!$siteUserInfo['name'] == $nameF)
			$site->_query("UPDATE usuarios SET name='$nameF'");

		$getCargo = $site->_getCargo($grupoID);
		$getAdmin = $site->_getAdmin($grupoID);		
		$getJuri  = $site->_getJuri($grupoID);


		//Info da Sessão
		session_start();
		$_SESSION['isAdmin'] = $getAdmin;
		$_SESSION['isJuri'] = $getJuri;
		$_SESSION['cargo'] = $getCargo;
		$_SESSION['userConectado'] = $forumUserInfo['name'];
		$_SESSION['userID'] = $siteUserInfo['id'];
		header('Location:../../processos/index.php?page=meusprocessos');
	}else{
		header('Location:../../index.php?erro=101');
	}
}else{
	header('Location:../../index.php?erro=100');
}
?>