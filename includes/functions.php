<?php

class conDB {

    private $user;
    private $password;
    private $database;
    private $host;



    public function conexao($host ,$user, $password, $database){

        $this->user     =   $user;
        $this->password =   $password;
        $this->database =   $database;
        $this->host     =   $host;

        $this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database);

        if (mysqli_connect_errno()) {
            die('FATAL ERROR: Can not connect to SQL Server.');
            exit();
        }
    }



    public function _query($qr)
    {
        $this->result = $this->mysqli->query($qr);
        return $this->result;
    }



    public function _close()
    {
        $this->mysqli->close();
    }

    public function _isBanIP($ip)
    {
        $a = $this->_query("SELECT * FROM banidos WHERE ip = '$ip' LIMIT 1");

        $b = mysqli_num_rows($a);
        if($b > 0){
            $this->result = 1;
            return $this->result;
        }else{
            $this->result = 0;
            return $this->result;
        }
    }


    public function _getIDReu($nickUser)

    {
        $a = $this->_query("SELECT id FROM usuarios WHERE name = '$nickUser' LIMIT 1");

        $b = mysqli_fetch_array($a);
        $this->result = $b['id'];
        return $this->result;
    }



    public function _getIDProcess($idUser)
    {
        $a = $this->_query("SELECT id FROM processos WHERE autorID = '$idUser' ORDER BY id DESC LIMIT 1");
        $b = mysqli_fetch_array($a);
        $this->result = $b['id'];
        return $this->result;
    }


    public function _getInfoProcess($idProcess)
    {

        $a = $this->_query("SELECT * FROM processos WHERE id = '$idProcess'");

        $b = mysqli_num_rows($a);

        if($b > 0){
            $this->result = mysqli_fetch_array($a);
            return $this->result;
        }else{
            $this->result = 0;
            return $this->result;
        }
    }

    public function _getMotivo($motivo)
    {

        $a =  $this->_query("SELECT motivo FROM motivo WHERE motivoValue = '$motivo'");
        $b = mysqli_fetch_array($a);
        $this->result = $b['motivo'];
        return $this->result;

    }

    public function _getCargo($id)
    {
        $a =  $this->_query("SELECT * FROM permissoes WHERE id = '$id'");
        $b = mysqli_fetch_array($a);
        $this->result = $b['name'];
        return $this->result;
    }


    public function _getPerm($cargo)
    {
        $a =  $this->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
        $this->result = mysqli_fetch_array($a);
        return $this->result;
    }

    public function _getAdmin($id)
    {
        $a =  $this->_query("SELECT * FROM permissoes WHERE id = '$id'");
        $b = mysqli_fetch_array($a);
        $c = $b['isAdmin'];

        if($c == 1)
            $this->result = true;
        else
            $this->result = false;

        return $this->result;
    }

    public function _getJuri($id)
    {
        $a =  $this->_query("SELECT * FROM permissoes WHERE id = '$id'");
        $b = mysqli_fetch_array($a);
        $c = $b['isJuri'];

        if($c == 1)
            $this->result = true;
        else
            $this->result = false;

        return $this->result;
    }



    public function _getNickName($idResp)

    {
        $a = $this->_query("SELECT name FROM usuarios WHERE id = '$idResp' LIMIT 1");
        $b = mysqli_num_rows($a);

        if($b > 0){
            $c = mysqli_fetch_array($a);
            $this->result = $c['name'];
            return $this->result;
        }else{
            $this->result = 0;
            return $this->result;
        }

    }



    public function _getComment($qr)
    {
        $a = $this->mysqli->query($qr);
        $b = mysqli_num_rows($a);

        if($b > 0){
            $this->result = $a;
            return $this->result;
        }else{
            $this->result = 0;            
            return $this->result;            
        }

    }



    public function _getIsInvolvedColor($idUser, $idProcess)
    {

        $a = $this->mysqli->query("SELECT autorID FROM processos WHERE autorID = '$idUser' AND id = '$idProcess' LIMIT 1");
        $b = mysqli_num_rows($a);

        if($b > 0){
            $this->result = "success";    //COR AUTOR  
            return $this->result;
        }else{

            $c = $this->mysqli->query("SELECT reuID FROM processos WHERE reuID = '$idUser' AND id = '$idProcess' LIMIT 1");

            $d = mysqli_num_rows($c);

            if($d > 0){
                $this->result = "danger";      //COR REU  
                return $this->result; 
            }else{

                $e = $this->mysqli->query("SELECT respID FROM processos WHERE respID = '$idUser' AND id = '$idProcess' LIMIT 1");
                $f = mysqli_num_rows($e);

                if($f > 0){
                    $this->result = "info";     //COR JUIZ 
                    return $this->result;
                }else{
                    $this->result = "warning";          //COR MEMBRO  
                    return $this->result;
                }               
            }           
        }
    }

    public function _getIsInvolvedPosicao($idUser, $idProcess)
    {

        $a = $this->mysqli->query("SELECT autorID FROM processos WHERE autorID = '$idUser' AND id = '$idProcess' LIMIT 1");
        $b = mysqli_num_rows($a);
        if($b > 0){
            $this->result = "Autor";    // AUTOR  
            return $this->result;
        }else{
            $c = $this->mysqli->query("SELECT reuID FROM processos WHERE reuID = '$idUser' AND id = '$idProcess' LIMIT 1");
            $d = mysqli_num_rows($c);

            if($d > 0){
                $this->result = "Réu";      // REU  
                return $this->result; 
            }else{
                $e = $this->mysqli->query("SELECT respID FROM processos WHERE respID = '$idUser' AND id = '$idProcess' LIMIT 1");
                $f = mysqli_num_rows($e);
                if($f > 0){
                    $this->result = "Juiz";      // JUIZ 
                    return $this->result;
                }else{
                    $this->result = "Membro";           // MEMBRO  
                    return $this->result;
                }             
            }          
        }
    }


    public function _getProcess($id, $cargo)
    {
        $area = $this->_query("SELECT * FROM processos WHERE id = '$id'");
        $perm = $this->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
        $areaInfo = mysqli_fetch_array($area);
        $permInfo = mysqli_fetch_assoc($perm);

        if($areaInfo['area'] == 'Player' && $permInfo['getPlayer'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Lider/Sublideres' && $permInfo['getLider'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Cheater' && $permInfo['getCheater'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Caloteiro' && $permInfo['getCaloteiro'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Staff Server' && $permInfo['getStaff'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Staff TS3' && $permInfo['getForum'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Staff Fórum' && $permInfo['getTS'] == 1){
            $this->result = true;
        }elseif($areaInfo['area'] == 'Juiz' && $permInfo['getJuiz'] == 1){
            $this->result = true;
        }else{
            $this->result = false;
        }
        return $this->result;
    }


    public function _getProcessList($cargo)
    {
        $perm = $this->_query("SELECT * FROM permissoes WHERE name = '$cargo'");
        $permInfo = mysqli_fetch_assoc($perm);

        if($permInfo['getPlayer'] == 1){
            $this->result = true;
        }elseif($permInfo['getLider'] == 1){
            $this->result = true;
        }elseif($permInfo['getCheater'] == 1){
            $this->result = true;
        }elseif($permInfo['getCaloteiro'] == 1){
            $this->result = true;
        }elseif($permInfo['getStaff'] == 1){
            $this->result = true;
        }elseif($permInfo['getForum'] == 1){
            $this->result = true;
        }elseif($permInfo['getTS'] == 1){
            $this->result = true;
        }elseif($permInfo['getJuiz'] == 1){
            $this->result = true;
        }else{
            $this->result = false;
        }
        return $this->result;
    }

    public function _quantidadeInqueritos($area, $status)
    {
        $a = $this->mysqli->query("SELECT * FROM processos WHERE area = '$area' AND status = '$status' AND deletado = '0'");
        $b = mysqli_num_rows($a);
        
        return $b;
    }

    public function _quantidadeInqueritosApurados($area)
    {
        $a = $this->mysqli->query("SELECT * FROM processos WHERE status = 'Apurado' AND area = '$area' AND deletado = 0 OR status = 'Reprovado' AND area = '$area' AND deletado = 0 OR status = 'Punição Aplicada'  AND area = '$area' AND deletado = 0");
        $b = mysqli_num_rows($a);
        
        return $b;
    }

    public function _quantidadeInqueritosApuradosTotal()
    {
        $a = $this->mysqli->query("SELECT * FROM processos WHERE status = 'Apurado' AND deletado = 0 OR status = 'Reprovado' AND deletado = 0 OR status = 'Punição Aplicada' AND deletado = 0");
        $b = mysqli_num_rows($a);
        
        return $b;
    }
    
    public function _quantidadeInqueritosDeletados($area)
    {
        $a = $this->mysqli->query("SELECT * FROM processos WHERE area = '$area' AND deletado = 1");
        $b = mysqli_num_rows($a);        
        return $b;
    }

    public function _quantidadePunicoesMinutos()
    {
        $a = $this->mysqli->query("SELECT * FROM punicao WHERE gravidade = 0 AND minutos > 0 AND apply = 0");
        $b = mysqli_num_rows($a);        
        return $b;
    }

    public function _quantidadePunicoesAplicadas()
    {
        $a = $this->mysqli->query("SELECT * FROM punicao WHERE apply = 1");
        $b = mysqli_num_rows($a);        
        return $b;
    }

    public function _quantidadePunicoesGravidade()
    {
        $a = $this->mysqli->query("SELECT * FROM punicao WHERE gravidade > 0 AND minutos = 0 AND apply = 0");
        $b = mysqli_num_rows($a);        
        return $b;
    }

    public function _getArea($id)
    {
        if ($id == 1)
            $b = 'Player';
        elseif ($id == 2)
            $b = 'Lider/Sublideres';
        elseif ($id == 3)
            $b = 'Cheater';
        elseif ($id == 4)
            $b = 'Caloteiro';
        elseif ($id == 5)
            $b = 'Staff Server';
        elseif ($id == 6)
            $b = 'Staff Discord';
        elseif ($id == 7)
            $b = 'Staff Fórum';
        elseif ($id == 8)
            $b = 'Juiz';

        return $b;
    }

    public function _addLog($idUser, $acao, $area){
        date_default_timezone_set('America/Sao_Paulo'); 
        $data = date('d/m/Y');
        $hora = date('H:i:s');
        $ip = $_SERVER['REMOTE_ADDR'];
        $a = $this->mysqli->query("INSERT INTO logs (idUser, area, acao, data, hora, ip) VALUES ('$idUser', '$area', '$acao', '$data', '$hora', '$ip')");
        return;
    }

    public function _addAlert($idUser, $qnt){
        $info = $this->_query("SELECT * FROM usuarios WHERE id = '$idUser'");
        $infoRes = mysqli_fetch_array($info);
        $alert = $infoRes['alert'] + $qnt;

        $add = $this->_query("UPDATE usuarios SET alert='$alert' WHERE id = '$idUser'");
        return;
    }

    public function _getUser($idUser){
        $a = $this->_query("SELECT * FROM usuarios WHERE id = '$idUser' LIMIT 1");
        $this->result = mysqli_fetch_array($a);
        return $this->result;

    }

    public function _getPhoto($idUser){
        $a = $this->_query("SELECT * FROM core_members WHERE member_id = '$idUser' LIMIT 1");
        $b = mysqli_fetch_array($a);
        $this->result = "https://samp.brasilplaystart.com.br/forum/uploads/" . $b['pp_main_photo'];
        return $this->result;

    }
}

?>