<?php
    include("connect.php");
    $user_id = $_POST['user_id'];
    $time_user = $_POST['time'];

    $add = array(1200, 800, 400, 200, 100, 50, 10);
    $fullvalue = 0;
    foreach($add as $a){
        $fullvalue = $fullvalue + $a; 
    }
    $percentages = array();
    $x = 0;
    foreach($add as $a){
        $count1 = $a/$fullvalue;
        $count2 = $count1 * 100;
        $percentages[$x] = $count2;
        $x++;
    }
    $rp = array_reverse($percentages);
    $c = array_combine($add, $rp);
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
    $sqladd = "UPDATE user SET account_balance=account_balance+$win WHERE id='$user_id'";
    $addquery = mysqli_query($dbc,$sqladd);

    date_default_timezone_set('Europe/Warsaw');
    $date=date_create(date("Y-m-d H:i:s"));
    date_modify($date,"+30 minutes");
    $dataf = date_format($date,"Y-m-d H:i:s");

    $datechange = "UPDATE user SET `date`='$dataf' WHERE id='$user_id'";
    $mydatechaquery = mysqli_query($dbc,$datechange);
    echo "Wygrałeś: ".$win."PLN";
    
    // echo "<ul>";
    // foreach($add as $a){
    //     echo "<li style='width: 200px; height:190px; text-align:center; background-color: #fff;' >{$a}</li>";
    // }
    // echo "</ul>";
?>