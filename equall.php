<?php 
    $toadd = $_POST['equall'];
    $user = $_POST['user_id'];
    $round = round($_POST['equall'],2);
    include("connect.php");
    $sql = "DELETE FROM user_skins WHERE user_id='{$_POST['user_id']}'";
    $mysql = mysqli_query($dbc,$sql);
    $sql2 = "UPDATE user SET account_balance=account_balance+$toadd WHERE id='{$_POST['user_id']}'";
    $mysql2 = mysqli_query($dbc,$sql2);

echo<<<END
<script>
window.location.reload();
</script>
END;

