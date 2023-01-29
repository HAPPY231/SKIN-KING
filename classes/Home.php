<?php

include "classes/Skin.php";

class Home extends Main{

    public function reqPost($req)
    {
        if (isset($req['slide_i'])) return $this->sliderAjax($req);
        return $this->toHome();
    }
    public function sliderAjax($req){
        $sql = "SELECT `logi`.`id`,`logi`.`user_id`,`logi`.`skin_id`,`user`.`login`,`skins`.`name`,`skins`.`image`,`skins`.`type`,`skins`.`price`,`skins`.`Container Odds` FROM `logi` INNER JOIN `user` ON `logi`.`user_id`=`user`.`id` INNER JOIN `skins` ON `logi`.`skin_id`=`skins`.`id` WHERE `skins`.`price`>2 ORDER BY rand() LIMIT 1";
        $mysql = (new \Connect)->getDbc()->query($sql);
        $assocmydsql = $mysql->fetch_all(MYSQLI_ASSOC);
        foreach($assocmydsql as $a){
            $check = (new \Skin(0,0,0,0,0,0,$a['Container Odds']))->check();
            echo<<<END
<style>
    #skin{$req['slide_i']}:hover .imagess{
        width: 190px;
        height: 180px;
    }
    #skin{$req['slide_i']}:hover .sellorwithdraw{
        visibility: visible;
        opacity: 1;
    }
</style>
<div id="skin{$req['slide_i']}" class="skin_slider" style=" {$check}">
<div class="sellorwithdraw">
<span>{$a['name']}</span>
<span>Wylosowany przez:</span>
<span>{$a['login']}</span>
    </div>
    <div class="mx-auto imagess" style="background-image: url('{$this->gHost()}images/skins/{$a['image']}.png');">

    </div>
 <div class="eprice"><div class="inside">{$a['price']}PLN</div></div>
</div>

<script>

END;
            echo "var i =".json_encode($req['slide_i']).";";
            echo<<<END
    $("#skin"+i).css("display","none");

    $("#skin"+i).fadeIn(1000);


</script>
END;
        }
    }

public function Show(){
  $this->loadTemplate('home','Home');
  }
}
