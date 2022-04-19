<?php
    session_start();
    include("connect.php");
    if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
        $users = "SELECT * FROM user WHERE login='$_COOKIE[user]'";
        $get = mysqli_query($dbc,$users);
        $user = mysqli_fetch_row($get);
    }
    else{
        header("Location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("include.php"); head(); ?>
    <title>Losowanie</title>
</head>
<body>
    <?php navigation(); ?>
    <div class="container">
        <div class="mx-auto w-90 lottery">
        <center><h1>LOSOWANIE</h1></center>
        <div class="mx-auto w-50 text-center draw">
    <?php 
    
    //date_default_timezone_set('Europe/Warsaw');
    //$date=date_create(date("Y-m-d H:i:s"));
    //date_modify($date,"+30 minutes");
    //$dataf = date_format($date,"Y-m-d H:i:s")."<br>";
    // echo $dataf;
    // echo $user[7]."<br>";
    // echo date("Y-m-d H:i:s")."<br>";
    $dateactual = date("Y-m-d H:i:s");
    $now_timestamp = strtotime($dateactual);
    $diff_timestamp = $now_timestamp - strtotime($user[7]);
    $howmuch = round($diff_timestamp/60);
    $abs = abs($howmuch);
    if($user[7]<$dateactual){
        echo "<button id='draw'>Losuj</button>";
    }
    else{
        echo "Kolejna możliwość losowania za ".$abs." minut";
    }
    ?></div>
    </div>
    </div>
    <?php footer(); ?>
    <script>
         $(function(){
            $("div.container").css({"background-color":"rgb(232 232 232)"});

            $('#draw').click(function(){
                $.post("draw.php",{
                    user_id: <?php echo json_encode($user[0]); ?>,
                    time: <?php echo json_encode($user[7]); ?>
                },function(data,status){
                    $('div.draw').html(data);
                });
            });
        });
    </script>
</body>
</html>
