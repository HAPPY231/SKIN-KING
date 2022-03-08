<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    include("include.php");
    head();
    include("connect.php");
    ?>
    <title>Logowanie</title>
</head>
<body>
<?php navigation(); ?>
<div class="container">
    <div class="mx-auto log" style="width: 30%;">
        <form action="web.php" method="POST" style="width: 30%;">
            Login: <input type="text" id="loign" name="login"/><br>
            Hasło: <input type="password" id="haslo" name="haslo"/><br><br>
            <input type="submit" value="Zaloguj się">
        </form>
<?php 
    if(isset($_SESSION['blad'])){
    echo $_SESSION['blad'];
    }
?>
    </div>
</div>
<?php footer(); ?>
    <script>
        $(function(){
            $("div.container").css({"position":"sticky","background-color":"#949494"});
        });
    </script>
</body>
</html>