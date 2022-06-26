<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    include("controllers/controller.php");
    if (@$_COOKIE['checksum'] != md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
        header("Location:index.php");
    }
    head();
    ?>
    <title>Ustawienia | <?=$_COOKIE['user']?></title>
</head>
<body>
<?php navigation(); ?>
<div class="container">
        <div class="avatar">
            <div class="image">
                <form id="form1" enctype='multipart/form-data' runat="server" method="post" action="web.php">
            <img src="images/avatars/<?=$_SESSION['userr']->get("avatar");?>.png" alt="avatar"
                 title="Avatar"
                 width="300" height="300" id="blah">
                <label class="btn btn-outline-primary" id="blue">
                    Zmień avatar
                    <input type="file" class="account-settings-fileinput" id="imgInp" name="myfile">
                </label>
                <div class="text-light small mt-1" id="extensions">Dozwolone JPG, GIF lub PNG.
                    Maksymalny
                    rozmiar 800K.</div>
                <button type="submit" class="btn btn-outline-success" id="green"
                        name="aprovedgreen" value="check">Potwiedź
                    zmiane avataru</button>
                </form>
            </div>
            <div class="info">

            <h1><?php echo $_SESSION['userr']->get("login").": ".$_SESSION['userr']->get("account_balance")." PLN";
                ?></h1>
            <div class="level">
            <?php echo "Poziom: ".$_SESSION['userr']->get("level");?>
            <progress id="file" max="100" value="<?php echo $_SESSION['userr']->get("percentage");?>"> <?php
                echo $_SESSION['userr']->get("percent");?>% </progress>
            <?php echo $_SESSION['userr']->get("exp")."/".$_SESSION['userr']->get("expmax");?>
            </div>
        </div>
            <script>

                function readURL(input) {
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#blah').attr('src', e.target.result);
                        }

                        reader.readAsDataURL(input.files[0]);
                    }
                }


                $("#imgInp").change(function(){
                    let extension = $("#imgInp").val();
                    let extensionsp =  extension.split('.');


                    if((extensionsp[1]=='png' || extensionsp[1]=='gif' || extensionsp[1]=='jpg')
                        && this.files[0].size<=80000){
                        readURL(this);
                        $("#green").fadeIn(1000);
                        $("#green").show(1000);
                        $("#extensions").attr("style", "color: #babbbc !important");
                    }
                    else{
                        $("#green").fadeOut(1);
                        $("#extensions").attr("style", "color: #b40118 !important");
                    }
                });
            </script>

        </div>

        <div class="infoschanges">
            <h1>Zmień dane konta:</h1>
            <div class="twoforms">
            <div class="emailandotherinfo">
            <form method="POST" autocomplete="off" action="web.php">
                <div class="form-group">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" id="login" name="login"
                           aria-describedby="loginhelp" value="<?=$_SESSION['userr']->get("login");
                           ?>" >
                    <?php

                        if(isset($_SESSION['e_login'])){
                            echo $_SESSION['e_login'];
                            unset($_SESSION['e_login']);
                        }

                    ?>
                </div>
                <div class="form-group">
                    <label for="Email">E-mail</label>
                    <input type="email" class="form-control" id="Email" name="email"
                           aria-describedby="emailHelp"
                           value="<?=$_SESSION['userr']->get("email");?>">
                    <?php

                    if(isset($_SESSION['e_email'])){
                        echo $_SESSION['e_email'];
                        unset($_SESSION['e_email']);
                    }

                    ?>
                </div>
                <button type="submit" name="changeaccountdata" value="change_account_data"
                        class="btn btn-primary">Zmień
                    dane</button>
            </form>
            </div>
                <div class="changepassword">
                    <form method="POST" autocomplete="off" action="web.php">
                        <div class="form-group">
                            <label for="passwordactual">Aktualne hasło:</label>
                            <input type="password" class="form-control" id="passwordactual"
                                   placeholder="Aktualne hasło" name="oldpass" minlength="8"
                                   maxlength="30" required>
                            <?php

                                if(isset($_SESSION['e_oldpassword'])){
                                    echo $_SESSION['e_oldpassword'];
                                    unset($_SESSION['e_oldpassword']);
                                }

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="newpassword">Nowe hasło:</label>
                            <input type="password" class="form-control" id="newpassword"
                                   placeholder="Nowe hasło" name="newpass" minlength="8"
                                   maxlength="30" required>
                            <?php

                            if(isset($_SESSION['e_newpassword'])){
                                echo $_SESSION['e_newpassword'];
                                unset($_SESSION['e_newpassword']);
                            }

                            ?>
                        </div>
                        <div class="form-group">
                            <label for="repeatnewpassword">Powtórz hasło:</label>
                            <input type="password" class="form-control" id="repeatnewpassword"
                                   placeholder="Powtórz hasło" name="repeatpass" minlength="8" maxlength="30" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="passwordchange">Zmień
                            hasło</button>
                    </form>
                </div>

        </div>
        </div>
    </div>
    <script>
        $("div.container").css("background-color","#e8e8e8");
    </script>
    <?=footer();?>
</body>
</html>
<?php

    mysqli_close($dbc);

?>