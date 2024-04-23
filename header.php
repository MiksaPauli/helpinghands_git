<?php
	
	require "config.php";

	session_start();

	$current_page = basename($_SERVER['REQUEST_URI']); // ahhoz hogy tudjuk melyik nav elem legyen akttív

	if(isset($_COOKIE["userID"])){
		$userID = $_COOKIE["userID"];
	}else if(isset($_SESSION['id'])){
		$userID = $_SESSION['id'];
	}else{
		$userID ="";
	}
	
?>
	<link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="css/logBtn.css" type="text/css"> <!--Néhány header css itt van-->
	<header class="border border-dark border-top-0 border-left-0 border-right-0">
        <div class="container" id="headerOne">
			<div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
						<?php
						if($userID != ""){
						?>
							<a href="index.php?id=<?= $userID ?>"><img class="logo" src="img/HH_logo_Side.png" alt=""></a>
						<?php	
						}else{
						?>	
						<a href="index.php"><img class="logo" src="img/HH_logo_Side.png" alt=""></a>
					    <?php } ?>

                    </div>
                </div>
                <div class="col-lg-8">
                    <nav class="menu navbar navbar-expand-sm">
						<div class="container-fluid">
							<ul class="navbar-nav"><?php
								if(strpos($current_page , 'index.php') !== false){ // eredeti if : !empty($_SESSION['id']) // attól függően hogy melyik oldalon vagyunk aszerint mutatjuk az aktív elemet
								?>	
									<li class="active nav-item"><a href="index.php">Kezdőlap</a></li>
								<?php } else{?>
									<li class="nav-item"><a href="index.php">Kezdőlap</a></li>
								<?php }
								if(strpos($current_page , 'hirdetesek.php') !== false){
								?>	
									<li class="active nav-item"><a href="hirdetesek.php">Hirdetések</a></li>
								<?php } else{?>
									<li class="nav-item"><a href="hirdetesek.php">Hirdetések</a></li>
								<?php } ?>
								<?php if($userID != ""){?>
									<?php if(strpos($current_page , 'hirdetesFel.php') !== false){ ?>
									<li class="active nav-item"><a href="hirdetesFel.php">Hirdetés feltöltés</a></li>
									<?php } else{?>
                                    <li class="nav-item"><a href="hirdetesFel.php">Hirdetés feltöltés</a></li>
                                    <?php }?>
								<?php } else { ?>
									<li class="nav-item"><a href="reg_log.php">Hirdetés feltöltés</a></li>
                                <?php }?>
								<?php if($userID != ""){?>
									<?php if(strpos($current_page , 'profile.php') !== false){ ?>	
									<li class="active nav-item"><a href="profile.php?userid=<?= $userID ?>">Profilom</a></li>
									<?php } else{?>
                                    <li class="nav-item"><a href="profile.php?userid=<?= $userID ?>">Profilom</a></li>
                                    <?php }?>
								<?php } else { ?>
									<li class="nav-item"><a href="reg_log.php">Profilom</a></li>
								<?php }?>
							</ul>
						</div>
                    </nav>
                </div>
                <div class="col-lg-2">
					<div class="header__cart">
						<?php
						if($userID != ""){
						?>
							<form method="post" action="index.php">
								<!--<input type="submit" value="Kijelentkezés" name="outbtn" class="logoutbtn">-->
								<button class="custom-btn btn-16" name="outbtn"><b>Kijelentkezés</b></button>
							</form>		
						<?php } else { ?>
							<form method="post" action="reg_log.php">
								<!--<input type="submit" value="Bejelentkezés" name="inbtn" class="logoutbtn">-->
								<button class="custom-btn btn-11"><b>Bejelentkezés</b></button>
							</form>
						<?php } ?>			
					</div>
                </div>
            </div>
        </div>
    </header>
