<?php

    session_start();

    if(empty($_SESSION['cookie'])){
		header("Location: index.php");
		exit();
	}

    $page_num = isset($_GET['page']) ? $_GET['page'] : '';
    // 1 = sikeres üzenetküldés 2 = sikertelen -||- 
    // 3 = sikeres hirdetésfeltöltés 4 = sikertelen -||-
    switch ($page_num) {
        case '1':
            $success_display = 'block';
            $error_display = 'none';
            break;
        case '2':
            $success_display = 'none';
            $error_display = 'block';
            break;
        case '3':
            $success_display = 'block';
            $error_display = 'none';
            break;
        case '4':
            $success_display = 'none';
            $error_display = 'block';
            break;
        default:
            $success_display = 'none';
            $error_display = 'none';
            break;
    }
    $üzenet =""; // kiirt üzenet
    $hovaVissza =""; // hova vigyen vissza a gomb megnyomása
    $styleCss =""; // melyik css style-t nyissa meg a kettő közül
    switch ($page_num) {
        case 1:
            $üzenet = "Sikeres üzenetküldés";
            $hovaVissza ="kapcsolat.php";
            $styleCss ="css/siker.css";
            break;
        case 2:
            $üzenet = "Sikertelen üzenetküldés";
            $hovaVissza ="kapcsolat.php";
            $styleCss ="css/siker2.css";
            break;
        case 3:
            $üzenet = "Sikeres hirdetésfeltöltés";
            $hovaVissza ="hirdetesFel.php";
            $styleCss ="css/siker.css";
            break;
        case 4:
            $üzenet = "Sikertelen hirdetésfeltöltés";
            $hovaVissza ="hirdetesFel.php";
            $styleCss ="css/siker2.css";
            break;
        default:
            $üzenet = "";
            break;
    };
?>
<!DOCTYPE html>
<html lang="hu">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow" />
    <title>Helping Hands</title>

    <link rel="stylesheet" href=<?=$styleCss?> type="text/css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">

    <script src="https://code.jquery.com/jquery-latest.js"></script>
    
</head>
<!--Egy oldalon van a siker és sikertelen üzenet. Aszerint kapjuk meg hogy melyiket mutassuk hogy mit kap az oldal $_GET segítségével-->
<body>
    <div id="container">
        <div id="success-box" style="display: <?php echo $success_display; ?>;">
            <div class="dot"></div>
            <div class="dot two"></div>
            <div class="face">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth happy"></div>
            </div>
            <div class="shadow scale"></div>
            <div class="message"><h1 class="alert">Siker!</h1><p><?=$üzenet?></p></div>
            <a href=<?= $hovaVissza ?>><button class="button-box" name="next"><h1 class="green">Tovább</h1></button></a>
        </div>   
        <div id="error-box" style="display: <?php echo $error_display; ?>;">
            <div class="dot"></div>
            <div class="dot two"></div>
            <div class="face2">
                <div class="eye"></div>
                <div class="eye right"></div>
                <div class="mouth sad"></div>
            </div>
            <div class="shadow move"></div>
            <div class="message"><h1 class="alert">Hiba!</h1><p><?=$üzenet?></p></div>
            <a href=<?= $hovaVissza ?>><button class="button-box"><h1 class="red">Újra</h1></button></a>
        </div>
    </div>
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
