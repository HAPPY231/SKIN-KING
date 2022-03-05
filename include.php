<?php

function head()
{
echo<<<END
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <link rel="stylesheet" href="style.css">
  <script type="text/javascript" src="java.js"></script>
END;
}

function navigation()
{
echo<<<END
<header>
    <div style="width:80%; display: flex; justify-content: space-between; align-items: center; margin-left:auto; margin-right:auto; background-color: #fff; align-content: center;">
        <img class="logo" src="images/Skin-King.jpg" width="26%" style="min-width:120px;" alt="logo" onclick="home()">
        <nav>
            <ul class="nav_links">
END;        
if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
    include("connect.php");
    $sql = "SELECT account_balance,level FROM user WHERE name='$_COOKIE[user]'";
    $balance = mysqli_query($dbc,$sql);
    $row = mysqli_fetch_row($balance);

echo<<<end

    <li onclick='settin()' id='account' style="position: relative;
    display: inline-block;">{$_COOKIE['user']}: {$row[0]}PLN
    <div class="dropdown-content">
    <a href="equipment.php">Poziom: {$row[1]}</a>
    <hr class="mx-auto horizontal-line" style="margin-top: 1px; margin-bottom: 9px;">
    <a href="equipment.php">Ekwipunek</a><br>
    <a href="settings.php">Ustawienia</a>
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
            <div style="margin-top:160px; width:100%; display: flex">
                <div class="mx-auto in-box1">
                <img class="logo" src="images/Skin-King.jpg" width="100%" style="min-width:120px;" alt="logo">
                </div>
                <div class="mx-auto w-40 d-flex in-box2">
                <div class="s">
                <span class="pan">Skiny</span>
                <a href="#"> <span class="pod">Mniej</span></a>
                <a href="#"> <span class="pod">Mniej</span></a>
                <a href="#"> <span class="pod">Mniej</span></a>
                
                </div>
                <div class="s">
                <span class="pan">Giveaway</span>
                <a href="#"> <span class="pod">Regulamin</span></a>
                <a href="#"> <span class="pod">Mniej</span></a>
                <a href="#"> <span class="pod">Mniej</span></a>
          
                
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
END;
}