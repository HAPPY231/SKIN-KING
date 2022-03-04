<?php $_SESSION['case'] = $_GET['case_id']; ?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php
    include("include.php");
    head();
    include("connect.php");
    $sql = "SELECT * FROM cases WHERE id=$_SESSION[case]";
    $case = mysqli_query($dbc,$sql);
    $row = mysqli_fetch_row($case)
    ?>
    <title>SKIN-KING | <?php echo $row[1]; ?></title>
</head>
<body>
<div class="container">
    <?php navigation(); ?>
    <div class="mx-auto keys">
        <ul class="gallery">
            <li style="background: #f6bd60;"></li>
            <li style="background: #f7ede2;"></li>
            <li style="background: #f5cac3;"></li>
            <li style="background: #84a59d;"></li>
            <li style="background: #f28482;"></li>
            <li style="background: #f28482;"></li>
            <li style="background: #f28482;"></li>
        </ul>
        <script>

        </script>
    </div>
    <?php
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
    <div class="mx-auto skins">
        <hr class="mx-auto horizontal-line">
        <div class="skinbox">
            <?php
            $skins = "SELECT * FROM skins_in_cases WHERE case_id='$row[0]'";
            $daw = mysqli_query($dbc, $skins);
            $all = mysqli_fetch_all($daw,MYSQLI_ASSOC);
            foreach($all as $case_skin){
                $inside = "SELECT * FROM skins WHERE id=$case_skin[skin_id]";
                $db = mysqli_query($dbc,$inside);
                $skis = mysqli_fetch_all($db,MYSQLI_ASSOC);

                foreach($skis as $skin){
                    $check = check($skin['Container Odds'],webkit,moz,box,colorr,colorp,colorpur,colorb);
                    echo<<<END
                        <div class="skin" style="width: 250px; height: 250px; margin-top: 20px; margin-left: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; align-items: flex-end; align-content: center;{$check}">
                            <div class="image" style="width: 200px; height:190px; background-image: url('skins/{$skin['image']}.png'); background-repeat: no-repeat;  background-size: 100% 100%;">
                              {$skin['name']}
                            
                            </div>
                        </div>
END;
                }
            }
            ?>
        </div>
    </div>
</div>
</div>
</body>
</html>