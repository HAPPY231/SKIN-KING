<?php
    session_start();

    include("include.php");

    if($_COOKIE['checksum'] == md5($_COOKIE['user']).$_COOKIE['login_dod'] && isset($_POST['loguot'])){

            
            setcookie('zalogowany', null, time() - 3600); 
            setcookie('user', null, time() - 3600); 
            setcookie('email', null, time() - 3600);
            setcookie('checksum', null, time() - 3600);
            setcookie('login_dod', null, time() - 3600); 
        unset($_POST['loguot']);
        header("Location:index.php");
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php head(); ?>
    <title>Ustawienia</title>
</head>
<body>
<?php navigation(); ?>
<div class="container">
    <form method="POST">
        <input type="submit" name="loguot" value="Wyloguj się">
    </form>
</div>
</body>
</html>