<?php
    include("controllers/controller.php");
    if (@$_COOKIE['checksum'] != md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
        header("Location:index.php");
    }
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <?php head(); ?>
    <title>Losowanie</title>
</head>
<body>
    <?php navigation(); ?>
    <div class="container">
        <div class="mx-auto w-90 lottery">
        <center><h1>LOSOWANIE</h1></center>
        <div class="mx-auto w-50 text-center draw">
    <?php 

    $dateactual = date("Y-m-d H:i:s");
    $now_timestamp = strtotime($dateactual);
    $date_user = (string)$_SESSION['userr']->get("date");
    $diff_timestamp = $now_timestamp - strtotime($date_user);
    $howmuch = round($diff_timestamp/60);
    $abs = abs($howmuch);
    if($_SESSION['userr']->get("date")<$dateactual){
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
                    user_id: <?php echo json_encode($_SESSION['userr']->get("identity")); ?>,
                    time: <?php echo json_encode($_SESSION['userr']->get("date")); ?>
                },function(data,status){
                    $('div.draw').html(data);
                });
            });
        });
    </script>
</body>
</html>
