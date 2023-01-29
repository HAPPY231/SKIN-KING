<?php
class Connect
{
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $db = "sking_king";
    private $dbc;
    public function __construct(){
        $this->dbc = new mysqli($this->host,$this->user,$this->password,$this->db);
    }
    public function getDbc(){
        return $this->dbc;
    }
}