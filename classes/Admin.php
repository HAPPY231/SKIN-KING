<?php

class Admin extends Main
{
    private $data,$fetch,$resprof;
    public function Show(){
        if(!$this->getUser('is_admin')) return header('Location: Home');
        $this->data = date("Y-m-d");
        $con = (new \Connect);
        $profit = "SELECT `logi`.`case_value`,`skins`.`price` FROM `logi` INNER JOIN `skins` ON `logi`.`skin_id`=`skins`.`id` WHERE `logi`.`action`='draw' AND `logi`.`date_of_draw`='{$this->admin('data')}'";
        $this->resprof = $con->getDbc()->query($profit);
        $this->fetch = $this->admin('resprof')->fetch_all(MYSQLI_ASSOC);
        $this->addCss("//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css");
        $this->addJs("//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js");
        $this->addJs("//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js");
        $this->addJs("https://cdn.jsdelivr.net/npm/chart.js");
        $this->loadTemplate('admin','Admin Panel');
    }
    public function admin($param){
        return $this->$param;
    }
}