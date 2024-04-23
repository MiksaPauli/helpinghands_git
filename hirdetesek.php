<?php
	
	session_start();

	require "config.php";

	if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}
	// változó ahhoz hogy melyik kategória szerint keressen az oldal 
	$katId = isset($_GET['katId']) ? $_GET['katId'] : 0;
	
	$rendezes = "Datum >";
	// sorrbarakás rendezésének beállítása
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$rendezes = $_POST['sorter'];
	}
	// kereső ablak kódja
	$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    $search_condition = '';
    if (!empty($search_query)) {
        $search_condition = "SELECT * FROM posts WHERE title LIKE '%$search_query%' ORDER BY id DESC";
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
	<link rel="stylesheet" href="css/hirdetesek.css" type="text/css">

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
	<br>
	<section class="hero pt-2">
        <div class="container szelessegNovel">
			<div class="row">
				<div class="col-lg-3">
				</div>	
				<div class="col-lg-7">
					<div class="hero__search__form hirdetesek-kereso">
					<form method="GET" action="hirdetesek.php">
        				<input type="text" name="search_query" placeholder="Ird ide mit keresel"><!--Keresés ablak cím szerint-->
        				<button type="submit" class="site-btn">SEARCH</button>
    				</form>
                    </div>
				</div>
				<div  class="col-lg-2 sorrendDoboz"> <!--Sorrend választása-->
					<p class="filter-text">Rendezés:</p>
					<form method="post">
						<select name="sorter" selected="selected" onchange="this.form.submit()">
							<option value="a-z" <?php if($rendezes == "a-z"){ ?>selected<?php } ?>>A-Z</option>
							<option value="Datum <" <?php if($rendezes == "Datum <"){ ?>selected<?php } ?>>Dátum <</option>
							<option value="Datum >" <?php if($rendezes == "Datum >"){ ?>selected<?php } ?>>Dátum ></option>
						</select>
					</form>
				</div>	
			</div>	
            <div class="row">
                <div class="col-lg-2">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>Kategóriák</span>
                        </div>
                        <ul><!--Kategória választása-->
							<?php if($katId==0) { ?>
							<li><a href="hirdetesek.php?katId=0"><u>Összes kategória</u></a></li>
							<?php } else { ?>
                            <li><a href="hirdetesek.php?katId=0">Összes kategória</a></li><!--0--><!---->
							<?php } ?>
							<?php if($katId==1) { ?>
                            <li><a href="hirdetesek.php?katId=1"><u>Utazás</u></a></li><!--1-->
							<?php } else { ?>
								<li><a href="hirdetesek.php?katId=1">Utazás</a></li><!--1-->
							<?php } ?>
							<?php if($katId==2) { ?>
                            <li><a href="hirdetesek.php?katId=2"><u>Vásárlás</u></a></li><!--2-->
							<?php }else { ?>
								<li><a href="hirdetesek.php?katId=2">Vásárlás</a></li><!--2-->
							<?php } ?>
							<?php if($katId==3) { ?>
								<li><a href="hirdetesek.php?katId=3"><u>Otthon</u></a></li><!--3-->
							<?php }else { ?>
								<li><a href="hirdetesek.php?katId=3">Otthon</a></li><!--3-->
							<?php } ?>
							<?php if($katId==4) { ?>	
                            	<li><a href="hirdetesek.php?katId=4"><u>Tanítás</u></a></li><!--4-->
							<?php }else { ?>
								<li><a href="hirdetesek.php?katId=4">Tanítás</a></li><!--4-->
							<?php } ?>
							<?php if($katId==5) { ?>		
                            	<li><a href="hirdetesek.php?katId=5"><u>Egyéb</u></a></li><!--5-->
							<?php }else { ?>
								<li><a href="hirdetesek.php?katId=5">Egyéb</a></li><!--5-->
							<?php } ?>
                        </ul>
                    </div>
                </div>
        		<div class="col-lg-9">
					<div class="container hirdetesek-tabla">
						<?php 
							if ($katId == 0){
								if($rendezes == "a-z"){
									$lekerdezes = "SELECT * FROM posts WHERE status!=2 ORDER BY title";
								}else if($rendezes == "Datum <"){
									$lekerdezes = "SELECT * FROM posts WHERE status!=2 ORDER BY id ASC";
								}else{
									$lekerdezes = "SELECT * FROM posts WHERE status!=2 ORDER BY id DESC";
								}
							}else{
								//$lekerdezes = "SELECT * FROM posts WHERE category='$katId' ORDER BY id DESC";
								if($rendezes == "a-z"){
									$lekerdezes = "SELECT * FROM posts WHERE category='$katId' AND status!=2 ORDER BY title";
								}else if($rendezes == "Datum <"){
									$lekerdezes = "SELECT * FROM posts WHERE category='$katId' AND status!=2 ORDER BY id ASC";
								}else{
									$lekerdezes = "SELECT * FROM posts WHERE category='$katId' AND status!=2 ORDER BY id DESC";
								}
							}

							if(!empty($search_query)){
								$lekerdezes = $search_condition;
							}
							
							$osszes_post = $conn->query($lekerdezes);
							$adsPerPage = 5;
							$totalPages = ceil(mysqli_num_rows($osszes_post) / $adsPerPage);
							//oldal számozás kódja
							$db = 0;
							$page = 1;
							while ($post = $osszes_post->fetch_assoc()) {
								
								$db++;
								if ($db == 1 || ($db - 1) % $adsPerPage == 0) {
									echo '<div id="page'.$page.'" class="container hirdetes-maga">';
									$page++;
								}
								$userid = $post['userid'];
								$userLekerdezes = "SELECT * FROM users WHERE id='$userid'";
								$osszes_user = $conn->query($userLekerdezes);
								$felhasznalo = $osszes_user->fetch_assoc();
							?>
								<div class="hirdAnim">
									<a class="card-text" href="hirdetes.php?postid=<?= $post['id']; ?>">
										<table>
											<tr>
												<?php if ($post['mainPic'] == "default.jpg" || $post['mainPic'] == "" ){
													echo '<td rowspan="3"><img class="ad-cover-img" src="img/defaultAd.jpg"></td>';
												}else{
													echo '<td rowspan="3"><img class="ad-cover-img" src="users/'.$felhasznalo['felhasznalonev'].'/adPic/'.$post['mainPic'].'"></td>';
												}
												?>
												<td class="tdTitle" colspan="2"><b><?= htmlspecialchars($post['title']); ?></b></td>
											</tr>
											<tr>
												<?php if(strlen($post['text']) > 50){
													$adText = substr($post['text'], 0, 50)."...";
												}else{
													$adText = $post['text'];
												}
												?>
												<td colspan="2"><i><?= htmlspecialchars($adText); ?></i></td>
											</tr>
											<tr><?php 
												$category = "Egyéb";
												switch ($post['category']){
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
												<?php if ($post['status']==0){
													echo '<td colspan="2">'.$category.' | '.$post['location'].' | '.$post['uploadDate'].'</td>';
												}else if ($post['status']==1){
													echo '<td colspan="2">Jegelve!</td>';
												}
												?>
												<!--<td colspan="2">Hely, hirdetés tipus stb.</td>-->
											</tr>
										</table>
									</a>
									<br><br>
								</div>
							<?php
								if ($db % $adsPerPage == 0 || $db == mysqli_num_rows($osszes_post)) {
									echo '</div>';
								}
							}
							?>
						<div class="pageButtons">    
							<?php
							// Gombok generálása minden oldalhoz (oldalszám gombok)
							if ($totalPages > 1) {
								for ($i = 1; $i <= $totalPages; $i++) {
									echo '<button class="numbtn" onclick="openPage(' . $i . ')">' . $i . '</button>';
									if ($i > 1) {
										echo '<script>document.getElementById("page' . $i . '").style.display = "none";</script>';
									}
								}
							}
							?>
						</div>
					</div>
				</div>
				<div  class="col-lg-1 sorrendDoboz">
				</div>
			</div>		
		</div>
	</section>
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
<script>

	function openPage(pageNumber){
		// Összes oldal eltüntetése
		for (let i = 1; i <= <?= $totalPages ?>; i++) {
			document.getElementById("page" + i).style.display = "none";
		}
		// kiválasztott oldal mutatása
		document.getElementById("page" + pageNumber).style.display = "block";
	}

</script>
</html>
<style>
	.card-text{
		color: black;
	}
	.card-text:hover{
		color: #7fad39;
	}
</style>
