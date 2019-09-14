<?php

require_once '../../includes/functions.php';
$site = new conDB();
$site->conexao('localhost', 'root', '', 'forummgy');
session_start();
$userID = $_SESSION['userID'];

date_default_timezone_set('America/Sao_Paulo'); 
$site->_addLog($userID, 'Motivo', 'Tentou criar um novo motivo (teste), pórem ele não tem permissão.');
?>