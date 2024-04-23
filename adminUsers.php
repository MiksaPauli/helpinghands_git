<?php

    session_start();

    require "config.php";

    if(!isset($_SESSION['admin'])){
        header("Location:adminLog.php");
    }

    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    $search_condition = '';
    if (!empty($search_query)) {
        $search_condition = "SELECT * FROM users WHERE felhasznalonev LIKE '%$search_query%' ORDER BY id DESC";
    }


    /*if(isset($_user['deleteBTN'])){
        $userId = $_user['id'];
        // Prepare SQL statement to delete the user with the given ID
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $userId); // 'i' indicates the parameter is an integer
        $stmt->execute();
        // Redirect back to the admin ads page after deletion
        header("Location:adminAds.php");
        exit();
    }*/
    // felhasználók törlése
    if(isset($_POST['deleteBTN']) && isset($_POST['id'])){
        // Get the user ID from the form
        $userId = $_POST['id'];

        $lekerdezes = "SELECT * FROM users WHERE id = $userId";
        $osszes_user = $conn->query($lekerdezes);
        $user = $osszes_user->fetch_assoc();

        $jelenlegi_mappa = getcwd();

        // Construct the path to the user's folder
        $userFolder = $jelenlegi_mappa."/users/" . $user['felhasznalonev'];
    
        // Delete files within the user's folder
        $dirAds = $userFolder . "/adPic/";
        $filesAds = scandir($dirAds);
        foreach ($filesAds as $file) {
            $filePath = $dirAds . $file;
            if (is_file($filePath)) {
                unlink($filePath);
            } // Delete the file
        }


        $dirProf = $userFolder."/profilePic/";
        $filesProf = scandir($dirProf);
        foreach($filesProf as $file){
            $filePath = $dirProf. $file;
            if(is_file($filePath)){
                unlink($filePath);
            }     // Delete the file
        }
        // Optionally, remove the user's folder if it's empty
        $adPicFolder = $userFolder . "/adPic";
        $profilePicFolder = $userFolder . "/profilePic";

        if (is_dir($userFolder) && 
            is_dir($adPicFolder) && count(scandir($adPicFolder)) <= 2 &&
            is_dir($profilePicFolder) && count(scandir($profilePicFolder)) <= 2) {
            // Remove adPic folder
            rmdir($adPicFolder);
            // Remove profilePic folder
            rmdir($profilePicFolder);
            // Remove the main folder
            rmdir($userFolder);
        }

        
        // Prepare SQL statement to delete the user with the given ID
        $deleteAds = "DELETE FROM posts WHERE userid = $userId";
        $pstmt = $conn->query($deleteAds);
        $deleteProf = "DELETE FROM users WHERE id = $userId";
        $stmt = $conn->query($deleteProf);
        $deleteComments ="DELETE FROM comments WHERE userid = $userId";
        $cstmt = $conn->query($deleteComments);
        //KI KELL TOROLNI A HOZZA TARTOZO HIDETESEKET IS
        // Redirect back to the admin page after deletion
        header("Location: adminUsers.php");
        exit();
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
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand">ADMIN</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="admin.php">Üzenetek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="adminAds.php">Hirdetések</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="adminUsers.php">Felhasználók</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" href="index.php">Kijelentkezés</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
        <section>
        <div class="container">
            <h2>Felhasználók</h2>
        </div>    
        <div class="container">
            <form class="d-flex" method="GET" action="adminUsers.php">
                <input class="form-control me-2" name= "search_query" type="text" placeholder="Keresés">
                <button class="btn btn-primary" type="submit">Keresés</button>
            </form>
        </div>    
        <div class="container">
            <?php 

                if(empty($search_query)){
                    $lekerdezes = "SELECT * FROM users ORDER BY id DESC";
                }else{
					$lekerdezes = $search_condition;
				}

                $osszes_user = $conn->query($lekerdezes);
                while($user= $osszes_user->fetch_assoc()){
            ?>
            <a href="profile.php?userid=<?= $user['id']; ?>" target="_blank">
                <div class="card">
                    <div class="card-header">Teljes név: <?= htmlspecialchars($user['vezeteknev']); ?> <?= htmlspecialchars($user['keresztnev']) ;?></div>
                    <div class="card-body"><?= htmlspecialchars($user['felhasznalonev']); ?></div>
                    <div class="card-footer">Felhasználó email-je: <?= htmlspecialchars($user['email']); ?> | Regisztrálva: <?=$user['registDate']?></div>
                </div>
            </a>
            <form method="post" action="adminUsers.php" class="adBTN">
                <input type="hidden" name="id" value="<?=$user['id']?>">
                <button class="btn btn-danger bBTN" type="submit" name="deleteBTN">Törlés</button>
            </form>        
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
    .d-flex{
        margin-top: 50px;
        margin-left: 25%;
        width: 50%;
    }
    .card{
        margin-top: 100px;
        margin-left: 25%;
        width: 50%;
    }
    h2{
        margin-top: 70px;
        text-align: center;
    }
    a{
        text-decoration: none;
        color: black;
    }
    a:hover{
        text-decoration: none;
        color: black;
    }
    a:visited{
        text-decoration: none;
    }
    .adBTN{
        margin-left: 25%;
        width: 50%;
    }
    .bBTN{
        width:100%;
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

        .d-flex{
            margin-left: 10%;
            width: 80%;
        }
        .card{
            margin-left: 10%;
            width: 80%;
        }
    }
</style>    
  