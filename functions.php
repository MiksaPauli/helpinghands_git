<?php
//testhehe 
	session_start();
	
	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require 'phpmailer/src/Exception.php';
    require 'phpmailer/src/PHPMailer.php';
    require 'phpmailer/src/SMTP.php';


	function emailsend($useremail, $text, $body){
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username ='helping69hands420@gmail.com';
        $mail->Password = 'hnnr goxt frys kiep';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->setFrom('helping69hands420@gmail.com');

        $mail->addAddress($useremail);

        $mail->isHTML(true);

        $mail->Subject = $text;
        $mail->Body = $body;

        $mail->send();

        echo
        "
        <script>
            window.open('reg_log.php');
        </script>
        ";
        
    }

	// regisztráció function
	function Reg($vezeteknev, $keresztnev, $felh, $email, $pass){
			$hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
			$conn = new mysqli("localhost", "team05", "DYJlbCv0KCTN537", "team05");
			$lekerdezes = "SELECT * FROM users WHERE felhasznalonev='$felh'";
			$talalt_felhasznalo = $conn->query($lekerdezes);
			$emailLekerdez = "SELECT * FROM users WHERE email='$email'";
			$talalt_email = $conn->query($emailLekerdez);
			if(mysqli_num_rows($talalt_email)==0){
				if(mysqli_num_rows($talalt_felhasznalo)==0){
					
					$curdir = getcwd();
					
					$userDirectory = $curdir."/users/". $felh;

					if(mkdir($userDirectory, 0777)){
						$stmt = $conn->prepare("INSERT INTO users(vezeteknev,keresztnev,felhasznalonev,email,password,prof_img) VALUES (?,?,?,?,?,'default.jpg')");
						$stmt ->bind_param("sssss", $vezeteknev,$keresztnev,$felh,$email,$hashed_pass);
						$stmt ->execute();
						//$conn->query("INSERT INTO users VALUES(id, '$vezeteknev', '$keresztnev', '$felh', '$email', '$hashed_pass', 'default.jpg')");
						$lekerdezes = "SELECT * FROM users WHERE felhasznalonev='$felh'";
						$talalt_felhasznalo = $conn->query($lekerdezes);
						$felhasznalo = $talalt_felhasznalo->fetch_assoc();
						$_SESSION['id'] = $felhasznalo['id'];
						$profilePicDir = $userDirectory . "/profilePic"; //profilképeknek a mappája
						mkdir($profilePicDir, 0777, true);
						$addPicDir = $userDirectory . "/adPic"; // hirdetés képeknek a mappája
						mkdir($addPicDir, 0777, true);
						//Reg üdvözlet
						/*$text = "HELPINGHANDS regisztracio teszt!!!";
						$body = "Kedves ".$vezeteknev." ".$keresztnev." köszönjük a regisztrációt az oldalunkra. (EZ CSAK EGY SULIS PROJEKT TESZT HA VÉLETLEN MEGADTAM EGY LÉTEZŐ EMAILT AKKOR NEM KELL FÉLNI NEM REGISZTRÁLTAM SEHOVA AZ ÖN EMAIL CÍMÉVEL)";
						emailsend($email, $text, $body);*/
						header("Location: reg_log.php");
					}
					else{
						echo "<script>alert('Nem sikerült létrehozni a mappát!')</script>";
					}
					
				}
				else{
					echo "<script>alert('A felhasználónév már foglalt!')</script>";
				}
			} else {
				echo "<script>alert('Ezzel az email-el már regisztráltak')</script>";
			}	
		}

	// hirdetés feltöltés funkció	
	function adUpload($userid, $title, $location, $description, $category, $uploadedFiles){
		$conn = new mysqli("localhost", "team05", "DYJlbCv0KCTN537", "team05");
		$mainPic = isset($uploadedFiles[0]) ? $uploadedFiles[0] : "default.jpg";
		$secondPic = isset($uploadedFiles[1]) ? $uploadedFiles[1] : "default.jpg";
		$thirdPic = isset($uploadedFiles[2]) ? $uploadedFiles[2] : "default.jpg";

		$stmt = $conn->prepare("INSERT INTO posts (userid, title, location, text, category, mainPic, secondPic, thirdPic, status, reports) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0)");

		$stmt->bind_param("isssisss", $userid, $title, $location, $description, $category, $mainPic, $secondPic, $thirdPic);

		$stmt->execute();

		if ($stmt->affected_rows > 0) {
			header("location: siker.php?page=3");
		} else {
			header("location: siker.php?page=4");
		}

		$stmt->close();
	}

	// Random string generátor változtatható hosszal
	function generateRandomString($length = 6) {
		$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
	
		return $randomString;
	}

	
?>