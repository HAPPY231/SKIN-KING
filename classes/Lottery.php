<?php

class Lottery extends Main
{
    public function reqPost($req){
        if(!isset($req['user_id'])||!isset($req['time'])) return $this->toHome();
        $user_id = $req['user_id'];
        $time_user = $req['time'];

        $add = array(1200, 800, 400, 200, 100, 50, 10);
        $fullvalue = 0;
        foreach($add as $a){
            $fullvalue = $fullvalue + $a;
        }
        $percentages = array();
        $x = 0;
        foreach($add as $a){
            $count1 = $a/$fullvalue;
            $count2 = $count1 * 100;
            $percentages[$x] = $count2;
            $x++;
        }
        $rp = array_reverse($percentages);
        $c = array_combine($add, $rp);
        function getClosest($search, $arr) {
            $closest = null;
            foreach ($arr as $item) {
                if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                    $closest = $item;
                }
            }
            return $closest;
        }
        $rang = rand(0.0000005,100);
        $win = array_search(getClosest($rang,$c),$c);
        $sqladd = "UPDATE user SET account_balance=account_balance+{$win} WHERE id={$user_id}";
        $addquery = (new \Connect)->getDbc()->query($sqladd);

        date_default_timezone_set('Europe/Warsaw');
        $date=date_create(date("Y-m-d H:i:s"));
        date_modify($date,"+30 minutes");
        $dataf = date_format($date,"Y-m-d H:i:s");

        $datechange = "UPDATE user SET `date`='{$dataf}' WHERE id={$user_id}";
        $mydatechaquery = (new \Connect)->getDbc()->query($datechange);

        echo "You win: ".$win."PLN";
    }

    public function Show(){
        return $this->loadTemplate('lottery','Lottery');
    }
}