<?php
include "classes/Skin.php";
class Casee extends Main
{
    private $case,$skins;
    public function reqPost($req)
    {
        if(isset($req['case_id']) && isset($req['case_value']) && isset($req['user_id'])) return $this->openCase($req);
        if(isset($req['skin_id']) && isset($req['skin_price'])&&isset($req['transaciton'])) return $this->sellSkin($req);
        return $this->toHome();
    }
    public function sellSkin($req){
        $incrementa = "UPDATE user SET account_balance= account_balance+{$req['skin_price']} WHERE id=".$this->getUser('id');
        $increquery = (new \Connect)->getDbc()->query($incrementa);
        $sell = "DELETE FROM user_skins WHERE id='{$req['transaciton']}'";
        $sellquery = (new \Connect)->getDbc()->query($sell);

        if($sellquery && $increquery){
            $_SESSION['skin_sell'] = $req['skin_price'];
        }
    }
    public function openCase($req){
        if(!$this->getUser('id')) return header("Location: ".$this->gHost()."/Home");
        $case_q = $this->getEloq('cases','*','id='.$req['case_id']);
        $case = $case_q->fetch_assoc();
        if($this->getUser('account_b')<$case['price']) return $this->toHome();
        date_default_timezone_set('Europe/Warsaw');
        $i = 0;
        $percentage = 0;
        $skins = "SELECT * FROM `skins_in_cases` RIGHT JOIN `skins` on `skins_in_cases`.`skin_id`=`skins`.`id` WHERE `skins_in_cases`.`case_id`={$case['id']} ORDER BY `skins`.`price` DESC";
        $daw = (new \Connect)->getDbc()->query($skins);
        $items = array();
        while ($all = mysqli_fetch_row($daw)){
            $a[$i] = $all[2];
            $b[$i] = $all[7];
            $percentage = $percentage + $all[7];
            ${"item" . $i} = new Skin($all[3],$all[4], $all[5], $all[7], $all[6], $all[8], $all[9]);
            $items[] = "item" . $i;
            $i++;
        }
        $r = array();
        $x = 0;
        foreach ($b as $key) {
            $count1 = $key / $percentage;
            $count2 = $count1 * 100;
            $r[$x] = $count2;
            $x++;
        }
        $rv = array_reverse($r);
        $c = array_combine($a, $rv);
        function getClosest($search, $arr)
        {
            $closest = null;
            foreach ($arr as $item) {
                if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                    $closest = $item;
                }
            }
            return $closest;
        }
        $rang = rand(0.0000005, 100);
        $win = array_search(getClosest($rang, $c), $c);

        $sql = $this->getEloq('skins','*','id='.$win);
        $row = $sql->fetch_row();
        $win_s = new Skin($row[0],$row[1],$row[2],$row[4],$row[3],$row[5],$row[6]);

        $data = date("Y-m-d");

        $logs = "INSERT INTO logi VALUES(NULL,'draw',{$req['user_id']},{$win_s->getSkin('Id')},'{$req['case_value']}','{$data}')";
        $reslogs = (new \Connect)->getDbc()->query($logs);

        $add = "INSERT INTO user_skins VALUES(NULL,'{$req['user_id']}',{$win_s->getSkin('Id')})";
        $res = (new \Connect)->getDbc()->query($add);

        $transaction = $this->getEloq('user_skins','id','user_id='.$req['user_id'].' AND skin_id='.$win_s->getSkin('Id'));
        $tranrow = $transaction->fetch_row();

        $case_price = $this->getEloq('cases','price,experience','id='.$case['id']);
        $case_row = $case_price->fetch_row();
        $user_exp = $this->getUser('exp') + $case_row[1];
        $user_account_balance = $this->getUser('account_b') - $case_row[0];
        $subtraction = "UPDATE user SET account_balance = account_balance-{$case_row[0]},experience=experience+{$case_row[1]} WHERE id='{$req['user_id']}'";
        $mysql = (new \Connect)->getDbc()->query($subtraction);
        $expmax = ($this->getUser('level') * 100) + 200;
        if ($expmax < $user_exp) {
            $levelup = "UPDATE `user` SET `level`=`level`+1,`experience`=(`experience`+{$case_row[1]})-`experience` WHERE `id`={$this->getUser('id')}";
            $levelupquery = (new \Connect)->getDbc()->query($levelup);
        }
        if ($expmax == $user_exp) {
            $levelup = "UPDATE `user` SET `level`=`level`+1,`experience`=`experience`-`experience` WHERE `id`='{$req['user_id']}'";
            $levelupquery = (new \Connect)->getDbc()->query($levelup);
        }

        echo "<hr class='perpendicularr-line' style='width: 3px; height: 212px; transform: translate(33px, -21px);background-color: black; position: absolute; z-index: 3;'>";
        echo "<ul class='gallery'>";
        $count = count($items) * 4;
        for ($x = 0; $x < $count;) {
            $e = rand(0, count($items) - 1);
            $name = ${$items[$e]}->getSkin('Name');
            $image = ${$items[$e]}->getSkin('Image');
echo<<<end
                <li style="{${$items[$e]}->check()} background-image: url('{$this->gHost()}images/skins/{$image}.png');">{$name}</li>
end;
            $x++;
        }
echo<<<END
        <li style="{$win_s->check()} background-image: url('{$this->gHost()}images/skins/{$row[2]}.png');
        ">{$win_s->getSkin('Name')}</li>
END;
        for ($x = 0; $x < count($items);) {
            $e = rand(0, 7);
            $name = ${$items[$e]}->getSkin('Name');
            $image = ${$items[$e]}->getSkin('Image');
echo<<<end
        <li style="{${$items[$e]}->check()} background-image: url('{$this->gHost()}images/skins/{$image}.png');">{$name}</li>
end;
            $x++;
        }
        echo "</ul>";
        $check = $win_s->check();
        $account_balance_round = round($user_account_balance, 2);

        echo "<script>";
        echo "const tranid =" . json_encode($tranrow[0]) . ";";
        echo "const skin_id =" . json_encode($win_s->getSkin('Id')) . ";";
        echo "const name =" . json_encode($win_s->getSkin('Name')) . ";";
        echo "const price =" . json_encode($win_s->getSkin('Price')) . ";";
        echo "const image =" . json_encode($win_s->getSkin('Image')) . ";";
        echo "const state =" . json_encode($win_s->getSkin('State')) . ";";
        echo "const avatar =" . json_encode($this->getUser('avatar')) . ";";
        echo "const user =" . json_encode($this->getUser('login')) . ";";
        echo "const account =" . json_encode($account_balance_round) . ";";
        echo "const admin =" . json_encode($this->getUser('is_admin')) . ";";
        echo "const case_price =" . json_encode($case_row[0]) . ";";
        echo "const level =" . json_encode($this->getUser('level')) . ";";

echo<<<END
        let animationvalue = -30.5;
        let url = "'{$this->gHost()}images/skins/"+image+".png'";
        $('li#account').html("<img src='{$this->gHost()}images/avatars/"+avatar+".png' alt='avatar' width='38' height='38' style='border-radius: 50%;'>&nbsp;"+user+": "+account+"PLN <div class='dropdown-content'><a href='Equipment'>Level: "+level+"</a><hr class='mx-auto horizontal-line' style='margin-top: 1px; margin-bottom: 9px;'><a href='Lottery'>Lottery</a><br><a href='Equipment'>Equipment</a><br><a href='Settings'>Settings</a><form method='POST'><input type='submit' id='sell' name='loguot' value='Log out'></form></div>");
        $('li#substraction').html("-"+case_price+"PLN"); 
        $('li#substraction').css({"opacity":"1","transform":"translate(0px,40px)"});
        if(admin==true){
            $('div.dropdown-content a:last').after("<br><a href='Admin'>Admin Panel</a><br>");
        }
        setTimeout(function(){
            $('li#substraction').css({'opacity':'0','transform':'translate(0px,-30px)'}); 
           
        },2000);

        $('.gallery').animate({  borderColapse: animationvalue }, {
            step: function(now,fx) {
              $(this).css('transform','translate('+now+'%)');  
            },
            duration:'3000'
        },'linear');
        let audio = {};
        audio["opening"] = new Audio();
        audio["opening"].src = "{$this->gHost()}sounds/Opening_sound.mp3";
        audio["opening"].volume = 0.2;
        audio["opening"].play();
        
        setTimeout(function(){
            $('div.keys').css({"text-align":"center","justify-content":"space-between","padding":"30px"});
            $('div.keys').html("<div class='mx-auto winner'><div class='skin' style='width:250px;   height: 250px; margin-top: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; align-content: flex-end {$check}'> <img src='{$this->gHost()}/images/skins/"+image+".png' style='width: 250px;height:250px;'></div><br><hr class='perpendicular-line' style='width:200px;transform: translateY(120px) rotate(90deg);'><div class='infos' style='width: 50%;height:200px;justify-content: space-between;margin-top: 40px;'><span style='font-size: 30px;text-transform: uppercase; font-weight: 700;'>"+name+"</span><br><span>Cena: "+price+"PLN</span><br><span>Stan: "+state+"</span><div class='d-flex' style='width: 100%;margin-top: 25px;justify-content: space-between;align-items: center; align-content: center;'><button id='sell'>Sell</button><button id='again'>Keep</button></div></div></div></div>");
            
            $('button#sell').click(function(){
                $.post("Casee",{
                    skin_id: skin_id,
                    skin_price: price,
                    transaciton: tranid
                },function(data,status){
                    $('.keys').after(data);
                    window.location.reload();
                });
        });
            $('button#again').click(function(){
                window.location.reload();
        });
    },4000); 
        
       
</script>
END;
    }
    public function Show(){
        if(!isset($_GET['id'])) return $this->toHome();
        $get_case = $this->getEloq('cases','*','id='.$_GET['id']);
        if($get_case->num_rows<=0) return $this->toHome();
        $this->case = $get_case->fetch_assoc();
        $get_skins = "SELECT `skins`.* FROM `skins_in_cases` RIGHT JOIN `skins` ON `skins_in_cases`.`skin_id` = `skins`.`id` WHERE `skins_in_cases`.`case_id`={$_GET['id']} ORDER BY `skins`.`price` DESC";
        $skins_query = (new \Connect)->getDbc()->query($get_skins);
        $this->skins = $skins_query->fetch_all(MYSQLI_ASSOC);
        $this->loadTemplate('case','Case');
    }
    public function get_skins(){
        return $this->skins;
    }
    public function case_i($param){
        return $this->case[$param];
    }
}