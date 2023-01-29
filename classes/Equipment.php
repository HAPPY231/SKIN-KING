<?php
include "classes/Skin.php";
include "classes/Percentages.php";
class Equipment extends Main
{
    private $pages;

    public function reqPost($req){
        if(isset($req['equall'])) return $this->sellAll($req);
        if(isset($req['tran_id'])) return $this->sellOne($req);
        return $this->toHome();
    }

    public function sellAll($req){
        $sum = "SELECT SUM(`skins`.`price`) FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id` = `skins`.`id` WHERE `user_skins`.`user_id`=".$this->getUser('id');
        $get_sum = (new \Connect)->getDbc()->query($sum);
        $sum_fetch = $get_sum->fetch_row();
        $delete_skins = "DELETE FROM `user_skins` WHERE `user_id`={$this->getUser('id')}";
        $delete_query = (new \Connect)->getDbc()->query($delete_skins);
        $add_to_user_balance = "UPDATE `user` SET `account_balance`=`account_balance`+{$sum_fetch[0]} WHERE `id` = {$this->getUser('id')}";
        $add_to_user_balance_q = (new \Connect)->getDbc()->query($add_to_user_balance);
        if($add_to_user_balance_q&&$delete_query){
            $_SESSION['skin_sell'] = $sum_fetch[0];
        }
    }

    public function sellOne($req){
        $get_skin = "SELECT `user_skins`.*,`skins`.`price` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id` = `skins`.`id` WHERE `user_skins`.`id`=".$req['tran_id'];
        $tran_query = (new \Connect)->getDbc()->query($get_skin);
        $tran = $tran_query->fetch_assoc();
        if(@$tran['user_id']!=@$this->getUser('id')) return "Don't cheat!";
        $incrementa = "UPDATE user SET account_balance= account_balance+{$tran['price']} WHERE id=".$this->getUser('id');
        $increquery = (new \Connect)->getDbc()->query($incrementa);
        $sell = "DELETE FROM user_skins WHERE id='{$req['tran_id']}'";
        $sellquery = (new \Connect)->getDbc()->query($sell);
        if($sellquery&&$increquery){
            $_SESSION['skin_sell'] = $tran['price'];
        }
    }

    public function Show(){
        $this->pages = $this->getEloq('user_skins','id','user_id='.$this->getUser('id'));
        $this->loadTemplate('equipment','Equipment - '.$this->getUser('login'));
    }

    public function getPages($param){
        return $this->$param;
    }
}