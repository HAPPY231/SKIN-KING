<?php

if(@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod'] && isset($_POST['loguot'])){
loguot();
unset($_POST['loguot']);
header("Location:index.php");
}
echo<<<END
<header>
    <div style="width:80%; display: flex; justify-content: space-between; align-items: center; margin-left:auto; margin-right:auto; align-content: center;">
        <img class="logo" src="images/system/Skin-King0.jpg" width="26%" style="min-width:120px;" alt="logo" onclick="home()">
        <script>
           let number = Math.floor((Math.random() * 3) + 0);

            $(function(){
                $(".logo").attr("src","images/system/Skin-King"+number+".jpg");
                setInterval(function(){
                    if(number==2){
                        number=0;
                    }
                    else{
                        number=number+1;
                    }
                    $(".logo").fadeOut(1440, function(){
                        $(".logo").attr('src',"images/system/Skin-King"+number+".jpg").fadeIn(1440)
                    })

                },10000);
            });
        </script>
        <nav>
            <ul class="nav_links">
END;



if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod'] && isset($_SESSION['userr'])) {


echo<<<end

                <li onclick='settin()' id='account'><img 
                src="images/avatars/{$_SESSION['userr']->get("avatar")}.png" 
                alt="avatar" width="38" height="38" 
                style="border-radius: 50%;">&nbsp;{$_COOKIE['user']}: {$_SESSION['userr']->get("account_balance")}PLN
                    <div class="dropdown-content">
                        <a href="equipment.php">Poziom: {$_SESSION['userr']->get("level")}</a>
                        <hr class="mx-auto horizontal-line" style="margin-top: 1px; margin-bottom: 9px;">
                        <a href="lottery.php">Losowanie</a><br>
                        <a href="equipment.php">Ekwipunek</a><br>
                        <a href="settings.php">Ustawienia</a><br>
end;
                        if($_SESSION['userr']->get("admin")==true){
                        echo "<a href='admin.php'>Administracja</a>";
                        }
echo<<<end
                        <form method="POST">
                            <input type="submit" id="sell" name="loguot"  value="Wyloguj się">
                        </form>
                    </div>
                </li>
                <div style="display:flex; flex-direction:column;  transform: translate(120px, 0px);">
    <li id='substraction'>PLN</li>
    <li id='sella'>PLN</li>
    </div>

end;
                }
                else{
                echo "<li onclick='zalog()'>Zaloguj się</li>";
                echo "<li onclick='zarej()'>Zarejestruj się</li>";
                }
echo<<<END

            </ul>
        </nav>
    </div>
</header>
END;