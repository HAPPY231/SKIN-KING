<?php
session_start();
date_default_timezone_set('Europe/Warsaw');

if (isset($_POST['login']) && isset($_POST['haslo'])) {
    require_once "connect.php";

    if ($dbc->connect_errno!=0) {
        echo "Error: ".$dbc->connect_errno;
    } else {
        $login = $_POST['login'];
        $haslo = $_POST['haslo'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if ($rezultat = $dbc->query(sprintf("SELECT * FROM user WHERE name='%s'", mysqli_real_escape_string($dbc, $login)))) {
            $ilu_userow = $rezultat->num_rows;
            if ($ilu_userow>0) {
                $wiersz = $rezultat->fetch_assoc();

                if (password_verify($haslo, $wiersz['password'])) {
                    
                    $cps = md5("cossawdawsdodatae", FALSE);
                    setcookie('zalogowany', 1, time()+60*60*24*90); 
            setcookie('user', $wiersz['name'], time()+60*60*24*90); 
            setcookie('email', $wiersz['email'], time()+60*60*24*90); 
            setcookie('login_dod', $cps, time()+60*60*24*90); 
            setcookie('checksum', md5($wiersz['name']).$cps, time()+60*60*24*90);
            unset($_SESSION['blad']);
                    header("Location:index.php");
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

        $dbc->close();
    }
}