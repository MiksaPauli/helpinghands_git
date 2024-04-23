<?php

require "config.php";

$errors = [];

//vizsgálja hogy megfelel e az új jelszó
if (isset($_POST['newPassbtn'])) {
    $email = $_POST['email'];
    $code = $_POST['code'];
    $password = $_POST['password'];

    if (strlen($password) < 8) {
        $errors[] = "A jelszónak legalább 8 karakter hosszúnak kell lennie!";
    }

    if (!preg_match('/[A-Z]/', $password)) {
        $errors[] = "A jelszónak tartalmaznia kell legalább egy nagybetűt!";
    }

    if (empty($errors)) {
        resetPassword($email, $code, $password);
    }
}

// ha megfelel akkor feltöltjük az újat
function resetPassword($email, $code, $password) {
    global $conn;

    $codeLekerdez = "SELECT * FROM passReset WHERE email = ?";
    $stmt = $conn->prepare($codeLekerdez);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $code_osszes = $stmt->get_result();

    if ($code_osszes->num_rows == 1) {
        $c = $code_osszes->fetch_assoc();
        if ($c['verification_code'] == $code) {
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

            $query = "UPDATE users SET password = ? WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ss", $hashed_pass, $email);
            $stmt->execute();

            $query = "DELETE FROM passReset WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();

            // Függően hogy melyik van kikommentezve aszerint változik az üzenet fajtálya
            echo "<div class='alert alert-success'>A jelszó sikeresen megváltoztatva!</div>";
            //echo "<script>alert('A jelszó sikeresen megváltoztatva');</script>";
        } else {
            echo "<div class='alert alert-danger'>Sikertelen jelszóváltoztatás!</div>";
            //echo "<script>alert('Sikertelen jelszóváltoztatás!');</script>";
        }
    } else {
        echo "<div class='alert alert-danger'>Nincs ezen az email címen aktív kérelem!</div>";
        //echo "<script>alert('Nincs ezen az email címen aktív kérelem!');</script>";
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
    <form method="post" action="passNew.php" enctype="multipart/form-data">
      <label class="form-label">Email</label>
      <input type="email" class="form-control form-control-lg"  name="email" required/>
      <hr>
      <label class="form-label">Kapott kód</label>
      <input type="text" class="form-control form-control-lg"  name="code" required/>
      <hr>
      <label class="form-label">Password</label>
      <input type="password" class="form-control form-control-lg" id="password" placeholder="Jelszó" name="password" required/>
      <hr>
      <div class="pass">
        <label><span id="length-check"></span>  A jelszavad legalább 8 karakter hosszú legyen!</label><br>
        <label><span id="upper-check"></span>  A jelszavad tartalmazzon minimum egy nagybetűt!</label>
	  </div>
      <hr>
      <input type="submit" value="Jelszó frissítése" name="newPassbtn" class="custom-btn btn-1"></input>
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
<!--Javascript a jelszó megfelelőség csekkolására-->
<script>
    document.getElementById('password').addEventListener('keyup', function (e) {
        var password = e.target.value;

        if (password.length >= 8) {
            document.getElementById('length-check').innerHTML = '✔️';
        } else {
            document.getElementById('length-check').innerHTML = '';
        }

        if (/[A-Z]/.test(password)) {
            document.getElementById('upper-check').innerHTML = '✔️';
        } else {
            document.getElementById('upper-check').innerHTML = '';
        }
    });

    document.querySelector('.uploadForm').addEventListener('submit', function (e) {
        var password = document.getElementById('password').value;

        if (password.length < 8 || !/[A-Z]/.test(password)) {
            e.preventDefault();
            alert('A jelszónak legalább 8 karakter hosszúnak kell lennie és tartalmaznia kell legalább egy nagybetűt!');
        }
    });
</script>  