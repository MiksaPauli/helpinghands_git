<?php

require "config.php";
require "functions.php";

if (empty($_SESSION['cookie'])) {
    header("Location: index.php");
    exit();
}

// email küldése benne a linkel hogy melyik oldalon kell és a kóddal ami igazolja hogy aki regisztrált azé az oldal

if(isset($_POST['forgotbtn'])){
    
    $useremail = $_POST['email'];
    $resetPassLekredez = "SELECT * FROM passReset WHERE email = '$useremail'";
    $talalt_reset = $conn->query($resetPassLekredez);

    if(mysqli_num_rows($talalt_reset) > 0){
        echo "<script>alert('Már van ezzel az email címmel egy kérelem folyamatban!')</script>";
    }else{
        $lekerdezes = "SELECT * FROM users WHERE email = '$useremail'";
        $talalt_user = $conn->query($lekerdezes);
        // belerakjuk a kérelemhez tartozó adatokat és kódot a neki szánt adatbázisba
        if(mysqli_num_rows($talalt_user) == 1){
            $felhasznalo = $talalt_user->fetch_assoc();
            $verification_code = generateRandomString();
            $timestamp = date('Y-m-d H:i:s');
            $query = "INSERT INTO passReset (email, verification_code, req_date) VALUES ('$useremail', '$verification_code', '$timestamp')";
            $conn->query($query);

            $text = "Jelszo emlekezteto";
            $body = "Kedves ".$felhasznalo['vezeteknev']." ".$felhasznalo['keresztnev']." erre a linkre kattintva tud eljutni a jelszó újra oldalra: https://team05.project.scholaeu.hu/passNew.php || Ellenörző kódja: ".$verification_code;
            emailsend($useremail, $text, $body);
        }else{
            echo "<script>alert('Nincs felhasználó ezzel az email címmel!')</script>";
        }
    }    
}

?>

<!-- A HTML kód marad változatlan -->


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
    <form method="post" action="passReminder.php" enctype="multipart/form-data">
      <p>Add meg az email címet amivel regisztráltál és küldünk egy emailt a további teendőkkel.</p>  
      <label class="form-label">Email</label>
      <input type="email" class="form-control form-control-lg"  name="email" required/>
      <hr>
      <input type="submit" value="Új jelszó" name="forgotbtn" class="custom-btn btn-1"></input>
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