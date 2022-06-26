<?php

function head()
{
    include("html_structure/head.php");
}

function navigation()
{
    include("html_structure/navigation.php");
}

function footer()
{
    include("html_structure/footer.php");
}

    define('webkit',' -webkit-box-shadow: inset 0px 0px 17px -3px ');
    define('moz',' -moz-box-shadow: inset 0px 0px 17px -3px ');
    define('box',' box-shadow: inset 0px 0px 17px -3px ');
    define('colorr','#EB4B4B;');
    define('colorp','#EB4BE6;');
    define('colorpur','#9300ff;');
    define('colorb','#4b69ff;');
    define('colorg','#FFD700;');

    function check($odd,$webkit,$moz,$box,$colorr,$colorp,$colorpur,$colorb,$colorg){

        if($odd == "Gold"){
            return  $webkit.$colorg.$moz.$colorg.$box.$colorg;
        }

        if($odd == "Red"){
            return  $webkit.$colorr.$moz.$colorr.$box.$colorr;
        }

        if($odd == "Pink"){
            return $webkit.$colorp.$moz.$colorp.$box.$colorp;
        }

        if($odd == "Purple"){
            return $webkit.$colorpur.$moz.$colorpur.$box.$colorpur;
        }

        if($odd == "Blue"){
            return $webkit.$colorb.$moz.$colorb.$box.$colorb;
        }
    }
function loguot(){
    setcookie('user', null, time() - 3600);
    setcookie('email', null, time() - 3600);
    setcookie('checksum', null, time() - 3600);
    setcookie('login_dod', null, time() - 3600);
    empty($_SESSION['user']);
    unset($_SESSION['user']);
}