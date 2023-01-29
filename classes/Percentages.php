<?php

class Percentages
{
    private $percentage,$expmax;

    public function __construct($level,$exp){
        $this->expmax = ($level*100)+200;
        $count1 =  $exp/$this->expmax;
        $count2 = $count1 * 100;
        $this->percentage = number_format($count2, 0);
    }
    public function exp($param){
        return $this->$param;
    }
}