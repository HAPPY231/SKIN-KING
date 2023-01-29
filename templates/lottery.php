<div class="container">
    <div class="mx-auto w-90 lottery">
        <center><h1>LOTTERY</h1></center>
        <div class="mx-auto w-50 text-center draw">
            <?php

            $dateactual = date("Y-m-d H:i:s");
            $now_timestamp = strtotime($dateactual);
            $date_user = (string)$this->getUser('date');
            $diff_timestamp = $now_timestamp - strtotime($date_user);
            $howmuch = round($diff_timestamp/60);
            $abs = abs($howmuch);
            if($this->getUser('date')<$dateactual){
                echo "<button id='draw'>Draw</button>";
            }
            else{
                echo "Another opportunity to draw for ".$abs." minutes";
            }
            ?></div>
    </div>
</div>
<script>
    $(function(){
        $("div.container").css({"background-color":"rgb(232 232 232)"});

        $('#draw').click(function(){
            $.post("Lottery",{
                user_id: <?php echo json_encode($this->getUser("id")); ?>,
                time: <?php echo json_encode($this->getUser("date")); ?>
            },function(data,status){
                $('div.draw').html(data);
            });
        });
    });
</script>