<div class="containera">
    <div class="stats">
        <div class="dailyprofit">
            <?php
            $allcase = 0;
            $userall = 0;
            foreach($this->admin('fetch') as $f){
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
            $draws = $this->admin('resprof')->num_rows;
            $dailyprofit = round($dailyprofit,2);
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
                $resdates = (new \Connect)->getDbc()->query($dates);
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
                $res = (new \Connect)->getDbc()->query($sql);
                $chartfetch = $res->fetch_all(MYSQLI_ASSOC);
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