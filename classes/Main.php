<?php
include "classes/Connect.php";
class Main{
    public $css = array(),$js = array();
    private $title;
    private $id,$email,$login,$account_b,$level,$exp,$is_admin,$avatar,$date;
    private $host = 'http://localhost/SKIN-KING-OOP/';

    public function __construct(){
        if(@$_COOKIE['checksum'] == md5(@$_COOKIE['email']).@$_COOKIE['login_dod']) {
            $user = $this->getEloq('user','*','email="'.$_COOKIE['email'].'"');
            $user_assoc = $user->fetch_assoc();
          $this->id = $user_assoc['id'];
          $this->email = $user_assoc['email'];
          $this->login = $user_assoc['login'];
          $this->account_b = $user_assoc['account_balance'];
          $this->level = $user_assoc['level'];
          $this->exp = $user_assoc['experience'];
          $this->is_admin = $user_assoc['admin'];
          $this->avatar = $user_assoc['avatar'];
          $this->date = $user_assoc['date'];
        }else{
          $this->logout();
          $this->id = 0;
        }

        if($this->getUser('id')&&isset($_POST['logout'])){
            $this->logout();
        }
    }
    public static function logout(){
        setcookie('user', null, time() - 3600);
        setcookie('email', null, time() - 3600);
        setcookie('checksum', null, time() - 3600);
        setcookie('login_dod', null, time() - 3600);
        empty($_SESSION['user']);
        unset($_SESSION['user']);
    }
    public function gHost(){
        return $this->host;
    }
    public function getUser($param){
        return $this->$param;
    }
    public function getTitle(){
      return $this->title;
    }
    public function toHome(){
        return header("Location: {$this->gHost()}Home");
    }
    public static function getEloq($table,$columns,$where = 0){
      $select = "SELECT {$columns} FROM {$table} ";
      if($where){
          $select .= " WHERE ".$where;
      }
      return (new \Connect)->getDbc()->query($select);
    }
    public function addCss($fileName){
        $this->css[] = $fileName;
    }
    public function addJs($fileName){
      $this->js[] = $fileName;
    }
    public function loadCss(){
        $html='';
        foreach($this->css as $w){
            $html.="<link rel='stylesheet' href='{$w}' />\n";
        }
        return $html;
    }
    public function loadJs(){
        $html='';
        foreach($this->js as $w){
            $html.="<script src='{$w}'></script>\n";
        }
        return $html;
    }
    public function loadTemplate($name,$title){
    $this->title = $title;
    $this->__construct();
    include_once(getcwd().'/templates/header.php');
    include_once(getcwd().'/templates/navigation.php');
    $path = getcwd()."/templates/{$name}.php";
    if(file_exists($path)){
        include_once($path);
    }
    include_once(getcwd().'/templates/footer.php');
    }
}
