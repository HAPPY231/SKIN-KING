<?php

date_default_timezone_set('Europe/Warsaw');


if(!isset($_POST['login']) && !isset($_POST['haslo']) && !isset($_POST['aprovedgreen']) && !isset
    ($_POST['changeaccountdata']) && !isset($_POST['passwordchange'])){
    header('Location:index.php');

}

if (isset($_POST['login']) && isset($_POST['haslo'])) {
    include("connect.php");

    if ($dbc->connect_errno!=0) {
        echo "Error: ".$dbc->connect_errno;
    } else {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if ($rezultat = $dbc->query(sprintf("SELECT * FROM user WHERE login='%s'", mysqli_real_escape_string($dbc, $login)))) {
            $ilu_userow = $rezultat->num_rows;
            if ($ilu_userow>0) {
                $wiersz = $rezultat->fetch_assoc();

                if (password_verify($haslo, $wiersz['password'])) {
                    include("clasess/userr.php");
                    session_start();

                    $_SESSION['userr'] = new userr($wiersz['login'],$wiersz['account_balance'],
                        $wiersz['level'],$wiersz['email'], $wiersz['avatar'],
                        $wiersz['experience'], $wiersz['id'],$wiersz['admin'],$wiersz['date']);
                    $_SESSION['userr']->get("identify");

                    set_cookies($wiersz['login']);

                    unset($_SESSION['blad']);
                    header("Location: index.php");
                } else {
                    $_SESSION['blad'] = "<script>$(function(){ $('#loign').css({'border-color':'#F90716','border-weight':'1px','border-style':'solid'}); $('#haslo').css({'border-color':'#F90716','border-weight':'1px','border-style':'solid'});});
                </script><span style='color:red'>Nieprawidłowy login lub hasło!</span>";
                header('Location: logowanie.php');
                }
            } else {
                $_SESSION['blad'] = "<script>$(function(){ $('#loign').css({'border-color':'#F90716','border-weight':'1px','border-style':'solid'}); $('#haslo').css({'border-color':'#F90716','border-weight':'1px','border-style':'solid'});});
                </script><span style='color:red'>Nieprawidłowy login lub hasło!</span>";
                header('Location: logowanie.php');
            }
        }

    }
    $dbc->close();
}

if(isset($_POST['aprovedgreen']) && $_POST['aprovedgreen']!=''){
    include("controllers/controller.php");

    session_start();

    $_POST['aprovedgreen']='';
    unset($_POST['aprovedgreen']);

    $oldimg = $_SESSION['userr']->get("avatar");
    $fileTmpName = $_FILES['myfile']['tmp_name'];
    $newname = uniqid('');
    $newnamewithuni = $newname.".png";
    $filedestination = "images/avatars/".$newnamewithuni;
    $move = move_uploaded_file($fileTmpName,$filedestination);
    if($move){
        $update_image = "UPDATE `user` SET `avatar`='{$newname}' WHERE `id`={$_SESSION['userr']->get("identity")}";
        $update_query = mysqli_query($dbc,$update_image);
        $_SESSION['userr']->change_property("avatar","$newname","change");

        if($_SESSION['userr']->get("avatar")!="default_image"){
            unlink("images/avatars/{$oldimg}.png");

        }
        header("Location: settings.php");
    }
    $dbc->close();
}

if(isset($_POST['changeaccountdata'])){
    unset($_POST['changeaccountdata']);
    include("controllers/controller.php");



    if($_SESSION['userr']->get("login") != $_POST['login']){
        $check = "SELECT `id`,`login` FROM `user` WHERE `login`='{$_POST['login']}'";
        $check_query = mysqli_query($dbc,$check);
        $check_security = $check_query->num_rows;
        if($check_security == 0){
            $changeaccountlogin = "UPDATE `user` SET `login`='{$_POST['login']}' WHERE id={$_SESSION['userr']->get("identity")}";
            $change_query = mysqli_query($dbc,$changeaccountlogin);
            if($change_query){
                $_SESSION['userr']->change_property("login",$_POST['login'],"change");
                set_cookies($_POST['login']);
                $_SESSION['e_login'] = "Zmieniłeś swój login!";
            }
            else{
                $_SESSION['e_login'] = "Próba zmienienia loginu nie powiodła się! Spróbuj ponownie później.";
            }
        }
        else{
            $_SESSION['e_login'] = "Istnieje już użytkownik o podanym loginie!";

        }



    }

    if($_SESSION['userr']->get("email") != $_POST['email']){
        $emailB = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==true) || ($emailB==$_POST['email'])) {

            $check = "SELECT `id`,`email` FROM `user` WHERE `email`='{$_POST['email']}'";
            $check_query = mysqli_query($dbc, $check);
            $check_security = $check_query->num_rows;
            if ($check_security == 0) {
                $changeaccountemail = "UPDATE `user` SET `email`='{$_POST['email']}' WHERE
     id={$_SESSION['userr']->get("identity")}";
                $change_query = mysqli_query($dbc, $changeaccountemail);
                if ($change_query) {
                    $_SESSION['userr']->change_property("email", $_POST['email'], "change");
                    $_SESSION['e_email'] = "Zmieniłeś swój e-mail";
                } else {
                    $_SESSION['e_mail'] = "Próba zmienienia mailu nie powiodła się! Spróbuj ponownie później.";
                }
            } else {
                $_SESSION['e_email'] = "Istnieje już użytkownik o podanym mailu!";
            }
        }
        else{
            $_SESSION['e_email'] = "Nie poprawny adres email!";
        }

    }
    header("Location: settings.php");
    $dbc->close();
}

if(isset($_POST['passwordchange'])){
    unset($_POST['passwordchange']);
    include("controllers/controller.php");

    $oldpass = $_POST['oldpass'];
    $newpass = $_POST['newpass'];
    $repeatpass = $_POST['repeatpass'];
    $wszystko_git = true;

    if($newpass != $repeatpass){
        $wszystko_git = false;
        $_SESSION['e_newpassword'] = "Hasła nie są takie same!";
    }

    if($wszystko_git==true){
        $check_secur = "SELECT `password` FROM `user` WHERE `id`={$_SESSION['userr']->get("identity")}";
        $check_security_query = mysqli_query($dbc,$check_secur);
        $check_fetch_row = mysqli_fetch_row($check_security_query);
        if(password_verify($oldpass,$check_fetch_row[0])){
            $pass_hash = password_hash($newpass, PASSWORD_DEFAULT);
            $change_pass = "UPDATE `user` SET `password`='{$pass_hash}' WHERE id={$_SESSION['userr']->get("identity")}";
            $change_pass_query = mysqli_query($dbc,$change_pass);
            if($change_pass_query){
                $_SESSION['e_oldpassword'] = "Zmieniłeś hasło!";
            }
            else{
                $_SESSION['e_oldpassword'] = "Nie udało się zmienić hasła! Spróbuj ponownie później!";
            }
        }
        else{
            $_SESSION['e_oldpassword'] = "Podałeś błędne hasło!";
        }
    }
    header("Location: settings.php");
    $dbc->close();
}


function set_cookies($user){
    $cps = md5("cossawdawsdodatae", FALSE);
    setcookie('user', $user, time()+60*60*24*90);
    setcookie('login_dod', $cps, time()+60*60*24*90);
    setcookie('checksum', md5($user).$cps, time()+60*60*24*90);
}