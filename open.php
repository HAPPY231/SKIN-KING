<?php
date_default_timezone_set('Europe/Warsaw');

$case = $_POST['case_id'];
$user = $_POST['user_id'];

$i = 0;
$percentage = 0;
include_once("connect.php");
include_once("include.php");
include_once("clasess/skin.php");
$skins = "SELECT * FROM `skins_in_cases`  right join `skins` on `skins_in_cases`.`skin_id`=`skins`.`id` WHERE `skins_in_cases`.`case_id`={$case} ORDER BY `skins`.`price` DESC";
$daw = mysqli_query($dbc, $skins);
$items = array();

while($all = mysqli_fetch_row($daw)){

    $a[$i] = $all[2];
    $b[$i] = $all[7];
    $percentage = $percentage + $all[7];
    ${"item".$i} = new skin($all[4],$all[5],$all[7],$all[6],$all[8],$all[9]);
    array_push($items, "item".$i);
    
$i++;
}

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

$rang = rand(0.0000005,100);
$win = array_search(getClosest($rang,$c),$c);

$sql = "SELECT * FROM skins WHERE id=$win";
$winskin = mysqli_query($dbc,$sql);
$row = mysqli_fetch_row($winskin);

$data = date("Y-m-d");

$logs = "INSERT INTO logi VALUES(NULL,'draw','$_POST[user_id]',$row[0],'$_POST[case_value]','$data')";
$reslogs = mysqli_query($dbc,$logs);

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

$user_account = "SELECT login,account_balance,level,experience,admin FROM user WHERE id='$_POST[user_id]'";
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

$check = check($row[6],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
echo "<hr class='perpendicular-line' style='width: 3px; height: 212px; transform: translate(33px, -21px);background-color: black; position: absolute; z-index: 3;'>";
        echo "<ul class='gallery'>";
        //$skinsra = "SELECT * FROM `skins_in_cases` right join `skins` on `skins_in_cases`.`skin_id`=`skins`.`id` WHERE `skins_in_cases`.`case_id`={$case} ORDER BY rand()";
        //$dawra = mysqli_query($dbc, $skinsra);
        //$alla = mysqli_fetch_all($dawra,MYSQLI_ASSOC);
        $count = count($items)*4;
        

        for($x=0; $x<$count;){
            $e = rand(0,count($items)-1);
            $name = ${$items[$e]}->getName();
            $image = ${$items[$e]}->getImage();
            $containerodd = ${$items[$e]}->getContainerOdd();
            $check = check($containerodd,webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
echo<<<end
                
                <li style=" {$check} background-image: url('skins/{$image}.png');">{$name}</li>
end;
$x++;
        }

        $check = check($row[6],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);

        echo<<<END

        <li style=" {$check} background-image: url('skins/{$row[2]}.png');">{$row[1]}</li>

        END;

        for($x=0; $x<count($items);){
            $e = rand(0,7);
            $name = ${$items[$e]}->getName();
            $image = ${$items[$e]}->getImage();
            $containerodd = ${$items[$e]}->getContainerOdd();
            $check = check($containerodd,webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);
echo<<<end
                
                <li style=" {$check} background-image: url('skins/{$image}.png');">{$name}</li>
end;
$x++;
        }

        echo "</ul>";

$check = check($row[6],webkit,moz,box,colorr,colorp,colorpur,colorb,colorg);

echo "<script>";
echo "let tranid =".json_encode($tranrow[0]).";";
echo "let skin_id =".json_encode($row[0]).";";
echo "let name =".json_encode($row[1]).";";
echo "let price =".json_encode($row[4]).";";
echo "let image =".json_encode($row[2]).";";
echo "let state =".json_encode($row[5]).";";
echo "let user =".json_encode($row_user[0]).";";
echo "let account =".json_encode($row_user[1]).";";
echo "let admin =".json_encode($row_user[4]).";";
echo "let case_price =".json_encode($case_row[0]).";";
echo "let level =".json_encode($row_user[2]).";";

echo<<<END
        let animationvalue = -30.5;

        let url = "'skins/"+image+".png'";
        $('li#account').html(user+": "+account+"PLN <div class='dropdown-content'><a href='equipment.php'>Poziom: "+level+"</a><hr class='mx-auto horizontal-line' style='margin-top: 1px; margin-bottom: 9px;'><a href='lottery.php'>Losowanie</a><br><a href='equipment.php'>Ekwipunek</a><br><a href='settings.php'>Ustawienia</a><form method='POST'><input type='submit' id='sell' name='loguot'  value='Wyloguj się'></form></div>"); 
        $('li#substraction').html("-"+case_price+"PLN"); 
        $('li#substraction').css({"opacity":"1","transform":"translate(0px,40px)"}); 
        setTimeout(function(){
            $('li#substraction').css({'opacity':'0','transform':'translate(0px,-30px)'}); 
        },2000);

        $('.gallery').animate({  borderColapse: animationvalue }, {
            step: function(now,fx) {
              $(this).css('transform','translate('+now+'%)');  
            },
            duration:'3000'
        },'linear');

        setTimeout(function(){
            $('div.keys').css({"text-align":"center","justify-content":"space-between","padding":"30px"});
            $('div.keys').html("<div class='mx-auto' style='width:70%; display: flex;'><div class='skin' style='width: 250px; height: 250px; margin-top: 20px; text-align: center; display: flex; flex-direction: row; flex-wrap: wrap; justify-content: space-between; align-items: flex-end; align-content: flex-end {$check}'> <img src='skins/"+image+".png' style='width: 250px;height:250px;'></div><br><hr class='perpendicular-line' style='width:200px;transform: translateY(120px) rotate(90deg);'><div style='width: 50%;height:200px;justify-content: space-between;margin-top: 40px;'><span style='font-size: 30px;text-transform: uppercase; font-weight: 700;'>"+name+"</span><br><span>Cena: "+price+"PLN</span><br><span>Stan: "+state+"</span><div class='d-flex' style='width: 100%;margin-top: 25px;justify-content: space-between;align-items: center; align-content: center;'><button id='sell'>Sprzedaj</button><button id='again'>Zostaw</button></div></div></div></div>");
            if(admin==true){
                $('div.dropdown-content').append("<a href='admin.php'>Administracja</a><br>");
            }
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
        
    },4000); 
        
       
</script>
END;

mysqli_close($dbc);


?>  
