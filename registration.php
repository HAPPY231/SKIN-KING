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
		//Udana walidacja? Załóżmy, że tak!
		$wszystko_OK=true;
		
		//Sprawdź poprawność nickname'a
		$nick = $_POST['login'];
		
		//Sprawdzenie długości nicka
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
			$_SESSION['e_loginn']="<center>Nick może składać się tylko z liter i cyfr </br>(bez polskich znaków)</center>";
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
			$_SESSION['e_emaill']="<center>Podaj poprawny adres e-mail!</center>";
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
				$(".haslo1").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});

			});
			</script>

END;
			$_SESSION['e_haslo']="<center>Hasło musi posiadać</br> od 8 do 30 znaków!</center>";
		}
		
		if ($haslo1!=$haslo2)
		{
			$wszystko_OK=false;
			echo<<<END
		
			<script>
			$(function(){
				$("#haslo1").css({"border-color":"#F90716","border-weight":"1px","border-style":"solid"});

			});
			</script>

END;
			$_SESSION['e_haslo']="<center>Podane hasła nie są identyczne!</center>";
		}	

		$haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);
		
				
		
		//Zapamiętaj wprowadzone dane
		$_SESSION['e_login'] = $nick;
		$_SESSION['e_email'] = $email;
		$_SESSION['e_haslo1'] = $haslo1;
		$_SESSION['e_haslo2'] = $haslo2;
		if (isset($_POST['regulamin'])) $_SESSION['e_regulamin'] = true;
		
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
					$_SESSION['e_emaill']="<center>Istnieje już konto przypisane do tego adresu e-mail!</center>";
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
					$_SESSION['e_loginn']="</center>Istnieje już gracz o takim nicku! Wybierz inny.</center>";
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
	<script>
		$(function(){
			if($(".Zalog").height() > 800) {
			$(".Zalog").css("padding-top","100px");
			}
			else{
				$(".Zalog").css("padding-top","50px");
			}
		});

		
	</script>
		
</head>
<body>
   <?php 
		navigation();
   ?>
    <div class="container">
        <div class="Zalog">
<form method="post">
<div class="halo">
<div class="loha">
<center>Login:</center>  <center><input type="text" name="login" id="login" /></center><br />
		
		<?php
			if (isset($_SESSION['e_loginn']))
			{
				echo '<div class="error">'.$_SESSION['e_loginn'].'</div>';
				unset($_SESSION['e_loginn']);
				echo "</br>";
			}
			
		?>
		
		<center>E-mail:</center>  <center><input type="text" name="email" id="email" /></center><br />
		
		<?php
			if (isset($_SESSION['e_emaill']))
			{
				echo '<div class="error">'.$_SESSION['e_emaill'].'</div>';
				unset($_SESSION['e_emaill']);
			}
		?>
		
		<center>Twoje hasło:</center>  <center><input type="password"  name="haslo1" class="haslo1"/></center><br />
		
		<?php
			if (isset($_SESSION['e_haslo']))
			{
				echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
				unset($_SESSION['e_haslo']);
			}
		?>		
		
		<center>Powtórz hasło:</center> <center><input type="password"  name="haslo2" class="haslo1"/></center><br />
</div>		

	</div>
	<center><div class="regulav">
	<label>
			<input type="checkbox" name="regulamin" <?php
			if (isset($_SESSION['e_regulamin']))
			{
				echo "checked";
				unset($_SESSION['e_regulamin']);
			}
				?>/>       Akceptuję regulamin
		</label></center>
		
		<?php
			if (isset($_SESSION['e_regulamin']))
			{
				echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
				unset($_SESSION['e_regulamin']);
			}
		?>	
		</div>
		<br />
		<center><input type="submit" value="Zarejestruj się" /></center>
			
    </form>

    </div>
    </div>
	<?php footer(); ?>
	<script>
        $(function(){
            $("div.container").css({"position":"sticky","background-color":"#949494"});
        });
    </script>
</body>
</body>
</html>