<?php
include_once('inc/autoloader.php');
if(isset($_GET['cmd'])){$cmd = $_GET['cmd'];}
else{$cmd='';}

$Controller = new Controller($cmd);
$Object = $Controller->getObject();
//var_dump($Controller->getParameters());

if($Object!=false){
    if(class_exists($Object)){
        session_start();
        $Page = new $Object();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') return $Page->reqPost($_REQUEST);
        $Page->show();
    }	else{
        $Controller->pageRedirect("PageError",1);
    }

} else{
    $Controller->pageRedirect('Home',1);
}

?>
