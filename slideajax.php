<?php 
include("connect.php");
include("include.php");
 $sql = "SELECT `user_skins`.`id`,`user_skins`.`user_id`,`user_skins`.`skin_id`,`user`.`login`,`skins`.`name`,`skins`.`image`,`skins`.`type`,`skins`.`price`,`skins`.`Container Odds` FROM `user_skins` INNER JOIN `user` ON `user_skins`.`user_id`=`user`.`id` INNER JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `skins`.`price`>2 ORDER BY rand() LIMIT 1";
 $mysql = mysqli_query($dbc, $sql);
 $assocmydsql = mysqli_fetch_all($mysql,MYSQLI_ASSOC);
 foreach($assocmydsql as $a){
    $check = check($a['Container Odds'],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
echo<<<END
<div class="skin" style="width: 250px; height: 250px; min-width:250px;min-height:250px; margin-top: 20px; margin-bottom: 20px;margin-left: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; background-color:#fff; {$check}">
<div class="sellorwithdraw">
<span style="color: #fff;">{$a['name']}</span>
<span style="color: #fff;">Wylosowany przez:</span>
<span style="color: #fff;">{$a['login']}</span>
    </div>
    <div class="imagess" style="background-image: url('skins/{$a['image']}.png');">
   
    </div>
 <div class="eprice"><div class="inside">{$a['price']}PLN</div></div>
</div>
END;
 }