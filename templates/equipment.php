<?php
    $exp = (new \Percentages($this->getUser('level'),$this->getUser('exp')));
?>
<div class="container">
    <div class="mx-auto w-80 accountinfo">
        <h1><?=$this->getUser('login').": ".$this->getUser("account_b")."PLN "
            ?></h1>
        <div class="level">
            <?="Poziom: ".$this->getUser("level");?>
            <progress id="file" max="100" value="<?=$exp->exp("percentage");?>"> <?=$exp->exp("percentage");?>% </progress>
            <?php echo $this->getUser("exp")."/".$exp->exp("expmax");?>
        </div>
    </div>
    <div class='mx-auto pagination'>
        <h3>Your Equipment</h3>
        <?php
        if (isset($_GET['id'])) {
            $pageno = $_GET['id'];
        } else {
            $pageno = 1;
        }
        function getpage($i){
            if (isset($_GET['id'])) {
                if($_GET['id']==$i){
                    return "class='active'";
                }
            }
        }
        $cou = $this->getPages('pages')->num_rows;
        if($cou>0){
            $rows_per_page = 20;
            $lastpage = ceil($cou/$rows_per_page);
            if ($pageno > $lastpage) {
                $pageno = $lastpage;
            }
            if ($pageno < 1) {
                $pageno = 1;
            }
            echo "<a href='../Equipment/1'>&laquo;</a>";
            for($i=1; $i<=$lastpage; $i++){
                $check=getpage($i);
                echo "<a href='../Equipment/{$i}'{$check}>{$i}</a>";
            }
            echo "<a href='../Equipment/{$lastpage}'>&raquo;</a>";
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;

            $all = 0;
            $sqlall = "SELECT `skins`.`price` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `user_id`={$this->getUser('id')}";
            $myrowall = (new \Connect)->getDbc()->query($sqlall);
            while($row = $myrowall->fetch_row()){
                $all=$all+$row[0];
            }
            echo "<button id='sellall' onclick='sellall()'>Sell All worth {$all} PLN</button>";
        }
        ?>
    </div>
    </center>
    <div class="skinbox">
        <?php
        if($cou>0){
            $sql = "SELECT `user_skins`.*,`skins`.`name`,`skins`.`image`,`skins`.`type`,`skins`.`price`,`skins`.`Container Odds`,`skins`.`state` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `user_id`={$this->getUser("id")} ORDER BY `skins`.`price` DESC {$limit}";
            $res = (new \Connect)->getDbc()->query($sql);
            $skins = mysqli_fetch_all($res, MYSQLI_ASSOC);
            foreach($skins as $skin){
                $s = new Skin($skin['id'],$skin['name'],$skin['image'],$skin['price'],$skin['type'],$skin['state'],$skin['Container Odds']);
echo<<<END
                    <div class="skin" style="width: 250px; height: 250px; margin-top: 20px; 
                    margin-left: 20px; text-align: center; display: flex; flex-direction: row; 
                    flex-wrap: wrap; justify-content: center; {$s->check()}">
                        <div class="sellorwithdraw">
                        <span style="color: #fff;">{$s->getSkin('Name')}</span>
                                <button id="sell" onclick="myf({$skin['id']})">Sprzedaj</button>
                            </div>
                            <div class="imagess" style="background-image: url('{$this->gHost()}images/skins/{$s->getSkin('Image')}.png');">
                            </div>
                         <div class="eprice"><div class="inside">{$s->getSkin('Price')}PLN</div>
                         </div>
                    </div>
END;
            }

        }
        else{
            echo "You don't have any skins!";
        }
        ?>
    </div>
</div>
<script>
    $(function(){
        $("body").css("background-image","repeat");
        $("div.container").css("background-color","#E8E8E8");
    });

    function sellall(){
        $.post("Equipment",{
            equall: 'all',
        },function(data,status){
            $('div.accountinfo').append(data);
            window.location.reload();
        });
    }

    function myf(id){
        $.post("Equipment",{
            tran_id: id,
        },function(data,status){
            $('div.accountinfo').append(data);
            window.location.reload();
        });
    }
</script>