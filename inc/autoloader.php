<?php

spl_autoload_register(function($className){
$classPath = getcwd()."/classes/{$className}.php";
if(file_exists($classPath)){
  include_once($classPath);
}
});



 ?>
