<?php
    if(isset($_SESSION['errors_red'])&&count(@$_SESSION['errors_red'])>0){
        for($i=0;$i<count($_SESSION['errors_red']);$i++){
echo<<<END
        <script>
        $(function(){
            $("#{$_SESSION['errors_red'][$i]}").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});
        });
        </script>
END;
        }
        unset($_SESSION['errors_red']);
    }
?>
<div class="container" style="position: sticky; background-color: rgb(232, 232, 232);">
    <div class="Zalog">
        <h1>Sign up</h1>
        <form method="POST" id="registration" action="Signup">
            <div class="form-group">
                <label for="login">Login</label>
                <input type="text" class="form-control" id="login" name="login" minlength="8"
                       maxlength="30" placeholder="Enter login" required>
                <small id="emailHelp" class="form-text text-muted">It must contain between 3 and 30 characters.</small>
                <?php
                if (isset($_SESSION['e_loginn']))
                {
                    echo '<div class="error">'.$_SESSION['e_loginn'].'</div>';
                    unset($_SESSION['e_loginn']);
                }

                ?>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                       placeholder="Enter email" required>
                <small id="emailHelp" class="form-text text-muted">We will never give someone your address
                    <br>e-mail.</small>
                <?php
                if (isset($_SESSION['e_emaill']))
                {
                    echo '<div class="error">'.$_SESSION['e_emaill'].'</div>';
                    unset($_SESSION['e_emaill']);
                }
                ?>

            </div>
            <div class="form-group">
                <label for="haslo1">Password</label>
                <input type="password" class="form-control" id="haslo1" name="haslo1" minlength="8"
                       maxlength="30"
                       placeholder="Enter password" required>
                <small id="emailHelp" class="form-text text-muted">It must contain between 8 and 30 characters.</small>
                <?php
                if (isset($_SESSION['e_pass']))
                {
                    echo '<div class="error">'.$_SESSION['e_pass'].'</div>';
                    unset($_SESSION['e_pass']);
                }
                ?>
            </div>
            <div class="form-group">
                <label for="haslo2">Confirm password</label>
                <input type="password" class="form-control" id="haslo2" name="haslo2" minlength="8"
                       maxlength="30"  placeholder="Repeat password" required>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="regulamin">
                <label class="form-check-label" id="form-check-label" for="exampleCheck1">Confirm regulations</label>
            </div>
            <button type="submit" class="btn btn-primary" value="Zarejestruj się">Sign up</button>
        </form>


    </div>
</div>