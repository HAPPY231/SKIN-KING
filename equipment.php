<?php
include("controllers/controller.php");
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php head(); ?>
    <title>SKIN-KING | <?php echo $_SESSION['userr']->get("login"); ?></title>
</head>
<body>
    <?php navigation(); ?>
    <div class="container">
        <div class="mx-auto w-80 accountinfo">
            <h1><?php echo $_SESSION['userr']->get("login").": "
                    .$_SESSION['userr']->get("account_balance")."PLN "
                ?></h1>
            <div class="level">
            <?php echo "Poziom: ".$_SESSION['userr']->get("level");?>
            <progress id="file" max="100" value="<?php echo $_SESSION['userr']->get("percentage");
            ?>"> <?php
                echo $_SESSION['userr']->get("percentage");?>% </progress>
            <?php echo $_SESSION['userr']->get("exp")."/".$_SESSION['userr']->get("expmax");?>
            </div>
        </div>
        <div class='mx-auto pagination'>
            <h3>TWÓJ EKWIPUNEK</h3>
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

            $count = "SELECT * FROM user_skins WHERE user_id={$_SESSION['userr']->get("identity")}";
            $myco = mysqli_query($dbc, $count);
            $cou = $myco->num_rows;
            if($cou>0){
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

                $all = 0;
                $sqlall = "SELECT `skins`.`price` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `user_id`={$_SESSION['userr']->get("identity")}";
                $myrowall = mysqli_query($dbc,$sqlall);
                while($row = $myrowall->fetch_row()){
                    $all=$all+$row[0];
                }
                echo "<button id='sellall' onclick='sellall(".json_encode($all).")'>Sprzedaj wszystko wartość {$all} PLN</button>";
            
        }
?>
</div>
        </center>
<div class="skinbox">
<?php
        if($cou>0){
            $sql = "SELECT `user_skins`.*,`skins`.`name`,`skins`.`image`,`skins`.`type`,`skins`.`price`,`skins`.`Container Odds` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `user_id`={$_SESSION['userr']->get("identity")} ORDER BY `skins`.`price` DESC {$limit}";
            $res = mysqli_query($dbc,$sql);
            $skins = mysqli_fetch_all($res, MYSQLI_ASSOC);
            foreach($skins as $skin){

                $check = check($skin['Container Odds'],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
                echo<<<END
                
                    <div class="skin" style="width: 250px; height: 250px; margin-top: 20px; margin-left: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; {$check}">
                        <div class="sellorwithdraw">
                        <span style="color: #fff;">{$skin['name']}</span>
                                <button id="sell" onclick="myf({$skin['id']})">Sprzedaj</button>
                            </div>
                            <div class="imagess" style="background-image: url('skins/{$skin['image']}.png');">
                           
                            </div>
                         <div class="eprice"><div class="inside">{$skin['price']}PLN</div></div>
                    </div>
                END;
            }
            
        }
        else{
            echo "Nie posiadasz żadnych skinów!";
        }
?>
</div>
    </div>

    <?php footer(); ?>
    <script>
        $(function(){
            $("body").css("background-image","repeat");
            $("div.container").css("background-color","#E8E8E8");
        });

        function sellall(all){
            $.post("equall.php",{
                            equall: all,
                            user_id: <?php echo json_encode($_SESSION['userr']->get("identity"));?>
                        },function(data,status){
                            $('div.accountinfo').append(data);
                        }); 
        }

        function myf(id){
            $.post("equsell.php",{
                            user_skins: id,
                            user_id: <?php echo json_encode($_SESSION['userr']->get("identity"));?>
                        },function(data,status){
                            $('div.accountinfo').append(data);
                        }); 
        }
    </script>
</body>
</html>