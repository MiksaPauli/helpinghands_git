<?php 

	require "config.php";
	
	require "functions.php";

  if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}

  // bejelentkezés | beállítjuk benne aszerint hogy a felhasználó mit választott hogy cookie-t vagy session-t használjunk
	if(isset($_POST['loginbtn'])){
		
		$email = $_POST['email'];
		$pass = $_POST['password'];
		
		$lekerdezes = "SELECT * FROM users WHERE email='$email'";
		$talalt_felhasznalo = $conn->query($lekerdezes);
		
		if(mysqli_num_rows($talalt_felhasznalo) == 1){
			$felhasznalo = $talalt_felhasznalo->fetch_assoc();
			if(password_verify($pass, $felhasznalo['password'])){
				
        if($_SESSION['cookie'] == 1){
          setcookie( "userID" , $felhasznalo['id'] , time() + (86400*30), "/" );
          setcookie( "userEmail" , $felhasznalo['email'] , time() + (86400*30), "/" );
          setcookie( "userVeznev" , $felhasznalo['vezeteknev'] , time() + (86400*30), "/" );
          setcookie( "userKernev" , $felhasznalo['keresztnev'] , time() + (86400*30), "/" );
          setcookie( "userFelhnev" , $felhasznalo['felhasznalonev'] , time() + (86400*30), "/" );
        }else{
          $_SESSION['id'] = $felhasznalo['id'];
          $_SESSION['email'] = $felhasznalo['email'];
          $_SESSION['vezeteknev'] = $felhasznalo['vezeteknev'];
          $_SESSION['keresztnev'] = $felhasznalo['keresztnev'];
          $_SESSION['felhasznalonev'] = $felhasznalo['felhasznalonev'];
        }
				
				header("Location: index.php?id=".$felhasznalo['id']);
				
			}
			else{
				echo "<script>alert('Helytelen jelszó!')</script>";
			}
		}
		else{
			echo "<script>alert('Nem találtunk ilyen email címet!')</script>";
		}
		
	}
	
  // function.php ba található a regsztráció function-je
	if(isset($_POST['registbtn'])){
		Reg($_POST['vezeteknev'], $_POST['keresztnev'], $_POST['felhasznalonev'], $_POST['email'], $_POST['password']);	
	}
	

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <script src="https://kit.fontawesome.com/6881cff645.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/log_reg_style.css" type="text/css">
    <title>HelpingHands</title>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">

  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
		
			<!--LOGIN rész-->
          <form method="post" action="reg_log.php" class="sign-in-form">
            <h2 class="title">Bejelentkezés</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Email" name="email"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" placeholder="Jelszó" name="password"/>
            </div>
            <input type="submit" value="BEJELENTKEZEK" class="btn solid logbtn" name="loginbtn"/>
            <a href="passReminder.php" class="al">Elfelejtettem a jelszavam</a><style> .al{ text-decoration: none; color: black;} .al:hover{ color: #7fad39;} </style>
            <br>
            <a href="index.php" class="al">Vissza a főoldalra</a>
          </form>
		  <!--LOGIN-->
		  
		  
		  <!--REGISZT rész-->
    <form method="post" action="reg_log.php" class="sign-up-form">
            <h2 class="title">Regisztráció</h2>
			<div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Vezetéknév" name="vezeteknev" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ]/g, '')"/> <!--Csak is a megadott karaktereket engedjük-->
            </div>
			<div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Keresztnév" name="keresztnev" oninput="this.value = this.value.replace(/[^a-zA-ZáéíóöőúüűÁÉÍÓÖŐÚÜŰ]/g, '')"/>
            </div>
			<div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" placeholder="Felhasználónév" name="felhasznalonev" oninput="this.value = this.value.replace(/[^a-zA-Z0-9áéíóöőúüűÁÉÍÓÖŐÚÜŰ]/g, '')"/>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" placeholder="Email" name="email"/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" id="password" placeholder="Jelszó" name="password"/>
            </div>
			<div class="pass">
        <label><span id="length-check"></span>  A jelszavad legalább 8 karakter hosszú legyen!</label><br>
        <label><span id="upper-check"></span>  A jelszavad tartalmazzon minimum egy nagybetűt!</label>
			</div>
			<div class="checksty">
				<input type="checkbox"required> Az <a href="dataSec.html" target="_blank">Adatvédelmi nyilatkozatot</a> és a <a href="rules.html" target="_blank">Szabályzatot</a> elolvastam és elfogadom.
			</div>
            <input type="submit" class="btn" value="REGISZTRÁLOK" name="registbtn"/>
            <a href="index.php" class="al">Vissza a főoldalra</a>
    </form>
        </div>
      </div>
	   <!--REGISZT-->

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Nincs még fiókod?</h3>
            <p>
              A "Regisztráció" gombra nyomva regisztrálhatsz egy új fiókot.
            </p>
            <button class="btn transparent" id="sign-up-btn">
              REGISZTRÁCIÓ
            </button>
          </div>
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Van már fiókod?</h3>
            <p>
              A "Bejelentkezés" gombra nyomva bejelentkezhetsz a fiókodba.
            </p>
            <button class="btn transparent" id="sign-in-btn">
              BEJELENTKEZÉS
            </button>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<script>
	// csekkoljuk hogy a jelszó megfelel e az elvárásoknak
	function validatePassword() {
        var password = document.getElementById('password').value;
        if (password.length >= 8 && containsUppercase(password)) {
            return true; 
        } else {
            alert('A jelszónak legalább 8 karakter hosszúnak kell lennie és tartalmaznia kell legalább egy nagybetűt!');
            return false; 
        }
    }

    
    function containsUppercase(str) {
        return /[A-Z]/.test(str);
    }

    
    document.getElementById('password').addEventListener('keyup', function (e) {
        var password = e.target.value;

        if (password.length >= 8) {
            document.getElementById('length-check').innerHTML = ' <i class="fa-solid fa-square-check"></i> ';
        } else {
            document.getElementById('length-check').innerHTML = '';
        }

        if (containsUppercase(password)) {
            document.getElementById('upper-check').innerHTML = ' <i class="fa-solid fa-square-check"></i>';
        } else {
            document.getElementById('upper-check').innerHTML = '';
        }
    });

    
    document.querySelector('.sign-up-form').addEventListener('submit', function (e) {
        if (!validatePassword()) {
            e.preventDefault(); 
        }
    });
</script>
<script src="js/app.js"></script>
<style>
  @media (max-width: 768px) {
        .pass{
          height: 110px;
        }
    }
</style>
