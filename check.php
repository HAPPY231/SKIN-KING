<?php
include("controllers/controller.php");

?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?=head(); ?>
    <title>Check</title>
</head>
<body>
<?php


echo $_SESSION['userr']->get("account_balance")."</br>";
$_SESSION['userr']->change_property("account_balance",'30',"subtraction");
echo $_SESSION['userr']->get("account_balance")."</br>";
?>
<div class="container">
    awd
</div>
<?=footer(); ?>
</body>
</html>


