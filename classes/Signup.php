<?php
class Signup extends Main
{
    public function reqPost($req){
        $dbc = new Connect();
        $all_ok=true;
        $_SESSION['errors_red'] = [];
        $nick = $req['login'];
        if ((strlen($nick)<3) || (strlen($nick)>30))
        {
            $all_ok=false;
            @$_SESSION['e_loginn']="The nickname must have between 3 and 30 characters!";
            $_SESSION['errors_red'][] = 'login';
        }
        if (ctype_alnum($nick)==false)
        {
            $all_ok=false;
            $_SESSION['e_loginn']="Nickname can only consist of letters and numbers";
            $_SESSION['errors_red'][] = 'login';
        }
        //Check the correctness of the email address
        $email = $req['email'];
        $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
        if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
        {
            $all_ok=false;
            $_SESSION['e_emaill']="Enter a valid email address!";
            $_SESSION['errors_red'][] = 'email';
        }
        //Check the correctness of the password
        $pass1 = $req['haslo1'];
        $pass2 = $req['haslo2'];
        if ((strlen($pass1)<8) || (strlen($pass2)>30))
        {
            $all_ok=false;
            $_SESSION['e_pass']="The password must have between 8 and 30 characters!";
            $_SESSION['errors_red'][] = 'haslo1';
        }
        if ($pass1!=$pass2)
        {
            $all_ok=false;
            $_SESSION['e_pass']="The passwords given are not identical!";
            $_SESSION['errors_red'][] = 'haslo1';
            $_SESSION['errors_red'][] = 'haslo2';
        }
        $pass_hash = password_hash($pass1, PASSWORD_DEFAULT);
        //Remember the data you entered
        $_SESSION['e_login'] = $nick;
        $_SESSION['e_email'] = $email;
        $_SESSION['e_pass1'] = $pass1;
        $_SESSION['e_pass2'] = $pass2;
        if (isset($req['regulamin'])){
            $_SESSION['e_regulamin'] = false;
        }
        else{
            $_SESSION['errors_red'][] = 'form-check-label';
            $all_ok=false;
        }
        mysqli_report(MYSQLI_REPORT_STRICT);
        try
        {
            if ($dbc->getDbc()->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno());
            }
            else
            {
                //Does the email already exist?
                $res = $dbc->getDbc()->query("SELECT id FROM user WHERE email='{$email}'");
                if (!$res) throw new Exception($dbc->getDbc()->error);
                $qty_emails = $res->num_rows;
                if($qty_emails>0)
                {
                    $all_ok=false;
                    $_SESSION['errors_red'][] = 'email';
                    $_SESSION['e_emaill']="There is already an account assigned to this email address!";
                }
                //Is the nickname already reserved?
                $res = $dbc->getDbc()->query("SELECT id FROM user WHERE login='{$nick}'");
                if (!$res) throw new Exception($dbc->error);
                $qty_of_nicks = $res->num_rows;
                if($qty_of_nicks>0)
                {
                    $all_ok=false;
                    $_SESSION['e_loginn']="There is already a user with such a nickname! Choose another one.";
                    $_SESSION['errors_red'][] = 'login';
                }
                if ($all_ok==true){
                    //We add the player to the base
                    $data = date("Y-m-d H:i:s");
                    if ($dbc->getDbc()->query("INSERT INTO user VALUES (NULL,'{$nick}','{$pass_hash}','{$email}',100,1,0,'{$data}',0,'default_image')"))
                    {
                        unset($_SESSION['e_login']);
                        unset($_SESSION['e_email']);
                        unset($_SESSION['e_pass1']);
                        unset($_SESSION['e_pass2']);
                        header('Location: Signin');
                        exit();
                    }
                    else
                    {
                        throw new Exception($dbc->getDbc()->error);
                    }
                }else{
                    throw new Exception("No ok");
                }
            }
        }
        catch(Exception $e)
        {
            header('Location: Signup');
        }
    }

    public function Show(){
        $this->loadTemplate('signup','Sign up');
    }
}