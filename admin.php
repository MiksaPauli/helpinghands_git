<?php

    session_start();

    require "config.php";

    if(!isset($_SESSION['admin'])){
        header("Location:adminLog.php");
    }
    // üzenetek törlése
    if(isset($_POST['deleteBTN'])){

        $messageId = $_POST['messageId']; 
        $deleteQuery = "DELETE FROM messages WHERE id = $messageId";

        if ($conn->query($deleteQuery) === TRUE) {
            header("Location: admin.php");
            exit(); 
        } else {
            echo "<script>alert(Hiba a törlés során)</script>";
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
    <title>Helping Hands Admin</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <!--<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Popper JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">


    <!--AJAX-->
    <script src="https://code.jquery.com/jquery-latest.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand">ADMIN</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="admin.php">Üzenetek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminAds.php">Hirdetések</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminUsers.php">Felhasználók</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="index.php">Kijelentkezés</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

        <section>
        <div class="container mt-5">
        <h2>Bejövő üzenetek</h2>
        <?php
            $lekerdezes= "SELECT * FROM messages ORDER BY id ASC";
            $osszes_messages = $conn-> query($lekerdezes);
            while ($message = $osszes_messages->fetch_assoc()) {
        ?>
            <div class="card messages">
                <div class="card-header">Email: <?= htmlspecialchars($message['email']); ?></div>
                <div class="card-body">Üzenet: <?= htmlspecialchars($message['text']); ?></div>
                <form method="post" action="admin.php">
                    <input type="hidden" name="messageId" value="<?= $message['id']; ?>">
                    <button class="btn btn-danger" name="deleteBTN">Törlés</button><style> button {width:100%;}</style>
                </form> 
            </div>
        <?php } ?>    
        </div>
        </section>   
        <footer class="bg-dark adminFooter">
            <h3 class="footerLogo">@HELPING HANDS</h3>    
        </footer>
 
        <!--<script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.nice-select.min.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/jquery.slicknav.js"></script>
        <script src="js/mixitup.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/main.js"></script>
        <script src="https://kit.fontawesome.com/6881cff645.js" crossorigin="anonymous"></script>-->
    </body>

</html>
<style>
    h2{
        text-align: center;
        margin-bottom: 50px;
    }
    .messages{
        width: 40%;
        margin: 0 auto;
        margin-bottom: 60px;
    }
    .adminFooter{
        margin-top: 300px;
        margin-bottom: 0px;
        height: 100px;
        padding: 0;
        text-align: center;
    }

    .footerLogo{
        color: white;
        font-size: 30px;
        padding: 20px;
    }
    @media (max-width: 768px) {

        .messages{
            margin-left: 10%;
            width: 80%;
        }
    }
</style>    