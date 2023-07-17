<?php
	include_once("yonetimfonk.php");
	$clas=new yonetici;
  $clas->cookcon($vt,true);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Restoran Otomasyonu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../dosyalar/jquery.js"></script>
<link rel="stylesheet" href="../dosyalar/bootstrap.css" >
<link rel="icon" type="image/png" href="../dosyalar/panelform/images/icons/favicon.ico"/>
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/vendor/animate/animate.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/vendor/select2/select2.min.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/css/util.css">
<link rel="stylesheet" type="text/css" href="../dosyalar/panelform/css/main.css">
</head>
<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100 p-b-160 p-t-50">
				<?php
				@$buton=$_POST["buton"];
				if(!$buton):
				?>
				<form class="login100-form validate-form" action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<span class="login100-form-title p-b-43">
						YÖNETİCİ GİRİŞİ
					</span>

					<div class="wrap-input100 rs1 validate-input" data-validate = "Kullanıcı Adı Boş">
						<input class="input100" type="text" name="kulad">
						<span class="label-input100">Kullanıcı Adı</span>
					</div>


					<div class="wrap-input100 rs2 validate-input" data-validate="Şifre Alanı Boş">
						<input class="input100" type="password" name="sifre">
						<span class="label-input100">Şifre</span>
					</div>

					<div class="container-login100-form-btn">
						<input class="login100-form-btn" type="submit" name="buton" value="GİRİŞ"/>
					</div>
				</form>
				<?php
		   //echo md5(sha1(md5("")));
			else:
				@$sifre=htmlspecialchars(strip_tags($_POST["sifre"]));
				@$kulad=htmlspecialchars(strip_tags($_POST["kulad"]));
				if($sifre=="" || $kulad==""):
					echo "Bilgiler boş olmaz";
					header("refresh:2,url=index.php");
				else:
					  $clas->giriskontrolu($vt,$kulad,$sifre);

			endif;
		endif;
				?>
			</div>
		</div>
	</div>



<!--===============================================================================================-->
<script src="../dosyalar/panelform/vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="../dosyalar/panelform/vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
<script src="../dosyalar/panelform/vendor/bootstrap/js/popper.js"></script>
<script src="../dosyalar/panelform/vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="../dosyalar/panelform/vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="../dosyalar/panelform/vendor/daterangepicker/moment.min.js"></script>
<script src="../dosyalar/panelform/vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
<script src="../dosyalar/panelform/vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
<script src="../dosyalar/panelform/js/main.js"></script>


<body>

</div>

</body>
</html>
