<?php
class Signin extends Main{
    public function reqPost($req){
        $this->login($req);
    }

    public function login($req){
        $dbc = new Connect();
        if ($dbc->getDbc()->connect_errno!=0) {
            echo "Error: ".$dbc->getDbc()->connect_errno;
        } else {
            $login = $req['login'];
            $pass = $req['pass'];
            $login = htmlentities($login, ENT_QUOTES, "UTF-8");
            $html = "<script>$(function(){ $('#loign').css({'border-color':'#F90716','border-weight':'1px','border-style':'solid'}); $('#haslo').css({'border-color':'#F90716','border-weight':'1px','border-style':'solid'});});
                </script><span style='color:red'>Incorrect login or password!</span>";
            if ($res = $dbc->getDbc()->query(sprintf("SELECT * FROM user WHERE login='%s'",
                mysqli_real_escape_string($dbc->getDbc(), $login)))) {
                $qty_of_users = $res->num_rows;
                if ($qty_of_users>0) {
                    $row = $res->fetch_assoc();
                    if (password_verify($pass, $row['password'])) {
                        session_start();
                        $this->set_cookies($row['email']);
                        unset($_SESSION['error']);
                        header("Location: Home");
                    } else {
                        $_SESSION['error'] = $html;
                        header('Location: Signin');
                    }
                } else {
                    $_SESSION['error'] = $html;
                    header('Location: Signin');
                }
            }
        }
    }

    public function set_cookies($email){
        $cps = md5("cossawdawsdodatae", FALSE);
        setcookie('email', $email, time()+60*60*24*90);
        setcookie('login_dod', $cps, time()+60*60*24*90);
        setcookie('checksum', md5($email).$cps, time()+60*60*24*90);
    }

    public function Show(){
        $this->loadTemplate('signin','Sign in');
    }
}