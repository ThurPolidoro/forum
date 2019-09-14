<?php


require_once '../includes/functions.php';
$con = new conDB();
require_once '../includes/conexao.php';
$query = $con->_query("
CREATE TABLE permissoes2 ( `id` INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(50) NOT NULL,`getPlayer` INT(6) NOT NULL DEFAULT '0', `getLider` INT(6) NOT NULL DEFAULT '0', `getStaff` INT(6) NOT NULL DEFAULT '0', `getCheater` INT(6) NOT NULL DEFAULT '0', `getCaloteiro` INT(6) NOT NULL DEFAULT '0', `getForum` INT(6) NOT NULL DEFAULT '0', `getTS` INT(6) NOT NULL DEFAULT '0', `getJuiz` INT(6) NOT NULL DEFAULT '0', `getDel` INT(6) NOT NULL DEFAULT '0', `getViewDel` INT(6) NOT NULL DEFAULT '0', `getDelPerm` INT(6) NOT NULL DEFAULT '0', `getCreateReason` INT(6) NOT NULL DEFAULT '0', `getRemoveReason` INT(6) NOT NULL DEFAULT '0', `getCreateRole` INT(6) NOT NULL DEFAULT '0', `getDeleteRole` INT(6) NOT NULL DEFAULT '0', `getManagerPermition` INT(6) NOT NULL DEFAULT '0', `getGiveRole` INT(6) NOT NULL DEFAULT '0', `getRemoveRole` INT(6) NOT NULL DEFAULT '0', `getViewLogs` INT(6) NOT NULL DEFAULT '0', `getViewPunishment` INT(6) NOT NULL DEFAULT '0' ) ENGINE = MyISAM

");


?>