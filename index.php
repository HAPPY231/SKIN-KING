<?php
    session_start();
?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("include.php"); head(); ?>
    <title>SKIN-KING</title>
</head>
<body>
    <?php navigation(); ?>
    
    <div style="overflow: hidden;height:500px;" ><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="width: 100%;"><path d="M0.00,49.98 C149.99,150.00 271.49,-49.98 500.00,49.98 L500.00,0.00 L0.00,0.00 Z" style="stroke: none; fill: #fff;"></path></svg></div>
    <!-- <center>
    <div id="comslider_in_point_2376097" style="margin-top: -730px;"></div><script type="text/javascript">var oCOMScript2376097=document.createElement('script');oCOMScript2376097.src="https://commondatastorage.googleapis.com/comslider/target/users/1645778981x5c1b7dcd9d756819738f05c3068ce758/comslider.js?timestamp=1645828081&ct="+Date.now();oCOMScript2376097.type='text/javascript';document.getElementsByTagName("head").item(0).appendChild(oCOMScript2376097);</script>
</center> -->

    <div class="container">
        
        <div class="cases">
<?php
            include("connect.php");
            $sql = "SELECT * FROM cases";
            $res = mysqli_query($dbc,$sql);
            $cases = mysqli_fetch_all($res, MYSQLI_ASSOC);
            foreach($cases as $case){
echo<<<END
                <div class="case" onclick="cases({$case['id']})">
                    <div class="mx-auto image"  style="width: 250px; height:250px; background-image: url('cases/{$case['image']}.png'); background-repeat: no-repeat;  background-size: 100% 100%;">
                    <div class="price"><div class="inside">{$case['price']}PLN</div></div>
                    </div>
                    <div class="name" >{$case['name']}</div>
                    
                </div>  
END;

            }

?>
        </div>
    </div>
    <?php
        footer();
    ?>
    <script>
        $(function(){
            $("div.container").css({"margin-top":"-460px","position":"sticky"});
        });
    </script>
</body>
</html>
