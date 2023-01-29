  <?php
class Controller{

  private $parameters;
  private $cmd;

  public function __construct($cmd){
    $this->cmd = explode('/',$cmd);
  }

  public function getObject(){
    if($this->cmd[0]!==''){
        return $this->cmd[0];
    } else{
        return false;
    }
  }
    public function pageRedirect($name,$type){
      header("Location:{$name}");
      if($type==1){die();}
    }

    public function getParameters(){
      $count = count($this->cmd);
      if($count%2!=0 && $count>1){

      for($i=1; $i<count($this->cmd);$i+=2){
        $this->parameters[$this->cmd[$i]]=$this->cmd[$i+1];
      }
      return true;
    }
    else{return false;}
  }

  }


?>
