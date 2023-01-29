<?php
class Env
{
    private $host = 'http://localhost/SKIN-KING-OOP/';

    public function getEnv($variable){
        return $this->$variable;
    }
}