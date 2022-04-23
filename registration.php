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
    <title>Rejestracja</title>
	
<?php

	session_start();

	date_default_timezone_set('Europe/Warsaw');

	if (isset($_POST['email']))
	{

		$wszystko_OK=true;
		
		$nick = $_POST['login'];
		
		if ((strlen($nick)<3) || (strlen($nick)>30))
		{
			$wszystko_OK=false;
echo<<<END

			<script>
			$(function(){
				$("#login").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});

			});
			</script>

END;
			@$_SESSION['e_loginn']=$_SESSION['e_loginn']."Nick musi posiadać od 3 do 30 znaków!";
		}
		
		if (ctype_alnum($nick)==false)
		{
			$wszystko_OK=false;
echo<<<END

			<script>
			$(function(){
				$("#login").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});

			});
			</script>

END;
			$_SESSION['e_loginn']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";
		}
		
		// Sprawdź poprawność adresu email
		$email = $_POST['email'];
		$emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
		
		if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
		{
			$wszystko_OK=false;
			echo<<<END
		
			<script>
			$(function(){
				$("#email").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});

			});
			</script>

END;
			$_SESSION['e_emaill']="Podaj poprawny adres e-mail!";
		}
		
	

		//Sprawdź poprawność hasła
		$haslo1 = $_POST['haslo1'];
		$haslo2 = $_POST['haslo2'];
		
		if ((strlen($haslo1)<8) || (strlen($haslo1)>30))
		{
			$wszystko_OK=false;
			echo<<<END
		
			<script>
			$(function(){
				$("#haslo1").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});

			});
			</script>

END;
			$_SESSION['e_haslo']="Hasło musi posiadać od 8 do 30 znaków!";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
echo<<<END
		
			<script>
			$(function(){
				$("#haslo1").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});
				$("#haslo2").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});
			});
			</script>

END;
			$_SESSION['e_haslo']="Podane hasła nie są identyczne!";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
				
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['e_login'] = $nick;
		$_SESSION['e_email'] = $email;
		$_SESSION['e_haslo1'] = $haslo1;
		$_SESSION['e_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])){
			$_SESSION['e_regulamin'] = false;
		}
		else{

echo<<<END
		
			<script>
			$(function(){
				$(".form-check-label").css("color","#F90716");
				
			});
			</script>

END;
			$wszystko_OK=false;}
		
		require_once "connect.php";
		mysqli_report(MYSQLI_REPORT_STRICT);
		
		try 
		{
			
			if ($dbc->connect_errno!=0)
			{
				throw new Exception(mysqli_connect_errno());
			}
			else
			{
				//Czy email już istnieje?
				$rezultat = $dbc->query("SELECT id FROM user WHERE email='$email'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_maili = $rezultat->num_rows;
				if($ile_takich_maili>0)
				{
					$wszystko_OK=false;
echo<<<END
		
					<script>
					$(function(){
						$("#email").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});
		
					});
					</script>
		
END;
					$_SESSION['e_emaill']="Istnieje już konto przypisane do tego adresu e-mail!";
				}		

				//Czy nick jest już zarezerwowany?
				$rezultat = $dbc->query("SELECT id FROM user WHERE login='$nick'");
				
				if (!$rezultat) throw new Exception($polaczenie->error);
				
				$ile_takich_nickow = $rezultat->num_rows;
				if($ile_takich_nickow>0)
				{
					$wszystko_OK=false;
echo<<<END
		
					<script>
					$(function(){
						$("#login").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});
		
					});
					</script>
		
END;
					$_SESSION['e_loginn']="Istnieje już gracz o takim nicku! Wybierz inny.";
				}
				
				if ($wszystko_OK==true)
				{
					//Hurra, wszystkie testy zaliczone, dodajemy gracza do bazy
					$data = date("Y-m-d H:i:s");
					if ($dbc->query("INSERT INTO user VALUES (NULL, '$nick', '$haslo_hash', '$email',100,1,0,'$data',0)"))
					{
						$_SESSION["udalosieza"] = true;
						$_SESSION['udanarejestracja']=true;
						unset($_SESSION['e_login']);
						unset($_SESSION['e_email']);
						unset($_SESSION['e_haslo1']);
						unset($_SESSION['e_haslo2']);
						header('Location: index.php');
						exit();
					}
					else
					{
						throw new Exception($dbc->error);
					}
					
				}
				
				$dbc->close();
			}
			
		}
		catch(Exception $e)
		{
			header("Location:index.php");
		}
		
	}
	
	
?>
		
</head>
<body>
   <?php 
		navigation();
   ?>
    <div class="container">
        <div class="Zalog">
		<form method="post">
		<div class="form-group">
    <label for="login">Login</label>
    <input type="text" class="form-control" id="login" name="login" placeholder="Wpisz Login">
	<small id="emailHelp" class="form-text text-muted">Musi zawierać od 3 do 30 znaków.</small>
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
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Wpisz Email">
    <small id="emailHelp" class="form-text text-muted">Nigdy nie podamy komuś twojego adresu e-mail.</small>
	<?php
			if (isset($_SESSION['e_emaill']))
			{
				echo '<div class="error">'.$_SESSION['e_emaill'].'</div>';
				unset($_SESSION['e_emaill']);
			}
		?>

  </div>
  <div class="form-group">
    <label for="haslo1">Hasło</label>
    <input type="password" class="form-control" id="haslo1" name="haslo1" placeholder="Wpisz hasło">
	<small id="emailHelp" class="form-text text-muted">Musi zawierać od 8 do 30 znaków.</small>
	<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>
  </div>
  <div class="form-group">
    <label for="haslo2">Powtórz hasło</label>
    <input type="password" class="form-control" id="haslo2" name="haslo2" placeholder="Powtórz hasło">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1" name="regulamin">
    <label class="form-check-label" for="exampleCheck1">Potwierdź regulamin</label>

  </div>
  <button type="submit" class="btn btn-primary" value="Zarejestruj się">Zarejestruj się</button>
</form>


    </div>
    </div>
	<?php footer(); ?>
	<script>
        $(function(){
            $("div.container").css({"position":"sticky","background-color":"rgb(232 232 232)"});
        });
    </script>
</body>
</body>
</html>