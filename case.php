<?php

include("controllers/controller.php");

$_SESSION['case'] = $_GET['case_id'];


?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    
    head();
    
    $sql = "SELECT * FROM cases WHERE id={$_SESSION['case']}";
    $case = mysqli_query($dbc,$sql);
    $checkforsecure = $case->num_rows;
    if($checkforsecure<=0){
        header("Location:index.php");
        exit();
    }
    $row = mysqli_fetch_row($case)

    ?>
    <title>SKIN-KING | <?php echo $row[1]; ?></title>

</head>
<body>
    <?php navigation(); ?>
    <div class="container">
       
        <div class="mx-auto keys">
            <div class="key">
                <img src="cases/<?php echo $row[2]; ?>.png" alt="<?php echo $row[1] ?>">
            </div>
            <hr class="perpendicular-line">
            <div class="open">
                <span style="font-family: Montserrat,sans-serif; color: #4ead78; font-size: 35px; text-transform: capitalize; font-weight: 800; margin: 0 0 25px;"><?php echo $row[1]; ?></span>

                <span>Wartość skrzynki: <?php echo $row[3]; ?> PLN</span>
                <span>Doświadczenie ze skrzynki: <?php echo $row[4]; ?> EXP</span>
                <br>
<?php
if ((@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) &&
    $_SESSION['userr']->get("account_balance")>=$row[3]) {
echo<<<END
                <button id="open">
                        Otwórz
                </button>
END;
}
else if((@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) && $_SESSION['userr']->get("account_balance")<$row[3]){
    echo "<a href='lottery.php'>Doładuj konto!</a>";
}
else{echo "<a href='logowanie.php'>Zaloguj się aby otworzyć tą skrzynkę!</a>";}
?>

            </div>
<?php

    if(isset($_SESSION['skin_sell'])){

echo "<script>";
echo "var skin_price =".json_encode($_SESSION['skin_sell']).";";
echo<<<end
    
    $('#sella').html("+"+skin_price+"PLN"); 

        $('#sella').css({'opacity':'1','transform':'translate(0px,-5px)'}); 
        setTimeout(function(){
            $('#sella').css({'opacity':'0','transform':'translate(0px,-50px)'}); 
        },2000);
    
</script>
end;
unset($_SESSION['skin_sell']);
    }

?>
    <script>
        $(function(){
             
            $('button#open').click(function(){
                $('div.keys').empty();

                $.post("open.php",{
                    case_id: <?php echo json_encode($row[0]); ?>,
                    case_value: <?php echo json_encode($row[3]); ?>,
                    user_id: <?php echo json_encode($_SESSION['userr']->get("identity")); ?>
                },function(data,status){
                    $('div.keys').html(data);
                });
            });

            
        });

            

    </script>
            </div>
       
            <div class="mx-auto skins">
                <hr class="mx-auto horizontal-line">
                <div class="skinbox">
                <?php
                $skins = "SELECT * FROM `skins_in_cases`  right join `skins` on `skins_in_cases`.`skin_id`=`skins`.`id` WHERE `skins_in_cases`.`case_id`={$row[0]} ORDER BY `skins`.`price` DESC";
                $daw = mysqli_query($dbc, $skins);
                $all = mysqli_fetch_all($daw,MYSQLI_ASSOC);
                foreach($all as $case_skin){


                    $check = check($case_skin['Container Odds'],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
echo<<<END

                        <div class="skin" style=" {$check}">
                            <div class="image" style=" background-image: url('skins/{$case_skin['image']}.png');">
                             <span>{$case_skin['name']}<br>
                             
                              {$case_skin['price']}PLN</span>
                            </div>
                        </div>
END;
                }
                ?>
                </div>
            </div>
        </div>
    </div>
    <?php
        footer();
    ?>
</body>
</html>