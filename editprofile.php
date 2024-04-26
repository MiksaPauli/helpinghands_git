<?php 

	session_start();

	require "config.php";
	
	$userid = $_GET['userid'];
	
	if(empty($userid)){
		header("Location: reg_log.php");
	}

	if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}
	
	// Ha egyik session vagy cookie sem létezik
	if (!isset($_SESSION['id']) && !isset($_COOKIE['userID'])) {
		header("Location: reg_log.php");
		exit();
	}

	if ($_SESSION['id'] != $userid && $_COOKIE['userID'] != $userid) {
		// Ha nem egyezik meg, akkor átirányítjuk a felhasználót a saját profiljának szerkesztő oldalára
		/*if(!empty($_COOKIE['userID'])){
			header("Location: editprofile.php?userid=" . $_COOKIE['userID']);
		}
		header("Location: editprofile.php?userid=" . $_SESSION['id']);*/
		header("Location: index.php");
		
		exit();
	}
	
	

	$lekerdezes = "SELECT * FROM users WHERE id=$userid";
	$talalt_felhasznalo = $conn->query($lekerdezes);
	$felhasznalo = $talalt_felhasznalo->fetch_assoc();
	//profilkép feltöltése
	if(isset($_POST['upload-btn'])){
		$file_name = $_FILES['new_img']['name'];
		$tmp = $_FILES['new_img']['tmp_name'];
		//Fájl típusa
		$file_type = $_FILES['new_img']['type'];
		
		//Elfogadott kiterjesztések
		$allowed = array("image/jpeg", "image/gif", "image/png");
		
		if(in_array($file_type, $allowed)){
			$curdir = getcwd();
			
			$eleresiut = $curdir."/users/".$felhasznalo['felhasznalonev']."/profilePic/".$file_name;
			
			if(move_uploaded_file($tmp, $eleresiut)){
				echo "<script>alert('Kép sikeresen feltöltve!')</script>";
			}
			
			$conn->query("UPDATE users SET prof_img='$file_name' WHERE id=$userid");
			
			header("Location: editprofile.php?userid=$userid");
		}
		else{
			echo "<script>alert('Nem megfelelő formátum!')</script>";
		}
	}
	// profil szerkesztése
	if(isset($_POST['profil-btn'])){
		$vezeteknev = $_POST['vezeteknev'];
		$keresztnev = $_POST['keresztnev'];
		$email = $_POST['email'];
		$conn->query("UPDATE users SET vezeteknev='$vezeteknev',keresztnev='$keresztnev',email='$email' WHERE id=$userid");
		header("Location: profile.php?userid=$userid");
	}
	// helszó frissitése
	if(isset($_POST['password-btn'])){
		$jelenlegi = $_POST['jelenlegi'];
		$uj = $_POST['uj'];
		$lekerdezes = "SELECT password FROM users WHERE id=$userid";
		$talalt_felhasznalo = $conn->query($lekerdezes);
		$felhasz = $talalt_felhasznalo->fetch_assoc();
		$jelenjelszo = $felhasz['password'];
		if(empty($_POST['jelenlegi']) || empty($_POST['uj'])){
			echo "<script>alert('Minden mezőt kikell tölteni!')</script>";
		}else{
			if($jelenlegi == $uj){
				echo "<script>alert('A jelszók ugyanazok!')</script>";
			}else{
				if(password_verify($jelenlegi,$jelenjelszo)){
					$hashed_pass = password_hash($uj, PASSWORD_DEFAULT);
					$conn->query("UPDATE users SET password = '$hashed_pass' WHERE id=$userid");
					header("Location: profile.php?userid=$userid");
				}else{
					echo "<script>alert('A jelenlegi jelszók nem egyeznek')</script>";
				}
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="hu">
	<head>
	<meta charset="UTF-8">
    <meta name="description" content="Helpinghands">
    <meta name="keywords" content="Helpinghands, helping, hands">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="robots" content="noindex, nofollow" />
    <title>Helping Hands</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
	<link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/profil_css.css" type="text/css">

	<!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">

	<!--AJAX-->
	<script src="https://code.jquery.com/jquery-latest.js"></script>
	</head>
	<body>
	
	<div id="headerOne">
        <?php include 'header.php';?>
    </div>
	
	
	
	<div class="container cardsty">
		<?php
			if($felhasznalo['prof_img']=="default.jpg"){
				echo '<img class="profimg2" src="img/default.jpg">';
			}
			else{
				echo '<img class="profimg2" src="users/'.$felhasznalo['felhasznalonev'].'/profilePic/'.$felhasznalo['prof_img'].'">';
			}		
		?>
		<form method="post" action="editprofile.php?userid=<?= $userid; ?>" enctype="multipart/form-data">
			<input type="file" name="new_img" id="actual-btn" hidden>
			<label for="actual-btn" id="cucc"><i class="fa-solid fa-image"></i></label>
			<span id="file-chosen"></span>
			<input type="submit" name="upload-btn" value="Feltöltés" id="upsty">
		</form>
			
		<div class="container">
			<div class="row ">
				<div class="col">
					<form method="post" action="editprofile.php?userid=<?= $userid; ?>" id="adatsty">
						<label for="lab1">Vezetéknév:</label>
						<input type="text" id="lab1" name="vezeteknev" value="<?= $felhasznalo['vezeteknev']; ?>"><br>
						<label for="lab2">Keresztnév:</label>
						<input type="text" id="lab2" name="keresztnev" value="<?= $felhasznalo['keresztnev']; ?>"><br>
						<label for="lab3">Email:</label>
						<input type="email" id="lab3" name="email" value="<?= $felhasznalo['email']; ?>"><br>
						<input type="submit" name="profil-btn" id="adatfel" value="Adatok frissítése">
					</form>
				</div>
				<div class="col">
					<form method="post" action="editprofile.php?userid=<?= $userid; ?>" id="passsty">
						<label for="lab4">Jelenlegi jelszó:</label>
						<input type="password" id="lab4" name="jelenlegi"><br>
						<label for="lab5">Új jelszó:</label>
						<input type="password" id="lab5" name="uj"><br>
						<input type="submit" name="password-btn" value="Jelszó frissítése">
					</form>
				</div>
			</div>
		</div>
		<?php if(isset($_COOKIE["userID"])){ 
			$felhID = $_COOKIE["userID"];
			?>
			<a href="profile.php?userid=<?= $felhID ?>" id="profszer">Vissza a profilra</a>
		<?php }else{ ?>
			<a href="profile.php?userid=<?= $_SESSION['id'] ?>" id="profszer">Vissza a profilra</a>
		<?php } ?>		
	</div>


<script>
	const actualBtn = document.getElementById('actual-btn');

	const fileChosen = document.getElementById('file-chosen');

	actualBtn.addEventListener('change', function(){
	  fileChosen.textContent = this.files[0].name
	})
</script>
	
	
	
	<div id="footerOne">
		<?php include 'footer.php';?>
    </div>
	
</body>
</html>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/jquery.slicknav.js"></script>
<script src="js/mixitup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/main.js"></script>
<script src="https://kit.fontawesome.com/6881cff645.js" crossorigin="anonymous"></script>
<style>
  @media (max-width: 768px) {
		.cardsty{
			height: 700px;
			text-align: center;
			border-top: 0;
			position: realtive;
		}
		#adatfel{
			margin: 10px;
			margin-bottom: 20px;
		}
		#jelszofel{
			margin: 10px;
		}
		#profszer{
			background-color: #008000;
			border: 1px solid black;
			padding: 6px;
			color: white;
			font-weight: bold;
			font-size: 15px;
			width: 150px;
			letter-spacing: 2px;
			margin-top: 20px;
		}
    }
</style>