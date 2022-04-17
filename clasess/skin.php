<?php
class skin {

  private $Name;
  private $Image;
  private $Price;
  private $Type;
  private $State;
  private $ContainerOdd;
  //private $Case_price;

  public function __construct($Name,$Image,$Price,$Type,$State,$ContainerOdd /*,$Case_price */ ) {
      $this->Name = $Name;
      $this->Image = $Image;
      $this->Price = $Price;
      $this->Type = $Type;
      $this->State = $State;
      $this->ContainerOdd = $ContainerOdd;
      //$this->Case_Price = $Case_price;
  }
  public function getName(){
    return $this->Name;
  }
  public function getPrice(){
    return $this->Price;
  }
  public function getContainerOdd(){
    return $this->ContainerOdd;
  }
  public function getImage(){
    return $this->Image;
  }
  // public function getCasePrice(){
  //   return $this->Case_Price;
  // }
}

?>