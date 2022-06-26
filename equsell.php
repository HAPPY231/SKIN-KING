<?php
include("controllers/controller.php");

$sql = "SELECT `skins`.`price` FROM `user_skins` RIGHT JOIN `skins` ON `user_skins`.`skin_id`=`skins`.`id` WHERE `user_skins`.`id`='{$_POST['user_skins']}'";
$quesql = mysqli_query($dbc,$sql);
$qls = mysqli_fetch_row($quesql);

$delete = "DELETE FROM `user_skins` WHERE `user_skins`.`id`='{$_POST['user_skins']}'";
$deletequery = mysqli_query($dbc,$delete);

$acount = "UPDATE user SET account_balance=account_balance+{$qls[0]} WHERE id={$_POST['user_id']}";
$addtobalanace = mysqli_query($dbc,$acount);
$_SESSION['userr']->change_property("account_balance",$qls[0],"add");

if($addtobalanace && $acount){
echo "<script>";
echo "var add =".json_encode($qls[0]).";";
echo<<<END

window.location.reload();

END;
echo"</script>";                                     
 }