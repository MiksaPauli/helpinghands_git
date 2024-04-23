<?php 

	$userid = $_GET['userid'];
	
	session_start();

	require "config.php";

	if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}
	
	//lekérdezzük a felhasználót
	$lekerdezes = "SELECT * FROM users WHERE id=$userid";
	$talalt_felhasznalo = $conn->query($lekerdezes);
	$felhasznalo = $talalt_felhasznalo->fetch_assoc();
	
	// hirdetés törlését ez végzi
	if(isset($_POST['hirtor-btn'])){
		$postId = $_POST['id'];
        
        $sql_select_pics = "SELECT mainPic, secondPic, thirdPic, userid FROM posts WHERE id = $postId";
        $talalt_hirdetes = $conn->query($sql_select_pics);
        $hirdetes = $talalt_hirdetes->fetch_assoc();

        $lekerdezes = "SELECT * FROM users WHERE id = $hirdetes[userid]";
        $osszes_user = $conn->query($lekerdezes);
        $felhasznalo = $osszes_user->fetch_assoc();

        $jelenlegi_mappa = getcwd();

        
		// hozzá tartozó képek törlése
        $path = $jelenlegi_mappa."/users/".$felhasznalo['felhasznalonev']."/adPic/".$hirdetes['mainPic'];

        
        if($hirdetes['mainPic'] != "default.jpg"){
            if(file_exists($path)){
                unlink($path);
            }
        }

        $path = $jelenlegi_mappa."/users/".$felhasznalo['felhasznalonev']."/adPic/".$hirdetes['secondPic'];
        
        if($hirdetes['secondPic'] != "default.jpg"){
            if(file_exists($path)){
                unlink($path);
            }
        }

        $path = $jelenlegi_mappa."/users/".$felhasznalo['felhasznalonev']."/adPic/".$hirdetes['thirdPic'];
        
        if($hirdetes['thirdPic'] != "default.jpg"){
            if(file_exists($path)){
                unlink($path);
            }
        }
        
        // Hirdetés törlése az adatbázisból
        $sql_delete_post = "DELETE FROM posts WHERE id = ?";
        $stmt_delete_post = $conn->prepare($sql_delete_post);
        $stmt_delete_post->bind_param('i', $postId);
        $stmt_delete_post->execute();

		$delete_comments ="DELETE FROM comments WHERE postid = $postId";
        $delete = $conn->query($delete_comments);
    
        header("Location: profile.php?userid=" . urlencode($felhasznalo['id']));
        //echo $path;
	}


	//hirdetések fagyasztása (státusz átállítása)
	if(isset($_POST['hirfagy-btn'])){
		$postId = $_POST['id'];
        
        $stmt = "UPDATE posts SET status=1 WHERE id=$postId";
        $fagy = $conn->query($stmt);
		header("Location: profile.php?userid=" . urlencode($felhasznalo['id']));
	}

	// fagyasztott hirdetések kifagyasztása (-||-)
	if(isset($_POST['hirvissza-btn'])){
		$postId = $_POST['id'];
        
        $stmt = "UPDATE posts SET status=0 WHERE id=$postId";
        $vissza = $conn->query($stmt);
		header("Location: profile.php?userid=" . urlencode($felhasznalo['id']));
	}

	// ha le van tiltva a hirdetés akkor ez a gomb jelenik meg
	if(isset($_POST['hirtiltva-btn'])){
		echo "<script> alert('Hirdetése tiltva lett mert megszegte a szabályokat')</script>";
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
	<link rel="stylesheet" href="css/sajat_css.css" type="text/css">

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
		<!--Ha a session/cookie megegyezik a felhasználó id ával az azt jelenti hogy a felhasználó a saját profilját nézi és így látni fog profil meg hirdetés menedzsment opciókat-->
		<?php
			if((!isset($_SESSION['id']) || $userid !=$_SESSION['id']) && (!isset($_COOKIE["userID"]) || $userid != $_COOKIE["userID"])){
		?>
		<div class="container profstyle">
			<?php
				if($felhasznalo['prof_img']=="default.jpg"){
					echo '<img class="profimg" src="img/default.jpg">';
				}
				else{
					echo '<img class="profimg" src="users/'.$felhasznalo['felhasznalonev'].'/profilePic/'.$felhasznalo['prof_img'].'">';
				}		
			?>		
	<h3 id="kv"><b><?= htmlspecialchars($felhasznalo['vezeteknev']); ?> <?= htmlspecialchars($felhasznalo['keresztnev']); ?></b></h3>
	<h4 id="em"><b><?= htmlspecialchars($felhasznalo['email']); ?></b></h4>
</div>

		<?php
			$lekerdezes = "SELECT * FROM posts WHERE userid=$userid";
			$osszes_post = $conn->query($lekerdezes);
			while($hirdetes = $osszes_post->fetch_assoc()){
		?>
			<div class="container hirdetesek-tabla">
					<table>
						<tr>
							<?php if ($hirdetes['mainPic'] == "default.jpg" || $hirdetes['mainPic'] == "" ){
								echo '<td rowspan="3"><img class="ad-cover-img" src="img/defaultAd.jpg"></td>';
							}else{
								echo '<td rowspan="3"><img class="ad-cover-img" src="users/'.$felhasznalo['felhasznalonev'].'/adPic/'.$hirdetes['mainPic'].'"></td>';
							}
							?>
							<td colspan="2"><?= htmlspecialchars($hirdetes['title']); ?></td>
						</tr>
						<tr>
						<?php if(strlen($hirdetes['text']) > 50){ // ha hosszabb mint 50 karakter akkor ... al levágja a többit
								$adText = substr($hirdetes['text'], 0, 50)."...";
							}else{
								$adText = $hirdetes['text'];
							}
							?>
							<td colspan="2"><i><?= htmlspecialchars($adText); ?></i></td>
						</tr>
						<tr><?php 
							$category = "Egyéb";
							switch ($hirdetes['category']){
									case 0 :
										$category = "Egyéb";
										break;
									case 1 : 
										$category = "Utazás";
										break;
									case 2 :
										$category = "Vásárlás";
										break;
									case 3 : 
										$category = "Otthon";
										break;
									case 4 :
										$category = "Tanítás";
										break;
									case 5 :
										$category = "Egyéb";
										break;
									default :		
							} 
						?>
							<?php if ($hirdetes['status']==0){
								echo '<td colspan="2">'.$category.' | '.htmlspecialchars($hirdetes['location']).' | '.$hirdetes['uploadDate'].'</td>';
							}else if ($hirdetes['status']==1){
								echo '<td colspan="2">Jegelve!</td>';
							}
							?>
							<!--<td colspan="2">Hely, hirdetés tipus stb.</td>-->
						</tr>
					</table>
			</div>
			
			<?php
			}
		?>

			
			<?php
			}else{
		?>
		
			<div class="container profstyle">
		<?php
			if($felhasznalo['prof_img']=="default.jpg"){
				echo '<img class="profimg" src="img/default.jpg">';
			}
			else{
				echo '<img class="profimg" src="users/'.$felhasznalo['felhasznalonev'].'/profilePic/'.$felhasznalo['prof_img'].'">';
			}		
		?>		
	<h3 id="kv"><b><?= htmlspecialchars($felhasznalo['vezeteknev']); ?> <?= htmlspecialchars($felhasznalo['keresztnev']); ?></b></h3>
	<h4 id="em"><b><?= htmlspecialchars($felhasznalo['email']); ?></b></h4>
	<?php if(!empty($_SESSION['id'])){ ?>
		<a href="editprofile.php?userid=<?= $_SESSION['id']; ?>" id="profszer">Profil szerkesztése</a>
		<a href="hirdetesFel.php?" id="hirfel">Hirdetés feladás</a><!--session kicserélve userid ra hogy működjön-->
	<?php } else { ?>
		<a href="editprofile.php?userid=<?= $_COOKIE['userID']; ?>" id="profszer">Profil szerkesztése</a><!--cookie kicserélve userid ra hogy működjön-->
		<a href="hirdetesFel.php?" id="hirfel">Hirdetés feladás</a>
	<?php } ?>	
</div>

		<?php
			$lekerdezes = "SELECT * FROM posts WHERE userid=$userid GROUP BY id DESC";
			$osszes_post = $conn->query($lekerdezes);
			while($hirdetes = $osszes_post->fetch_assoc()){
		?>
			<div class="container hirdetesek-tabla">
					<table>
						<tr>
							<?php if ($hirdetes['mainPic'] == "default.jpg" || $hirdetes['mainPic'] == "" ){
								echo '<td rowspan="3"><img class="ad-cover-img" src="img/defaultAd.jpg"></td>';
							}else{
								echo '<td rowspan="3"><img class="ad-cover-img" src="users/'.$felhasznalo['felhasznalonev'].'/adPic/'.$hirdetes['mainPic'].'"></td>';
							}
							?>
							<td colspan="2"><?= $hirdetes['title']; ?></td>
							<td rowspan="3">
								<form method="post" action="profile.php?userid=<?= $userid ?>" id="hirform">
									<input type="hidden" name="id" value="<?= $hirdetes['id']; ?>">
									<?php if($hirdetes['status']==0){ ?>
									<input type="submit" class="fagy" name="hirfagy-btn" value="Fagyasztás">
									<?php }else if($hirdetes['status']==1){?>
									<input type="submit" class="vissza" name="hirvissza-btn" value="Kifagyaszt">
									<?php }else{?>
									<input type="submit" class="tiltva" name="hirtiltva-btn" value="Letiltva">
									<?php }?>	
									<input type="submit" class="torles" name="hirtor-btn" value="Törlés">
								</form>
							</td>
						</tr>
						<tr>
						<?php if(strlen($hirdetes['text']) > 50){
								$adText = substr($hirdetes['text'], 0, 50)."...";
							}else{
								$adText = $hirdetes['text'];
							}
							?>
							<td colspan="2"><i><?= htmlspecialchars($adText); ?></i></td>
						</tr>
						<tr>
						<?php 
							$category = "Egyéb";
							switch ($hirdetes['category']){
									case 0 :
										$category = "Egyéb";
										break;
									case 1 : 
										$category = "Utazás";
										break;
									case 2 :
										$category = "Vásárlás";
										break;
									case 3 : 
										$category = "Otthon";
										break;
									case 4 :
										$category = "Tanítás";
										break;
									case 5 :
										$category = "Egyéb";
										break;
									default :		
							} 
						
							 if ($hirdetes['status']==0){
								echo '<td colspan="2">'.$category.' | '.$hirdetes['location'].' | '.$hirdetes['uploadDate'].'</td>';
							}else if ($hirdetes['status']==1){
								echo '<td colspan="2">Jegelve!</td>';
							}else{
								echo '<td colspan="2">Letiltva</td>';
							}
							?>
						</tr>
					</table>
			</div>
		
		<?php
			}
		?>
		
		<?php
			}
		?>
		
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