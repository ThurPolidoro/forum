<?php

require_once '../../includes/functions.php';
$site = new conDB();
$site->conexao('localhost', 'root', '', 'forummgy');

$forum = new conDB();
$forum->conexao('localhost', 'root', '', 'forum');

$forumUser = $forum->_query("SELECT * FROM core_members ORDER BY member_id");
while ($forumInfo = mysqli_fetch_array($forumUser)){	
	$email = $forumInfo['email'];	
	$id = $forumInfo['member_id'];	
	$name = $forumInfo['name'];	
	$senha = $forumInfo['members_pass_hash'];
	$salt = $forumInfo['members_pass_salt'];
	$site->_query("INSERT INTO usuarios (id, name, senha, email, salt, grupo) VALUES ('$id', '$name', '$senha', '$email', '$salt','0')");			
}
?>