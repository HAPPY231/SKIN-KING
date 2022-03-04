<?php 

    session_start();
    include("include.php");
    include("connect.php");

    if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
        $users = "SELECT * FROM user WHERE name='$_COOKIE[user]'";
        $get = mysqli_query($dbc,$users);
        $user = mysqli_fetch_row($get);
    }
    else{
        header("Location:index.php");
    }


    define('webkit',' -webkit-box-shadow: inset 0px 0px 17px -3px ');
    define('moz',' -moz-box-shadow: inset 0px 0px 17px -3px ');
    define('box',' box-shadow: inset 0px 0px 17px -3px ');
    define('colorr','#EB4B4B;');
    define('colorp','#EB4BE6;');
    define('colorpur','#9300ff;');
    define('colorb','#4b69ff;');

    function check($odd,$webkit,$moz,$box,$colorr,$colorp,$colorpur,$colorb){

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

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php head(); ?>
    <title>Ekwipunek | <?php echo $user[1]; ?></title>
</head>
<body>
    <?php navigation(); ?>
    <div class="container">
        <div class="mx-auto w-80 accountinfo">
            <h1><?php echo $user[1].": ".$user[4]."PLN " ?>TWÓJ EKWIPUNEK</h1>
        </div>
        <div class='mx-auto pagination'>
<?php
            if (isset($_GET['pageno'])) {
                $pageno = $_GET['pageno'];
             } else {
                $pageno = 1;
             } 

            function getpage($i){
                if (isset($_GET['pageno'])) {
                    if($_GET['pageno']==$i){
                        return "class='active'";
                    }
                 }
            }

            $count = "SELECT * FROM user_skins WHERE user_id={$user[0]}";
            $myco = mysqli_query($dbc, $count);
            $cou = $myco->num_rows;
            
            $rows_per_page = 20;
            
            $lastpage = ceil($cou/$rows_per_page);

            if ($pageno > $lastpage) {
            $pageno = $lastpage;
            } 
            if ($pageno < 1) {
            $pageno = 1;
            }
            echo "<a href='{$_SERVER['PHP_SELF']}?pageno=1'>&laquo;</a>";
            for($i=1; $i<=$lastpage; $i++){
                $check=getpage($i);
                echo "<a href='{$_SERVER['PHP_SELF']}?pageno={$i}'{$check}>{$i}</a>";
            }
            echo "<a href='{$_SERVER['PHP_SELF']}?pageno={$lastpage}'>&raquo;</a>";
            $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
?>
</div>
        </center>
<div class="skinbox">
<?php
            $sql = "SELECT `user_skins`.*,`skins`.`name`,`skins`.`image`,`skins`.`type`,`skins`.`price`,`skins`.`Container Odds` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `user_id`='{$user[0]}' {$limit}";
            $res = mysqli_query($dbc,$sql);
            $skins = mysqli_fetch_all($res, MYSQLI_ASSOC);
            foreach($skins as $skin){

                $check = check($skin['Container Odds'],webkit,moz,box,colorr,colorp,colorpur,colorb);
                echo<<<END
                
                    <div class="skin" style="width: 250px; height: 250px; margin-top: 20px; margin-left: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; {$check}">
                        <div class="sellorwithdraw">
                        <span style="color: #fff;">{$skin['name']}</span>
                                <button onclick="myf({$skin['id']})">Sprzedaj</button>
                            </div>
                            <div class="imagess" style="background-image: url('skins/{$skin['image']}.png');">
                            <div class="eprice"><div class="inside">{$skin['price']}PLN</div></div>
                            </div>
                        
                    </div>
                END;
            }

?>
</div>
    </div>
    <?php footer(); ?>
    <script>
        $(function(){
            $("body").css("background-image","repeat");
            $("div.container").css("background-color","#fff");
        });
    </script>
</body>
</html>