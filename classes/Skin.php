<?php
class Skin {
    private $Id,$Name,$Image,$Price,$Type,$State,$ContainerOdd;
    private $webkit = ' -webkit-box-shadow: inset 0px 0px 17px -3px ';
    private $moz = ' -moz-box-shadow: inset 0px 0px 17px -3px ';
    private $box = ' box-shadow: inset 0px 0px 17px -3px ';
    private $colorr = '#EB4B4B;';
    private $colorp = '#EB4BE6;';
    private $colorpur = '#9300ff;';
    private $colorb = '#4b69ff;';
    private $colorg = '#FFD700;';

    public function __construct($Id,$Name,$Image,$Price,$Type,$State,$ContainerOdd) {
        $this->Id = $Id;
        $this->Name = $Name;
        $this->Image = $Image;
        $this->Price = $Price;
        $this->Type = $Type;
        $this->State = $State;
        $this->ContainerOdd = $ContainerOdd;
    }
    public function getSkin($param){
        return $this->$param;
    }
    public function check()
    {
        if ($this->ContainerOdd == "Gold") return $this->webkit . $this->colorg . $this->moz . $this->colorg . $this->box . $this->colorg;
        if ($this->ContainerOdd == "Red") return $this->webkit . $this->colorr . $this->moz . $this->colorr . $this->box . $this->colorr;
        if ($this->ContainerOdd == "Pink") return $this->webkit . $this->colorp . $this->moz . $this->colorp . $this->box . $this->colorp;
        if ($this->ContainerOdd == "Purple") return $this->webkit . $this->colorpur . $this->moz . $this->colorpur . $this->box . $this->colorpur;
        if ($this->ContainerOdd == "Blue") return $this->webkit . $this->colorb . $this->moz . $this->colorb . $this->box . $this->colorb;
    }
}