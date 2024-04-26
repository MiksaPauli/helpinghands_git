<?php

  require "functions.php";

  if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}
 // ha még nincs bejelentkezve a user
  if(!isset($_SESSION['id']) && !isset($_COOKIE["userID"])){
    header("Location: reg_log.php");
  }
  // hirdetés feltöltése
  if(isset($_POST['uploadBTN'])){
    $uploadedFiles = array(); // Létrehozzuk a feltöltött fájlok tömbjét
    if(count($_FILES['feltoltendo']['name'])>3){
      echo "<script>alert('Max 3 képet tudsz feltölteni!')</script>";
    }else{
      // Végigmegyünk a feltöltött fájlokon
      for($i = 0; $i < 3; $i++) {
        // Ellenőrizze, hogy létezik-e ilyen indexű fájl a $_FILES tömbben
        if(isset($_FILES['feltoltendo']['error'][$i])) {
            // Ellenőrizze, hogy volt-e fájl feltöltve a mezőben
            if($_FILES['feltoltendo']['error'][$i] == UPLOAD_ERR_OK) {
                // Fájlnév kinyerése és ideiglenes név megszerzése
                $file_extension = pathinfo($_FILES['feltoltendo']['name'][$i], PATHINFO_EXTENSION);
                $file_name = $file_name = generateRandomString().'.'.$file_extension;
                $tmp_name = $_FILES['feltoltendo']['tmp_name'][$i];
              
              // A célkönyvtár elérési útvonala
              $curdir = getcwd();
              if(isset($_COOKIE["userID"])){
                $fajlnev = $_COOKIE["userID"];
                $user_dir = "/users/".$fajlnev."/adPic/";
              }else{
                $user_dir = "/users/".$_SESSION["felhasznalonev"]."/adPic/";
              }
              // Ellenőrizzük, hogy a fájlnév üres-e, ha igen, használjuk a default.jpg-t
              if(empty($file_name)) {
                  $file_name = "default.jpg";
              }
              
              // Cél elérési útvonal összeállítása
              $eleresiut = $curdir.$user_dir.$file_name;
              
              // Fájl mozgatása a célhelyre
              if(move_uploaded_file($tmp_name, $eleresiut)){
                  $szam = $i + 1;
                  echo "<script>alert('".$szam.". kép feltöltés sikeres!')</script>";
              }
              
              // Fájlnév hozzáadása a feltöltött fájlok tömbjéhez
              $uploadedFiles[] = $file_name;
          } else {
              // Ha nincs fájl feltöltve a mezőben, adjuk hozzá a default.jpg-t a tömbhöz
              $uploadedFiles[] = "default.jpg";
          }
        }  
      }
    }
    if (isset($_POST['category'])) {
      $selected_category = $_POST['category'];
    } else {
      $selected_category = "5";
    }
    if(isset($_COOKIE["userID"])){
      $felhID = $_COOKIE["userID"];
      adUpload($felhID, $_POST['title'], $_POST['location'], $_POST['description'], $selected_category, $uploadedFiles);
    }else{
      adUpload($_SESSION['id'], $_POST['title'], $_POST['location'], $_POST['description'], $selected_category, $uploadedFiles);
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
    <link rel="stylesheet" href="css/hirdetesFel.css" type="text/css">
    <link rel="stylesheet" href="css/logBtn.css" type="text/css">

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
  <div class="uploadForm">
    <form method="post" action="hirdetesFel.php" enctype="multipart/form-data">
      <label class="form-label">Hírdetés címe:</label>
      <input type="text" class="form-control form-control-lg"  name="title" maxlength="50" required/>
      <hr>
      <label class="form-label">Hirdetés helye (város , község stb.)</label>
      <input type="text" class="form-control form-control-lg"  name="location" maxlength="100" required/>
      <hr>
      <label class="form-label">Leirás</label>
      <br><br>
      <textarea placeholder="Hirdetésed leirása" class="form-control form-control-lg" name="description" maxlength="1000" required></textarea> <style>textarea { resize: none;}</style>
      <hr>
      <!--<textarea placeholder="Ideiglenes kategória" name="category" required></textarea>-->
      <label class="form-label">Kategória</label>
      <br><br>
      <select name="category" id="category" class="selectCategory">
            <option value="1">Utazás</option>
            <option value="2">Vásárlás</option>
            <option value="3">Otthon</option>
            <option value="4">Tanítás</option>
            <option value="5" selected>Egyéb</option>
      </select>
      <br><br>
      <hr>
      <labek>Képek</label>
      <br><br>
      <input name="feltoltendo[]" type="file" multiple>
      <br><br>
      <hr>
      <input type="submit" value="Feltöltés" name="uploadBTN" class="custom-btn btn-1"></input>
    </form>
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
	@media (max-width: 768px) {
		.uploadForm{
			margin-left: 25px;
      margin-right: 25px;
      max-width: 100%;
		}
	}
</style>   