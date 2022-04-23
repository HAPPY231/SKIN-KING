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
        <form action="web.php" method="POST">
  <div class="form-group">
    <label for="loign">Email address</label>
    <input type="text" class="form-control" id="loign" name="login" aria-describedby="emailHelp" placeholder="Wpisz login">
  </div>
  <div class="form-group">
    <label for="haslo">Hasło</label>
    <input type="password" class="form-control" id="haslo" name="haslo" placeholder="Password">
  </div>
  <button type="submit" class="btn mt-2 btn-primary" value="Zaloguj się">Zaloguj się</button>
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
            $("div.container").css({"position":"sticky","background-color":"rgb(232 232 232)"});
        });
    </script>
</body>
</html>