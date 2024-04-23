<?php

require "config.php";


// gombnyomásra feltölti az üzenetet az adatbázisba
if(isset($_POST['sendBTN'])){
    $email = $_POST['email'];
    $text = $_POST['text'];

    $stmt = $conn->prepare("INSERT INTO messages (email, text) VALUES (?, ?)");
    
    $stmt->bind_param("ss", $email, $text);
    
    if($stmt->execute()) {
        header("Location:siker.php?page=1");
    } else {
        header("Location:siker.php?page=2");
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
    <form method="post" action="kapcsolat.php" enctype="multipart/form-data">
      <label class="form-label">Email</label>
      <input type="email" class="form-control form-control-lg"  name="email" required/>
      <hr>
      <label class="form-label">Üzenet</label>
      <!--<input type="text" class="form-control form-control-lg"  name="text" required/>-->
      <textarea class="form-control form-control-lg" name="text" required></textarea> <style>textarea { resize: none;}</style>
      <hr>
      <input type="submit" value="Feltöltés" name="sendBTN" class="custom-btn btn-1"></input>
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