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

echo "<ul class='gallery'>";
$case = $_POST['case_id'];
$user = $_POST['user_id'];

$i = 0;
$percentage = 0;
include("connect.php");
$skins = "SELECT * FROM `skins_in_cases`  right join `skins` on `skins_in_cases`.`skin_id`=`skins`.`id` WHERE `skins_in_cases`.`case_id`={$case} ORDER BY `skins`.`price` DESC";
$daw = mysqli_query($dbc, $skins);
$all = mysqli_fetch_all($daw,MYSQLI_ASSOC);
foreach($all as $case_skin){
$inside = "SELECT * FROM skins WHERE id=$case_skin[skin_id]";
$db = mysqli_query($dbc,$inside);
$skis = mysqli_fetch_all($db,MYSQLI_ASSOC);

    $a[$i] = $case_skin['skin_id'];
    $b[$i] = $case_skin['price'];
    $percentage = $percentage + $case_skin['price'];

//    echo<<<end
//        <li style="width: 200px; height:190px; background-image: url('skins/{$skin['image']}.png'); background-repeat: no-repeat;  background-size: 100% 100%;">{$skin['name']}</li>     
//
//    end;

$i++;
}
echo "</ul>";

$r = array();
$x = 0;
foreach ($b as $key) {
    $count1 = $key/$percentage;
    $count2 = $count1 * 100;
    $r[$x] = $count2;
    $x++;
}
$rv = array_reverse($r);
$c = array_combine($a,$rv);

    function getClosest($search, $arr) {
        $closest = null;
        foreach ($arr as $item) {
            if ($closest === null || abs($search - $closest) > abs($item - $search)) {
                $closest = $item;
            }
        }
        return $closest;
    }

$rang = rand(1,100);
$win = array_search(getClosest($rang,$c),$c);

$sql = "SELECT * FROM skins WHERE id=$win";
$winskin = mysqli_query($dbc,$sql);
$row = mysqli_fetch_row($winskin);

$add = "INSERT INTO user_skins VALUES(NULL,'$_POST[user_id]',$row[0])";
$res = mysqli_query($dbc,$add);

$transaction = "SELECT id FROM user_skins WHERE user_id='$_POST[user_id]' AND skin_id=$row[0] ";
$transactionquery = mysqli_query($dbc,$transaction);
$tranrow = mysqli_fetch_row($transactionquery);

$case_price = "SELECT price,experience FROM cases WHERE id='$case'";
$case_query = mysqli_query($dbc,$case_price);
$case_row = mysqli_fetch_row($case_query);

$subtraction = "UPDATE user SET account_balance = account_balance-$case_row[0],experience=experience+$case_row[1] WHERE id='$_POST[user_id]'";
$mysql = mysqli_query($dbc,$subtraction);

$user_account = "SELECT name,account_balance,level,experience FROM user WHERE id='$_POST[user_id]'";
$user_query = mysqli_query($dbc,$user_account);
$row_user = mysqli_fetch_row($user_query);

$expmax = ($row_user[2]*100)+200;
if($expmax<$row_user[3]){
    $willstay = $expmax - $row_user[3];
    $levelup = "UPDATE `user` SET `level`=`level`+1,`experience`=(`experience`+{$case_row[1]})-`experience` WHERE `id`='$_POST[user_id]'";
    $levelupquery = mysqli_query($dbc,$levelup);
}

if($expmax==$row_user[3]){
    $willstay = $expmax - $row_user[3];
    $levelup = "UPDATE `user` SET `level`=`level`+1,`experience`=`experience`-`experience` WHERE `id`='$_POST[user_id]'";
    $levelupquery = mysqli_query($dbc,$levelup);
}

$check = check($row[6],webkit,moz,box,colorr,colorp,colorpur,colorb);

$slash = "/";
echo "<script>";
echo "var tranid =".json_encode($tranrow[0]).";";
echo "var skin_id =".json_encode($row[0]).";";
echo "var name =".json_encode($row[1]).";";
echo "var price =".json_encode($row[4]).";";
echo "var image =".json_encode($row[2]).";";
echo "var user =".json_encode($row_user[0]).";";
echo "var account =".json_encode($row_user[1]).";";
echo "var case_price =".json_encode($case_row[0]).";";
echo "var level =".json_encode($row_user[2]).";";

echo<<<END


        var url = "'skins/"+image+".png'";
        $('li#account').html(user+": "+account+"PLN <div class='dropdown-content'><a href='equipment.php'>Poziom: "+level+"</a><hr class='mx-auto horizontal-line' style='margin-top: 1px; margin-bottom: 9px;'><a href='equipment.php'>Ekwipunek</a><br><a href='settings.php'>Ustawienia</a></div>"); 
        $('li#substraction').html("-"+case_price+"PLN"); 
        $('li#substraction').css({"opacity":"1","transform":"translate(0px,40px)"}); 
        setTimeout(function(){
            $('li#substraction').css({'opacity':"0",'transform':'translate(0px,-30px)'}); 
        },2000);

        $('div.keys').html("LOSOWANIE...");
        setTimeout(function(){
            $('div.keys').css({"flex-direction":"column","text-align":"center"});
            $('div.keys').html(price+"PLN<div class='skin' style='width: 250px; height: 250px; margin-top: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: center; align-items: flex-end; align-content: flex-end {$check}'>"+name+" <img src='skins/"+image+".png' style='width: 250px;height:250px;'></div><br><div class='d-flex'><button id='sell'>Sprzedaj</button><br><button id='again'>Zostaw</button></div></div>");
            $('button#sell').click(function(){
                $.post("sell.php",{
                    skin_id: skin_id,
                    skin_price: price,
                    user_id: user,
                    transaciton: tranid
                },function(data,status){
                    $('div.keys').html(data);
                   
                });
        });
            $('button#again').click(function(){
                window.location.reload();
        });
        
    },2000);
        
       
</script>
END;


?>  