<?php
include "classes/Signin.php";
class Settings extends Main
{
    public function reqPost($req){
        if(isset($_POST['aprovedgreen']) && $_POST['aprovedgreen']!='') return $this->changeAvatar($req);
        if(isset($_POST['changeaccountdata'])) return $this->changeAccountData($req);
        if(isset($_POST['passwordchange'])) return $this->changePassword($req);
        return $this->toHome();
    }

    public function changeAvatar($req){
        $oldimg = $this->getUser("avatar");
        $fileTmpName = $_FILES['myfile']['tmp_name'];
        $newname = uniqid('');
        $newnamewithuni = $newname.".png";
        $filedestination = "images/avatars/".$newnamewithuni;
        $move = move_uploaded_file($fileTmpName,$filedestination);
        if($move){
            $update_image = "UPDATE `user` SET `avatar`='{$newname}' WHERE `id`={$this->getUser("id")}";
            $update_query = (new \Connect)->getDbc()->query($update_image);
            if($this->getUser('avatar')!="default_image"){
                unlink("images/avatars/{$oldimg}.png");
            }
            header("Location: Settings");
        }
    }

    public function changeAccountData($req){

        if($this->getUser('login') != $req['login']){
            $check = "SELECT `id`,`login` FROM `user` WHERE `login`='{$req['login']}'";
            $check_query = (new \Connect)->getDbc()->query($check);
            $check_security = $check_query->num_rows;
            if($check_security==0){
                $changeaccountlogin = "UPDATE `user` SET `login`='{$req['login']}' WHERE id={$this->getUser("id")}";
                $change_query = (new \Connect)->getDbc()->query($changeaccountlogin);
                if($change_query){
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

        if($this->getUser('email') != $req['email']){
            $emailB = filter_var($req['email'], FILTER_SANITIZE_EMAIL);
            if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==true) || ($emailB==$req['email'])) {
                $check = "SELECT `id`,`email` FROM `user` WHERE `email`='{$req['email']}'";
                $check_query = (new \Connect)->getDbc()->query($check);
                $check_security = $check_query->num_rows;
                if ($check_security == 0) {
                    $changeaccountemail = "UPDATE `user` SET `email`='{$req['email']}' WHERE id={$this->getUser('id')}";
                    $change_query = (new \Connect)->getDbc()->query($changeaccountemail);
                    if ($change_query) {
                        (new \Signin)->set_cookies($req['email']);
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
        return header("Location: Settings");
    }

    public function changePassword($req){
        $oldpass = $req['oldpass'];
        $newpass = $req['newpass'];
        $repeatpass = $req['repeatpass'];
        $all_good = true;
        if($newpass != $repeatpass){
            $all_good = false;
            $_SESSION['e_newpassword'] = "Hasła nie są takie same!";
        }
        if($all_good){
            $check_secur = "SELECT `password` FROM `user` WHERE `id`={$this->getUser("id")}";
            $check_security_query = (new \Connect)->getDbc()->query($check_secur);
            $check_fetch_row = $check_security_query->fetch_row();
            if(password_verify($oldpass,$check_fetch_row[0])){
                $pass_hash = password_hash($newpass, PASSWORD_DEFAULT);
                $change_pass = "UPDATE `user` SET `password`='{$pass_hash}' WHERE id={$this->getUser("id")}";
                $change_pass_query = (new \Connect)->getDbc()->query($change_pass);
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
        header("Location: Settings");
    }

    public function Show(){
        $this->loadTemplate('settings','Settings | '.$this->getUser('login'));
    }
}