<?php

function head()
{
    date_default_timezone_set('Europe/Warsaw');
echo<<<END
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="java.js"></script>
  <link rel="icon" href="images/rifle.png">
END;
}

function navigation()
{
    if(@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod'] && isset($_POST['loguot'])){    
    setcookie('zalogowany', null, time() - 3600); 
    setcookie('user', null, time() - 3600); 
    setcookie('email', null, time() - 3600);
    setcookie('checksum', null, time() - 3600);
    setcookie('login_dod', null, time() - 3600); 
    unset($_POST['loguot']);
    header("Location:index.php");
}
echo<<<END
<header>
    <div style="width:80%; display: flex; justify-content: space-between; align-items: center; margin-left:auto; margin-right:auto; align-content: center;">
        <img class="logo" src="images/Skin-King0.jpg" width="26%" style="min-width:120px;" alt="logo" onclick="home()">
        <script>
        var number = Math.floor(Math.random() * 2);

        $(function(){
            $(".logo").attr("src","images/Skin-King"+number+".jpg");
            setInterval(function(){
                if(number==2){
                    number=0;
                }
                else{
                    number=number+1;
                }
                $(".logo").fadeOut(1440, function(){
                    $(".logo").attr('src',"images/Skin-King"+number+".jpg").fadeIn(1440)
                    })
                
            },10000);
        });
        </script>
        <nav>
            <ul class="nav_links">
END;        
if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
    include("connect.php");
    $sql = "SELECT account_balance,level,admin FROM user WHERE login='$_COOKIE[user]'";
    $balance = mysqli_query($dbc,$sql);
    $row = mysqli_fetch_row($balance);

echo<<<end

    <li onclick='settin()' id='account' style="position: relative;
    display: inline-block;">{$_COOKIE['user']}: {$row[0]}PLN
    <div class="dropdown-content">
    <a href="equipment.php">Poziom: {$row[1]}</a>
    <hr class="mx-auto horizontal-line" style="margin-top: 1px; margin-bottom: 9px;">
    <a href="lottery.php">Losowanie</a><br>
    <a href="equipment.php">Ekwipunek</a><br>
    <a href="settings.php">Ustawienia</a><br>
end;
    if($row[2]==true){
        echo "<a href='admin.php'>Administracja</a>";
    }
echo<<<end
    <form method="POST">
        <input type="submit" id="sell" name="loguot"  value="Wyloguj się">
    </form>
    </div>
</li>
    <div style="display:flex; flex-direction:column;">
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
}

function footer()
{
echo<<<END
    <footer>
        <div class="mx-auto w-75 d-flex box">
            <div class="boxo" style="margin-top:160px; width:100%; display: flex">
                <div class="mx-auto in-box1">
                <img class="logo" src="images/Skin-King.jpg" width="100%" style="min-width:120px;" alt="logo">
                </div>
                <div class="mx-auto w-40 d-flex in-box2">
                <div class="s">
                <span class="pan">Skiny</span>
                    <a href="#"> <span class="pod">Ekwipunek</span></a>
                    <a href="#"> <span class="pod">Poziom konta</span></a>
                    <a href="#"> <span class="pod">Doładowanie</span></a>
                
                </div>
                <div class="s">
                <span class="pan">Giveaway</span>
                    <a href="#"> <span class="pod">Regulamin</span></a>
                    <a href="#"> <span class="pod">Zasady</span></a>
                    <a href="#"> <span class="pod">Nagrody</span></a>
          
                
                </div>
                <div class="s"><span class="pan">Pomoc</span>
                    <a href="#"> <span class="pod">Kontakt</span></a>
                    <a href="#"> <span class="pod">Regulamin</span></a>
                    <a href="#"> <span class="pod">Uwagi</span></a>
                
                </div>
                </div>
            </div>
        </div>
    </footer>

    <script>
        
  $(function(){
    if($(window).width() < 850) {
        $(".boxo").css({"flex-direction":"column","margin-top":"100px"});
        $(".in-box2").css("padding-left","0px");
        $(".in-box1").css("width","100%");
    }
    if($(window).width() < 450) {
        $("footer").css("height","auto");
        $(".in-box2").css({"flex-direction":"column","text-align":"center","width":"100%"});
        
    }
    });

    $(window).resize(function() {
        if ($(window).width() < 850) {
            $(".boxo").css({"flex-direction":"column","margin-top":"100px"});
            $(".in-box2").css("padding-left","0px");
            $(".in-box1").css("width","100%");
    }
    if($(window).width() > 450){
        $("footer").css("height","450px");
        $(".in-box2").css({"flex-direction":"row","text-align":"left","width":"40%"});
    }
    if($(window).width() < 450){
        $("footer").css("height","auto");
        $(".in-box2").css({"flex-direction":"column","text-align":"center","width":"100%"});

    }
    if ($(window).width() > 850) {
        $(".boxo").css({"flex-direction":"row","margin-top":"160px"});
        $(".in-box2").css("padding-left","170px");
        $(".in-box1").css("width","25%");
    }
    });
    </script>
END;
}

    define('webkit',' -webkit-box-shadow: inset 0px 0px 17px -3px ');
    define('moz',' -moz-box-shadow: inset 0px 0px 17px -3px ');
    define('box',' box-shadow: inset 0px 0px 17px -3px ');
    define('colorr','#EB4B4B;');
    define('colorp','#EB4BE6;');
    define('colorpur','#9300ff;');
    define('colorb','#4b69ff;');
    define('colorg','#FFD700;');

    function check($odd,$webkit,$moz,$box,$colorr,$colorp,$colorpur,$colorb,$colorg){

        if($odd == "Gold"){
            return  $webkit.$colorg.$moz.$colorg.$box.$colorg;
        }

        if($odd == "Red"){
            return  $webkit.$colorr.$moz.$colorr.$box.$colorr;
        }

        if($odd == "Pink"){
            return $webkit.$colorp.$moz.$colorp.$box.$colorp;
        }

        if($odd == "Purple"){
            return $webkit.$colorpur.$moz.$colorpur.$box.$colorpur;
        }

        if($odd == "Blue"){
            return $webkit.$colorb.$moz.$colorb.$box.$colorb;
        }
    }