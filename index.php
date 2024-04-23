<?php 

	require "config.php";  

	session_start();

    $displayPreloader = !isset($_SESSION['visited']);
    $_SESSION['visited'] = true;

    $cookieConsent = isset($_SESSION['cookie']) ? $_SESSION['cookie'] : "";

    if(isset($_POST['cookieConsent'])) {
        $_SESSION['cookie'] = $_POST['cookieConsent'];
        header("Location:index.php");
        exit(); // Exit after setting the session variable
    }
    //$_SESSION['cookie'] = "";
    //$_SESSION['cookie'] = 2; // teszteleshez kikomment
    //$_SESSION['cookie'] = 1;
	
	if(isset($_POST['outbtn'])){
    
		$_SESSION['id'] = "";
        $_SESSION['email'] = "";
		$_SESSION['vezeteknev'] = "";
		$_SESSION['keresztnev'] = "";
		$_SESSION['felhasznalonev'] = "";
	    
        
        setcookie("userID", "", time(), "/");
        
        setcookie("userEmail", "", time(), "/");
        
        setcookie("userVeznev", "", time(), "/");
        
        setcookie("userKernev", "", time(), "/");

        setcookie("userFelhnev", "", time(), "/");

        header("Location:index.php");
        
    }    
	
	/*if(!empty($_SESSION['id'])){
		$felhasznalo = $_SESSION['id'];
	}*/
	
	
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

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">
	
	<!--AJAX-->
	<script src="https://code.jquery.com/jquery-latest.js"></script>

    <style>
        #preloder {
            display: <?php echo $displayPreloader ? 'block' : 'none'; ?>; /* Show or hide based on PHP condition */
        }
    </style>

</head>

<body>
    <!-- Page Preloder -->

    <div id="preloder">
        <div class="loader"></div>
    </div>

    <div id="cookieConsentModal" class="modal">
        <div class="modal-content">
            <h2 class="cookie-title"><b>Sütik elfogadása</b></h2>
            <p class="cookie-title">Oldalunk sütiket használ a jobb müködés szempontjábol</p>
            <button class="cookie-accept" id="acceptCookies">Elfogadom</button>
            <button class="cookie-reject" id="rejectCookies">Elutasítom</button>
        </div>
    </div>

    <!-- Header Section Begin -->
    <div id="headerOne">
        <?php include 'header.php';?>
    </div>
    <!-- Header Section End -->
	
    <!-- Hero Section Begin -->
    <section class="hero pt-3">
        <div class="container bemutatkozas">
            <h1 class="ÜdvCim">Üdvözöljük a Helping Hands oldalán</h1>
            <p>Manapság az emberek egyre jobban elkülönülnek egymástól.
            HelpingHands szeretne ezen változtatni és a Magyarországon élő embereket közelebb hozni egymáshoz.
            Oldalunk ezt úgy szeretné elérni hogy a felhasználók regisztráció után feltölthetnek segítség kérelmet vagy segítség nyujtást egy hirdetés formájában.
            Erre a többi felhasználó tud reagálni és jelentkezni a hirdetések alatti kommentszekcióban vagy a hirdető által megadott elérési utvonalakon.</p>
            <h3 class="HaszCim">Oldal használata</h3>
            <p>A hirdetések megtekintéséhez nem szükséges regisztrálni viszont ha szeretne kommentelni vagy hirdetést feladni akkor viszont már muszály.
            Bejelentkezni/Regisztrálni az oldal jobb felső sarkában található gombra kattintva lehet.
            Ez után a "hirdetés feltöltése" menüpontra kattintva tudnak egy hirdetést feladni.
            Fontos megjegyezni hogy a felhasználónak kell megadnia egy elérhetési módot vagy a hirdetés leirásába vagy a kommentszekcióban.
            Hirdetéseket a "hirdetések" menüpont alatt lehet keresni és ott egy hirdetésre kattintva lehet részletesen megnézni a hirdetés adatait.
            Ha bármi oda nem illő dolgot vesznek észre egy hirdetésben akkor a hirdetés jobb alsó sarkában található piros gombra kattintva jelethetik fel.
            <br><a href="kapcsolat.php">Ha bármi más kérdésük lenne akkor nyugodtan küldjél el azt erre a sorra kattintva (regisztráció ehhez nem szükséges)</a></p>
            <br><a href="rules.html" target="_blank">Felhasználási feltételek</a>
            <br><a href="dataSec.html" target="_blank">Adatvédelmi nyilatkozat</a>
        </div> 
    </section>
    <!-- Hero Section End -->

    <!-- Footer Section Begin -->
    <div id="footerOne">
        <?php include 'footer.php';?>
    </div>
    <!-- Footer Section End -->

    <!-- Js Plugins -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.nice-select.min.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.slicknav.js"></script>
    <script src="js/mixitup.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/main.js"></script>
	<script src="https://kit.fontawesome.com/6881cff645.js" crossorigin="anonymous"></script>

    <script>
        window.onload = function() {
            var modal = document.getElementById('cookieConsentModal');
            var acceptButton = document.getElementById('acceptCookies');
            var rejectButton = document.getElementById('rejectCookies');

            // Show the modal if cookie consent is not set
            if(<?php echo json_encode(!$cookieConsent); ?>) {
                modal.style.display = "block";
            }

            // When the user accepts cookies
            acceptButton.onclick = function() {
                setCookieConsent(1); // 1 indicates acceptance
                modal.style.display = "none";
            };

            // When the user rejects cookies
            rejectButton.onclick = function() {
                setCookieConsent(2); // 2 indicates rejection
                modal.style.display = "none";
            };

            // Function to send cookie consent choice to the server
            function setCookieConsent(choice) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'index.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('cookieConsent=' + choice);
            }
        };
    </script>

</body>
<style>
    p{
        text-align: justify;
        animation: welcomeAnim 1s ease-in-out;
    }
    .bemutatkozas{
        width: 70%;
        animation: welcomeAnim 1s ease-in-out;
    }
    .ÜdvCim{
        font-family: 'Cairo', sans-serif;
        font-size: 50px;
        font-weight: 900;
        text-align: center;
        margin-top: 30px;
        margin-bottom: 30px;
        animation: welcomeAnim 1s ease-in-out;
    }
    .HaszCim{
        font-family: 'Cairo', sans-serif;
        font-size: 25px;
        font-weight: 700;
        margin-top: 30px;
        margin-bottom: 30px;
        animation: welcomeAnim 1s ease-in-out;
    }

    .modal-content{
        background-color: #7fad39;
    }

    .cookie-title{
        color: white;
    }

    .cookie-accept{
        background-color: lightgreen;
    }

    .cookie-reject{
        background-color: lightcoral;
        color: white;
    }

    @keyframes welcomeAnim {
        0% {
        opacity: 0;
		margin-top: 40px;
    }
    100% {
        opacity: 1;
    }
    }
</style>

</html>