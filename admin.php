<?php
    session_start();
    include("connect.php");
    if (@$_COOKIE['checksum'] == md5(@$_COOKIE['user']).@$_COOKIE['login_dod']) {
        $users = "SELECT * FROM user WHERE login='$_COOKIE[user]'";
        $get = mysqli_query($dbc,$users);
        $user = mysqli_fetch_row($get);
        if($user[8]!=1){
            header("Location:index.php");
        }
    }
    else{
        header("Location:index.php");
    }


?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include("include.php"); head(); ?>
    <title>Admin</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


</head>
<body>
    <?php navigation(); ?>
    <div class="containera">
        <div class="stats">
            <div class="dailyprofit">
                <?php 
                    $data = date("Y-m-d");
                    $profit = "SELECT `logi`.`case_value`,`skins`.`price` FROM `logi` INNER JOIN `skins` ON `logi`.`skin_id`=`skins`.`id` WHERE `logi`.`action`='draw' AND `logi`.`date_of_draw`='$data'";
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
                        $str = "Dzisiejszy zysk";
                    }
                    else{
                        $str = "Dzisiejsza strata";
                    }
                    $draws = $resprof->num_rows;
                    echo "<h1>".$str."</h1>";
                    echo "<h3>".$dailyprofit." PLN</h3>";
                    echo "<h4>Ilość otwartych skrzynek: ".$draws."</h4>";

                ?>
                
            </div>
            <div class="dates">
                <h1>Wybierz dzień:</h1>
                <select name="dates" id="dates">
                <?php 
                    $datesactual = "";
                    $dates = "SELECT date_of_draw FROM `logi` ORDER BY `logi`.`date_of_draw` ASC";
                    $resdates = mysqli_query($dbc, $dates);
                    $fetchdates = mysqli_fetch_all($resdates, MYSQLI_ASSOC);
                    foreach($fetchdates as $d){
                        $spraw = strpos($datesactual,$d['date_of_draw']);
                        if($spraw == FALSE){
                            echo "<option value='{$d['date_of_draw']}'>{$d['date_of_draw']}</option>";
                            $datesactual .= " ".$d['date_of_draw'];
                        }
                    }
                ?>
                </select>
                <script>
                    $('#dates').change(function(){
                        var selectedate = $(this).val();
          
                        $('div.dailyprofit').empty();

                        $.post("stats.php",{
                            date: selectedate
                        },function(data,status){
                            $('div.dailyprofit').html(data);
                        });
    
                    })
                </script>
                        
            </div>
        </div>
        <div class="chart">
        <script>
    const data = [];
    const labels = [];
    <?php 

    $dates = explode(" ",$datesactual);
    for($i=1;$i<=count($dates)-1; $i++){
        $allcase =0;
        $userall =0;
        $dailyprofit =0;
        $sql = "SELECT `logi`.`date_of_draw`,`logi`.`case_value`,`skins`.`price` FROM `logi` INNER JOIN `user` ON `logi`.`user_id`=`user`.`id` INNER JOIN `skins` ON `logi`.`skin_id`=`skins`.`id` WHERE date_of_draw='{$dates[$i]}'";
        $res = mysqli_query($dbc,$sql);
        $chartfetch = mysqli_fetch_all($res,MYSQLI_ASSOC);
        foreach($chartfetch as $c){          
            $allcase = $allcase + $c['case_value'];
            $userall = $userall + $c['price'];
        }
        $dailyprofit = $allcase - $userall;
        echo "labels.push(".json_encode($dates[$i]).");";
        echo "data.push(".json_encode($dailyprofit).");";
        
 
    }
       
   
        
    ?>
    </script>
         <canvas id="myChart" max-width="400px" max-height="400px"></canvas>
<script>

const ctx = document.getElementById('myChart').getContext('2d');
const myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Zysk w danych dniach',
            data: data,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>   
</div>
    </div>
    <?php footer(); ?>
</body>
</html>
