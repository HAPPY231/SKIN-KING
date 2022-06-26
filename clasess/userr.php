<?php
class userr{
    private $identity,$login,$account_balance,$level,$email,$avatar,$exp,$expmax,$percentage,$admin,$date;

    public function __construct($login,$account_balance,$level,$email,$avatar,$exp,$identity,$admin,$date){
        $this->login = $login;
        $this->account_balance = $account_balance;
        $this->level = $level;
        $this->email = $email;
        $this->avatar = $avatar;
        $this->admin = $admin;

        $this->exp = $exp;
        $this->expmax = ($this->level*100)+200;
        $count1 =  $this->exp  / $this->expmax;
        $count2 = $count1 * 100;
        $this->percentage = number_format($count2, 0);
        $this->identity = $identity;
        $this->date = (string)$date;
    }
    //get
    public function get($property){
        return $this->$property;
    }
    //change
    public function change_property($property,$data,$action){
        if($action == "add"){
            $this->$property = $this->$property + $data;
        }
        else if($action == "subtraction"){
            $this->$property = $this->$property - $data;
        }
        else if($action == "change"){
            $this->$property = $data;
        }
    }
}