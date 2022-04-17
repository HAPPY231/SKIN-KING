<?php 
    include("connect.php");

    $profit = "SELECT `logi`.`case_value`,`skins`.`price` FROM `logi` INNER JOIN `skins` ON `logi`.`skin_id`=`skins`.`id` WHERE `logi`.`action`='draw' AND `logi`.`date_of_draw`='$_POST[date]'";
    $resprof = mysqli_query($dbc, $profit);
    $fetch = mysqli_fetch_all($resprof, MYSQLI_ASSOC);
    $allcase = 0;
    $userall = 0;
    foreach($fetch as $f){
        $allcase = $allcase + $f['case_value'];
        $userall = $userall + $f['price'];
    }
    $dailyprofit = $allcase - $userall;
    if($dailyprofit>=0){
        $str = "Zysk w dniu ".$_POST['date'];
    }
    else{
        $str = "Strata w dniu ".$_POST['date'];
    }
    $draws = $resprof->num_rows;
    echo "<h1>".$str."</h1>";
    echo "<h3>".$dailyprofit." PLN</h3>";
    echo "<h4>Ilość otwartych skrzynek: ".$draws."</h4>";
