<?php 

	require "config.php";
	
	session_start();
    // admin bejelentkezés
	if(isset($_POST['loginbtn'])){
		
		$user = $_POST['username'];
		$pass = $_POST['password'];
		
		$lekerdezes = "SELECT * FROM admins WHERE adminName='$user'";
		$talalt_sor = $conn->query($lekerdezes);
        $admin = $talalt_sor->fetch_assoc();
		$jelszoTitkos = $admin['adminPass'];
		if(mysqli_num_rows($talalt_sor) == 1){
			if(password_verify($pass, $jelszoTitkos)){
                $_SESSION['admin'] = $admin['id'];
                header("Location:admin.php");
            }
            else{
                echo "<script>alert('Helytelen jelszó!')</script>";
            }
		}
		else{
			echo "<script>alert('Nem találtunk ilyen felhasználó nevet!')</script>";
		}
		
	}
    /*if(isset($_POST['loginbtn'])){ új admin kreálásához (be kell tenni a másik if-et kommentbe és az uj admin adatokat itt megadni ahol az Admin123 van)
        $password = "Admin123";
        $username = "Admin123";
        $titkositott = password_hash($password, PASSWORD_DEFAULT);
		$conn->query("INSERT INTO admins VALUES('', '$username', '$titkositott')");
		header("Location: admin.php");
        echo "<script>alert('Siker!!)</script>";		
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
    <title>Helping Hands Admin</title>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
	<link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="img/fav/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/fav/favicon-16x16.png">
    <link rel="manifest" href="img/fav/site.webmanifest">
	
	<!--AJAX-->
	<script src="https://code.jquery.com/jquery-latest.js"></script>
</head>
<body>

    <!--<form method="post" action="adminLog.php">
        <label>Felhasználónév</label>
        <input type="text" name="username"/>
        <label>Jelszó</label>
        <input type="password" name="password"/>
        <button name="loginbtn">Bejelentkezés</button>
    </form>-->

    <div class="container formContainer">
        <h2>ADMIN BELÉPÉS</h2>
        <form method="post" action="adminLog.php">
            <div class="mb-3 mt-3">
                <label for="username" class="form-label">Felhasználónév:</label>
                <input type="text" class="form-control" id="username" placeholder="Felhasználóneved" name="username">
            </div>
            <div class="mb-3">
                <label for="pwd" class="form-label">Jelszó:</label>
                <input type="password" class="form-control" id="pwd" placeholder="Jelszavad" name="password">
            </div>
            <button name="loginbtn" class="btn btn-primary">Bejelentkezés</button>
            <a href="index.php">Vissza a főoldalra</a>
        </form>
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

<style>
    .formContainer{
        width: 30%;
        margin-top: 50px;
        padding: 20px;
        background-color: #d3d3d3;
        border-radius: 5px;
        box-shadow: 10px 10px 5px gray;
    }
    h2{
        text-align: center;
    }

    @media (max-width: 768px) {
        .formContainer{
            width: 80%;
            margin-left: 10%;
        }
    }
</style>    