<?php

include("controllers/controller.php");


$incrementa = "UPDATE user SET account_balance= account_balance+'{$_POST['skin_price']}'";
$increquery = mysqli_query($dbc,$incrementa);
$_SESSION['userr']->change_property("account_balance",$_POST['skin_price'],"add");


$sell = "DELETE FROM user_skins WHERE id='{$_POST['transaciton']}'";
$sellquery = mysqli_query($dbc,$sell);

if($sellquery && $increquery){
$_SESSION['skin_sell'] = $_POST['skin_price'];
echo<<<end
    <script>
    window.location.reload(true);
</script>
end;

}