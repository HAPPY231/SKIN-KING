
<div class="container">
    <div class="mx-auto text-center log" style="width: 30%;">
        <h1>Sign in</h1>
        <form action="Signin" method="POST" id="logging">
            <div class="form-group">
                <label for="loign">Username</label>
                <input type="text" class="form-control" id="loign" name="login" aria-describedby="emailHelp" placeholder="Wpisz login">
            </div>
            <div class="form-group">
                <label for="haslo">Password</label>
                <input type="password" class="form-control" id="haslo" name="pass" placeholder="Password">
            </div>
            <button type="submit" class="btn mt-2 btn-primary" value="Sign in">Sign in</button>
        </form>
        <?php
        if(isset($_SESSION['blad'])){
            echo $_SESSION['blad'];
        }
        ?>
    </div>
</div>
<script>
    $(function(){
        $("div.container").css({"position":"sticky","background-color":"rgb(232 232 232)"});
    });
</script>
