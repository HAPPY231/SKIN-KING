<header>
    <div style="width:80%; display: flex; justify-content: space-between; align-items: center; margin-left:auto; margin-right:auto; align-content: center;">
        <img class="logo" src="<?=$this->gHost()?>images/system/Skin-King1.jpg" width="26%" style="min-width:120px;"
             alt="logo" onclick="href('Home')">
        <script>
           let number = Math.floor((Math.random() * 3) + 0);

            $(function(){
                $(".logo").attr("src","<?=$this->gHost()?>images/system/Skin-King"+number+".jpg");
                setInterval(function(){
                    if(number==2){
                        number=0;
                    }
                    else{
                        number=number+1;
                    }
                    $(".logo").fadeOut(1440, function(){
                        $(".logo").attr('src',"<?=$this->gHost()?>images/system/Skin-King"+number+".jpg").fadeIn(1440)
                    })

                },10000);
            });
        </script>
        <nav>
            <ul class="nav_links">
                <?php
                if($this->getUser('id')){
echo<<<end
                <li id='account'>
                    <img src="{$this->gHost()}images/avatars/{$this->getUser("avatar")}.png" 
                    alt="avatar" 
                    width="38" height="38" style="border-radius: 50%;">&nbsp;{$this->getUser("login")}: {$this->getUser("account_b")}PLN
                    <div class="dropdown-content">
                        <a href="Equipment">Level: {$this->getUser("level")}</a>
                        <hr class="mx-auto horizontal-line" style="margin-top: 1px; margin-bottom: 9px;">
                        <a href="{$this->gHost()}Lottery">Lottery</a><br>
                        <a href="{$this->gHost()}Equipment">Equipment</a><br>
                        <a href="{$this->gHost()}Settings">Settings</a><br>
end;
                    if($this->getUser("is_admin")){
                        echo "<a href='{$this->gHost()}Admin'>Admin Panel</a>";
                    }
echo<<<end
                        <form method="POST">
                            <input type="submit" id="sell" name="logout"  value="Log Out" />
                        </form>
                    </div>
                </li>
                <div style="display:flex; flex-direction:column;  transform: translate(120px, 0px);">
                    <li id='substraction'>PLN</li>
                    <li id='sella'>PLN</li>
                </div>

end;
                }else{
echo<<<end
                <li><a href="{$this->gHost()}Signin">Sign in</a></li>
                <li><a href="{$this->gHost()}Signup">Sign up</a></li>
end;
                }
                ?>

            </ul>
        </nav>
    </div>
</header>
