<?php
    session_start();
    include("connect.php");
    if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
        $users = "SELECT * FROM user WHERE login='$_COOKIE[user]'";
        $get = mysqli_query($dbc,$users);
        $user = mysqli_fetch_row($get);
        if($user[8]!=1){
            header("Location:index.php");
        }
    }
    else{
        header("Location:index.php");
    }
    $now = strtotime(time()); // or your date as well
    $your_date = strtotime("19 12");   
    echo $your_date;
    $datediff = $now - $your_date;
    $dataPoints = array(
        array("x" => 1483381800000 , "y" => 650),
        array("x" => 1483468200000 , "y" => 700),
        array("x" => 1483554600000 , "y" => 710),
        array("x" => 1483641000000 , "y" => 658),
        array("x" => 1483727400000 , "y" => 734),
        array("x" => 1483813800000 , "y" => 963),
        array("x" => 1483900200000 , "y" => 847),
        array("x" => 1483986600000 , "y" => 853),
        array("x" => 1484073000000 , "y" => 869),
        array("x" => 1484159400000 , "y" => 943),
        array("x" => 1484245800000 , "y" => 970),
        array("x" => 1484332200000 , "y" => 869),
        array("x" => 1484418600000 , "y" => 890),
        array("x" => 1484505000000 , "y" => 930),
        array("x" => 1262300400000 , "y" => 1000)
     );
     
    
  
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("include.php"); head(); ?>
    <title>Admin</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>
<body>
    <?php navigation(); ?>
    <div class="containera">
    <div id="myfirstchart" style="height: 250px;"></div>
    </div>
    <?php footer(); ?>
    <script>
    $("div.containera").css({"width":"100%","background-color":"#fff","box-shadow":"inset 0px 0px 25px -6px rgba(66, 68, 90, 1)"});
    </script>
</body>
</html>
