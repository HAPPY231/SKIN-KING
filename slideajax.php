<?php 
include("connect.php");
include("include.php");
if(!isset($_POST['slide_i'])){
    header("Location: index.php");
}

 $sql = "SELECT `logi`.`id`,`logi`.`user_id`,`logi`.`skin_id`,`user`.`login`,`skins`.`name`,`skins`.`image`,`skins`.`type`,`skins`.`price`,`skins`.`Container Odds` FROM `logi` INNER JOIN `user` ON `logi`.`user_id`=`user`.`id` INNER JOIN `skins` ON `logi`.`skin_id`=`skins`.`id` WHERE `skins`.`price`>2 ORDER BY rand() LIMIT 1";
 $mysql = mysqli_query($dbc, $sql);
 $assocmydsql = mysqli_fetch_all($mysql,MYSQLI_ASSOC);
 foreach($assocmydsql as $a){
    $check = check($a['Container Odds'],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
echo<<<END
<style>
    #skin{$_POST['slide_i']}:hover .imagess{
        width: 190px;
        height: 180px;
    } 
    #skin{$_POST['slide_i']}:hover .sellorwithdraw{
        visibility: visible;
        opacity: 1;
    }
</style>
<div id="skin{$_POST['slide_i']}" class="skin_slider" style=" {$check}">
<div class="sellorwithdraw">
<span>{$a['name']}</span>
<span>Wylosowany przez:</span>
<span>{$a['login']}</span>
    </div>
    <div class="mx-auto imagess" style="background-image: url('skins/{$a['image']}.png');">
   
    </div>
 <div class="eprice"><div class="inside">{$a['price']}PLN</div></div>
</div>

<script>
 
END;
echo "var i =".json_encode($_POST['slide_i']).";";
echo<<<END
    $("#skin"+i).css("display","none");

    $("#skin"+i).fadeIn(1000);
  

</script>
END;

unset($_POST['slide_i']);

 }