<?php

    session_start();

    require "config.php";

    if(!isset($_SESSION['admin'])){
        header("Location:adminLog.php");
    }

    $isReported = "all";

	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$isReported = $_POST['sorter'];
	}
    // hirdetesek keresese
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';
    $search_condition = '';
    if (!empty($search_query) && $isReported=="all") {
        $search_condition = "SELECT * FROM posts WHERE title LIKE '%$search_query%' ORDER BY id DESC";
    }else{
        $search_condition = "SELECT * FROM posts WHERE title LIKE '%$search_query%' AND reports>0 ORDER BY id DESC";
    }
    //hirdetés státuszának állítása
	if(isset($_POST['status2BTN'])){
        $postId = $_POST['id'];
        $sql = "UPDATE posts SET status = 2 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $postId); // 'i' indicates the parameter is an integer
        $stmt->execute();
        header("Location:adminAds.php");
    }
    
    if(isset($_POST['status0BTN'])){
        $postId = $_POST['id'];
        $sql = "UPDATE posts SET status = 0 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $postId); // 'i' indicates the parameter is an integer
        $stmt->execute();
        header("Location:adminAds.php");
    }

    /*if(isset($_POST['deleteBTN'])){
        $postId = $_POST['id'];
        // Prepare SQL statement to delete the post with the given ID
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $postId); // 'i' indicates the parameter is an integer
        $stmt->execute();
        // Redirect back to the admin ads page after deletion
        header("Location:adminAds.php");
        exit();
    }*/
    // hirdetesek törlése
    if(isset($_POST['deleteBTN'])){
        $postId = $_POST['id'];
        
        $sql_select_pics = "SELECT mainPic, secondPic, thirdPic, userid FROM posts WHERE id = $postId";
        $talalt_hirdetes = $conn->query($sql_select_pics);
        $hirdetes = $talalt_hirdetes->fetch_assoc();

        $lekerdezes = "SELECT * FROM users WHERE id = $hirdetes[userid]";
        $osszes_user = $conn->query($lekerdezes);
        $felhasznalo = $osszes_user->fetch_assoc();

        $jelenlegi_mappa = getcwd();

        

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
        // Delete the pictures if they are not default.jpg
        /*foreach ($row_pics as $pic) {
            if ($pic !== 'default.jpg') {
                $picPath = "users/{$user['username']}/adpic/{$pic}";
                if (file_exists($picPath)) {
                    unlink($picPath); // Delete the picture file
                }
            }
        }*/
        
        // Proceed with deleting the post from the database
        $sql_delete_post = "DELETE FROM posts WHERE id = ?";
        $stmt_delete_post = $conn->prepare($sql_delete_post);
        $stmt_delete_post->bind_param('i', $postId);
        $stmt_delete_post->execute();

        $delete_comments ="DELETE FROM comments WHERE postid = $postId";
        $delete = $conn->query($delete_comments);
    
        // Redirect back to the admin ads page after deletion
        header("Location:adminAds.php");
        exit();
        //echo $path;
    }

    if(isset($_POST['commentBTN'])){
        $postId = $_POST['id'];
        header("Location:adminComments.php?postid=$postId");
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
                        <a class="nav-link active" href="adminAds.php">Hirdetések</a>
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
        <div class="container">
            <h2>Hirdetések</h2>
        </div>    
        <div class="container">
            <form class="d-flex" method="GET" action="adminAds.php">
                <input class="form-control me-2" name= "search_query" type="text" placeholder="Keresés">
                <button class="btn btn-primary" type="submit">Keresés</button>
            </form>
        </div>
        <div class="container">
            <form method="post" class="d-flex">
                <label for="rep" class="form-label">Csak jelentettek jelenjenek meg?</label>
                <select class="form-select" name="sorter" id="rep" selected="selected" onchange="this.form.submit()">
                    <option value="all" <?php if($isReported == "all"){ ?>selected<?php } ?>>Mindegyik</option>
                    <option value="reported" <?php if($isReported == "reported"){ ?>selected<?php } ?>>Jelentettek</option>
                </select>
			</form>
        </div>    
        <div class="container">
            <?php 

                if($isReported =="all" && empty($search_query)){
                    $lekerdezes = "SELECT * FROM posts ORDER BY id DESC";
                }else if($isReported == "reported" && empty($search_query)){
                    $lekerdezes = "SELECT * FROM posts WHERE reports>0 ORDER BY id DESC";
                }else{
					$lekerdezes = $search_condition;
				}

                $osszes_post = $conn->query($lekerdezes);
                while($post= $osszes_post->fetch_assoc()){
            ?>
            <a href="hirdetes.php?postid=<?= $post['id']; ?>" target="_blank">
                <div class="card">
                    <div class="card-header">Cím: <?= htmlspecialchars($post['title']); ?></div>
                    <div class="card-body"><?= htmlspecialchars($post['text']); ?></div>
                    <div class="card-footer">Feltöltő ID-ja: <?= $post['userid']; ?> | Feltöltve: <?= $post['uploadDate']; ?> | Feljelentve: <?= $post['reports']; ?></div>
                </div>
            </a>
            <form method="post" action="adminAds.php" class="adBTN">
                <input type="hidden" name="id" value="<?= $post['id']; ?>">
                <?php if($post['status']== 0 || $post['status']== 1){ ?>
                <button class="btn btn-warning bBTN" type="submit" name="status2BTN">Letiltás</button>
                <?php }else{?>
                <button class="btn btn-success bBTN" type="submit" name="status0BTN">Visszaállítás</button>
                <?php } ?>
                <button class="btn btn-danger bBTN" type="submit" name="deleteBTN">Törlés</button>
                <button class="btn btn-primary bBTN" type="submit" name="commentBTN">Kommentek</button>
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
    
    .form-label{
        margin-right: 10px;
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
  