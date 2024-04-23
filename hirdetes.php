<?php
	
	session_start();
	
	require "config.php";
	
	if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}

	$post = $_GET['postid'];
	$_SESSION['Post'] = $post;

	if(isset($_POST['comment-btn']) && $_POST['comment-text']!="" && (!empty($_SESSION['id']) || !empty($_COOKIE['userID']))){ //Poszt komment
		$comment_text = $_POST['comment-text'];
		if(!empty($_SESSION['id'])){
			$conn->query("INSERT INTO comments VALUES(id, $post,  $_SESSION[id], '$comment_text', '0')");
		}else{
			$conn->query("INSERT INTO comments VALUES(id, $post,  $_COOKIE[userID], '$comment_text', '0')");
		}
		header('Location: hirdetes.php?postid=' . $_SESSION['Post']);
		exit(); 
	}
	else if(isset($_POST['comment-btn']) && $_POST['comment-text']=="" && (!empty($_SESSION['id']) || !empty($_COOKIE['userID']))){ 
		echo '<script>alert("Kommentet ki fog írni?");</script>'; 
	}
	else if(isset($_POST['comment-btn']) && (empty($_SESSION['id']) && empty($_COOKIE['userID']))){
		header('Location: reg_log.php');
	} 
	
	if(isset($_POST['onComment-btn']) && $_POST['onComment-text']!="" && (!empty($_SESSION['id']) || !empty($_COOKIE['userID']))){ //Kommenten komment
		$Oncomment_text = $_POST['onComment-text'];
		$commentid= $_GET['commentid'];
		if(!empty($_SESSION['id'])){
			$conn->query("INSERT INTO comments VALUES(id, $post,  $_SESSION[id], '$Oncomment_text', '$commentid')");
		}else{
        	$conn->query("INSERT INTO comments VALUES(id, $post,  $_COOKIE[userID], '$Oncomment_text', '$commentid')");
        }
		header('Location: hirdetes.php?postid=' . $_SESSION['Post']);
		exit(); 
	}
	else if(isset($_POST['onComment-btn']) && $_POST['onComment-text']=="" && (!empty($_SESSION['id']) || !empty($_COOKIE['userID']))){ 
		echo '<script>alert("Elfelejetted megírni a kommented");</script>'; 
	}
	else if(isset($_POST['onComment-btn']) && (empty($_SESSION['id']) && empty($_COOKIE['userID']))){
		header('Location: reg_log.php');
	}
	// jelentés gomb
	if(isset($_POST['reportbtn'])){
		if(isset($_SESSION['id'])){
			$user_id = $_SESSION['id'];
		}else if(isset($_COOKIE['userID'])){
			$user_id = $_COOKIE['userID'];
		}else{
			header('Location: reg_log.php');
		}
		$lekerdezes = "SELECT * FROM reports WHERE userid = $user_id AND postid = $post";	
		$eredmeny = $conn->query($lekerdezes);
		if($eredmeny->num_rows==0){
			$conn->query("UPDATE posts SET reports = reports+1 WHERE id = $post");
			$conn->query("INSERT INTO reports VALUES(id,$user_id,$post)");
			echo '<script>alert("Sikeresen feljelentetted");</script>';
		}else{
			echo '<script>alert("Már feljelentetted egyszer");</script>';
		}
	}
?>
<!DOCTYPE html>
<html lang="hu">

<head>
	<meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="robots" content="noindex, nofollow" />
    <title>Helping Hands</title>
	
	<!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="css/style.css" type="text/css">
	<link rel="stylesheet" href="css/sajat_css.css" type="text/css">
	<link rel="stylesheet" href="css/hirdetes.css" type="text/css">

	<!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">
	
	<!--AJAX-->
	<script src="https://code.jquery.com/jquery-latest.js"></script>
	
</head>
<body>

	<!-- Header Section  -->
    <div id="headerOne">
        <?php include 'header.php';?>
    </div>

	<div class="hirdetes-body">
		<?php

			$lekerdezes = "SELECT * FROM posts WHERE id=$post";
			$osszes_post = $conn->query($lekerdezes);
			$hirdetes = $osszes_post->fetch_assoc();

			switch ($hirdetes['category']){
				case 1:
                    $category = "Utazás";
                    break;
                case 2:
                    $category = "Vásárlás";
                    break;
                case 3:
                    $category = "Otthon";
                    break;
                case 4:
                    $category = "Tanítás";
                    break;
                case 5:
                    $category = "Egyéb";
                    break;
				default:
				    $category = "Egyéb";
					break;	
			}
			
			$lek_felhasznalohoz = "SELECT * FROM users WHERE id=$hirdetes[userid]";
			$talalt_felhasznalo = $conn->query($lek_felhasznalohoz);
			$felhasznalo=$talalt_felhasznalo->fetch_assoc();
		?>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 hirdetes-card"><!--cím és képek-->
					<h1 class="title"><?= $hirdetes['title'];?></h1>
					<br><br>
					<div class="row" id="row">
						<div class="col-sm-7">
							<?php if($hirdetes['mainPic']!="default.jpg"){ ?>    
							<img class="main-picture" src="users/<?= $felhasznalo['felhasznalonev'] ?>/adPic/<?= $hirdetes['mainPic'] ?>">
							<?php }else{ ?>
								<img class="main-picture" src="img/defaultAd.jpg">
							<?php } ?>	
						</div>
						<div class="col-sm-5">
						<?php if($hirdetes['secondPic']!="default.jpg"){ ?>
							<img class="main-picture" src="users/<?= $felhasznalo['felhasznalonev'] ?>/adPic/<?= $hirdetes['secondPic'] ?>">
						<?php }else{ ?>
							<img class="main-picture" src="img/defaultAd.jpg">
						<?php } ?>	
						<?php if($hirdetes['thirdPic']!="default.jpg"){ ?>
							<img class="main-picture" src="users/<?= $felhasznalo['felhasznalonev'] ?>/adPic/<?= $hirdetes['thirdPic'] ?>">
						<?php }else{ ?>
							<img class="main-picture" src="img/defaultAd.jpg">
						<?php } ?>	
						</div>  
					</div>
					<br><br>
					<h3><i>Leirás</i></h3>
					<hr>
					<p><?= htmlspecialchars($hirdetes['text']); ?></p>
					<hr>
					<?php if($hirdetes['status']== 0){$hirStatus="Aktív";}else if($hirdetes['status']== 1){$hirStatus="Jegelve";}else{$hirStatus="Letíltva";} ?>
					<h3><i>Adatok</i></h3>
					<p>Hely: <?= htmlspecialchars($hirdetes['location']) ?><br> Kategória: <?= $category ?><br> Közzétéve: <?= $hirdetes['uploadDate'] ?><br> Státusz: <?= $hirStatus?></p>
					<form method="post" action="hirdetes.php?postid=<?= $_SESSION['Post']; ?>">
						<button class="report custom-btn btn-13" name="reportbtn">&#128681; Jelentés &#128681;</button>
					</form>	
				</div>	
				<div class="col-sm-3 profil-card">
					<h3><b><a href="profile.php?userid=<?= $felhasznalo['id']; ?>"><?= htmlspecialchars($felhasznalo['keresztnev']); ?> <?= htmlspecialchars($felhasznalo['vezeteknev']); ?></a></b></h3>
				<?php
					if($felhasznalo['prof_img']=="default.jpg"){
						echo '<img class="img-profil" src="img/default.jpg">';
					}
					else{
						echo '<img class="img-profil" src="users/'.$felhasznalo['felhasznalonev'].'/profilePic/'.$felhasznalo['prof_img'].'">';
					}		
				?>
				</div>		
			</div>
		</div><!--Komment szekció-->
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-8 hirdetes-card">
				<h3><i>Hozzászólások:</i></h3>
				<br><br>	
				<form method="post" action="hirdetes.php?postid=<?= $_SESSION['Post']; ?>">
					<input type="text" name="comment-text" placeholder="Hozzászólás">
					<!--<input type="submit" value="Hozzászólok!" name="comment-btn">-->
					<button class="custom-btn btn-5" name="comment-btn">Hozzászólok</button>
				</form>
				<?php
					$lekerdezes = "SELECT * FROM comments WHERE postid=$post AND commentid='0'";
					$talalt_kommentek = $conn->query($lekerdezes);
					while($komment=$talalt_kommentek->fetch_assoc()){
						
						$lekerdezes = "SELECT * FROM users WHERE id=$komment[userid]";
						$talalt_felhasznalo = $conn->query($lekerdezes);
						$felhasznalo = $talalt_felhasznalo->fetch_assoc();
						?>
						<hr>
						<p><a href="profile.php?userid=<?= $felhasznalo['id']?>"><?= htmlspecialchars($felhasznalo['keresztnev']); ?></a>: <?= htmlspecialchars($komment['text']); ?></p>
						<form style="margin-left: 50px;" method="post" action="hirdetes.php?commentid=<?= $komment['id']; ?>&postid=<?= $_SESSION['Post']; ?>">
							<input type="text" name="onComment-text" placeholder="Válasz">
							<!--<input type="submit" value="Válaszolok!" name="onComment-btn">-->
							<button class="custom-btn btn-5" name="onComment-btn">Válasz</button>
						</form>
						<?php
						$lekerdezes = "SELECT * FROM comments WHERE postid=$post AND commentid=$komment[id]";
						$talalt_OnKommentek = $conn->query($lekerdezes);
						while($Onkomment=$talalt_OnKommentek->fetch_assoc()){
							
							$lekerdezes = "SELECT * FROM users WHERE id=$Onkomment[userid]";
							$talalt_OnFelhasznalo = $conn->query($lekerdezes);
							$felhasznalo = $talalt_OnFelhasznalo->fetch_assoc();
							?>
							<p style="margin-left: 50px;"><a href="profile.php?userid=<?= $felhasznalo['id']?>"><?= htmlspecialchars($felhasznalo['keresztnev']); ?></a>: <?= htmlspecialchars($Onkomment['text']); ?></p>
						<?php } ?>
						
					<?php } ?>	
				</div>	
			</div>	
		</div>
	</div>

	<div id="footerOne">
		<?php include 'footer.php';?>
    </div>
	
	<!--Js-->
	<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
	<script src="https://kit.fontawesome.com/6881cff645.js" crossorigin="anonymous"></script>

</body>
</html>
<style>
	@media (max-width: 900px){
		.hirdetes-card{
			width: 100%;
			margin-left: 0;
		}
		.profil-card{
			width: 100%;
			margin-left: 0;
		}
		.title{
			font-size: 30px;
		}
	}
</style>