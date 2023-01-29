<div class="container">
    <div class="mx-auto keys">
        <div class="key">
            <img src="<?=$this->gHost()?>images/cases/<?=$this->case_i('image')?>.png" alt="<?=$this->case_i('name')?>">
        </div>
        <hr class="perpendicular-line">
        <div class="open">
            <span style="font-family: Montserrat,sans-serif; color: #4ead78; font-size: 35px;
            text-transform: capitalize; font-weight: 800; margin: 0 0 25px;"><?=$this->case_i('name')?></span>

            <span>Wartość skrzynki: <?=$this->case_i('price')?> PLN</span>
            <span>Doświadczenie ze skrzynki: <?=$this->case_i('experience')?> EXP</span>
            <br>
            <?php
            if ($this->getUser('id') && $this->getUser('account_b')>=$this->case_i('price')) {
                echo '<button id="open">Open</button>';
            }
            else if($this->getUser('id') && $this->getUser('account_b')<$this->case_i('price')) {
                echo "<a href='Lottery'>Add credit to your account!</a>";
            }
            else{echo "<a href='Signin'>Log in to open this box!</a>";}
            ?>
        </div>
        <?php
        if(isset($_SESSION['skin_sell'])){
            echo "<script>";
            echo "var skin_price =".json_encode($_SESSION['skin_sell']).";";
            echo<<<end
    
    $('#sella').html("+"+skin_price+"PLN"); 

        $('#sella').css({'opacity':'1','transform':'translate(0px,-5px)'}); 
        setTimeout(function(){
            $('#sella').css({'opacity':'0','transform':'translate(0px,-50px)'}); 
        },2000);
    
</script>
end;
            unset($_SESSION['skin_sell']);
        }

        ?>
        <script>
            $(function(){

                $('button#open').click(function(){
                    $('div.keys').empty();

                    $.post("Casee",{
                        case_id: <?=json_encode($this->case_i('id'))?>,
                        case_value: <?=json_encode($this->case_i('price'))?>,
                        user_id: <?=json_encode($this->getUser('id'))?>
                    },function(data,status){
                        $('div.keys').html(data);
                    });
                });
            });
        </script>
    </div>
    <div class="mx-auto skins">
        <hr class="mx-auto horizontal-line">
        <div class="skinbox">
            <?php
            foreach($this->get_skins() as $case_skin){
                $skin = (new \Skin($case_skin['id'],$case_skin['name'],$case_skin['image'],
                    $case_skin['price'],$case_skin['type'],$case_skin['state'],$case_skin['Container Odds']));
                $check = $skin->check($case_skin['Container Odds']);
                echo<<<END

                        <div class="skin" style="{$check} ">
                            <div class="image" style=" background-image: url('{$this->gHost()}images/skins/{$case_skin['image']}.png');">
                             <span>{$case_skin['name']}<br>
                             
                              {$case_skin['price']}PLN</span>
                            </div>
                        </div>
END;
            }
            ?>
        </div>
    </div>
</div>
</div>
