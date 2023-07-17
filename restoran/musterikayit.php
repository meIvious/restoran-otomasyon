<?php
$vt=new mysqli("localhost","root","","restoran") or die ("Bağlanamadı");
$vt->set_charset("utf8");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<link rel="icon" type="image/png" href="../dosyalar/panelform/images/icons/faviconn.ico"/>
<script src="../dosyalar/jquery.js"></script>
<link rel="stylesheet" href="../dosyalar/bootstrap.css" >
<link rel="stylesheet" href="../dosyalar/style.css" >
<link href="../dosyalar/font-awesome/css/all.css" rel="stylesheet">
<link href="../dosyalar/font-awesome/webfonts" rel="stylesheet">
<title>Müşteri Kayıt</title>
</head>
<style>
body {
  border: 0;
  margin: 0;
  padding: 0;
  font-family: sans-serif;
  background-color: rgba(250, 250, 250)
}

.container {
  min-height: 80vh;
  justify-content: center;
  align-items: center;
  display: flex;
  text-align: center;
}

.container div > p span {
  color: red;
}

p {
  position: relative;
  top: 30px;
}

p a {
  color: black;
  text-decoration: none;
}

button {
  cursor: pointer;
  border: 0;
  border-radius: 4px;
  font-weight: 600;
  margin: 0 10px;
  width: 89px;
  padding: 12px 0;
  box-shadow: 0 0 20px rgba(104, 85, 224, 0.2);
  transition: 0.4s;
  background-color:#337ab7 ;
}

.reg {
  color: white;
  background-color: rgba(104, 85, 224, 1);
}

.log {
  color: rgb(104, 85, 224);
  background-color: rgba(255, 255, 255, 1);
  border: 1px solid rgba(104, 85, 224, 1);
  font-family:comic sans ms;
  border-radius:10px;
  font-size:20px;
}



#kero{
	color: white;
	font-size:35px;
	font-family:comic sans ms;
	font-weight:bold;
	text-shadow: 2px 3px 2px #6855cc;
}
#beko{
	 position: relative;
}
</style>
<body style="background-color:#e5e5e5" background="dosyalar/arkaplan/arka.jpg" id="beko">
<h2	 style="text-align:center;" id="kero">RESTORAN OTOMASYONU MÜŞTERİ KAYIT<h2>
<div class="col-md-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

input[type=text], select, textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
  margin-top: 6px;
  margin-bottom: 16px;
  resize: vertical;
}

input[type=submit] {
  background-color: #4CAF50;
  color: white;
  padding: 12px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

input[type=submit]:hover {
  background-color: #45a049;
}

.container {
  border-radius: 20px;
  background-color: #f2f2f2;
  padding: 20px;
}
#biga{
  color:white;
}
#kucukkuyu{

      border-top-style:solid;

      border-bottom-style:solid;

      border-left-style:solid;

      border-right-style:solid;

     }
}

</style>
</head>
<body>

<div class="container" id="kucukkuyu"style="width:700px;margin-left:auto;margin-right:auto;">
  <form method="POST" action="musterikayit.php">
    <label for="ad" style="font-family:comic sans ms">Ad</label>
    <input type="text" id="ad" name="ad" style="font-family:comic sans ms" placeholder="Ad">

    <label for="soyad"  style="font-family:comic sans ms">Soyad</label>
    <input type="text" id="soyad" name="soyad" style="font-family:comic sans ms" placeholder="Soyad">

	<label for="telefon" style="font-family:comic sans ms">Telefon Numarası</label>
    <input type="text" id="telefon" name="telefon" maxlength="11" style="font-family:comic sans ms" placeholder="Telefon">

	<label for="email" style="font-family:comic sans ms">E-mail</label>
    <input type="text" id="email" name="email" style="font-family:comic sans ms" placeholder="E-mail">

    <input type="submit" value="Kaydet" style="font-family:comic sans ms; font-weight:bold;">

    <a href="index.php"><button type="button" class="btn btn-primary" style="font-family:comic sans ms" id="biga">Geri Dön</button></a>

		<div>
  <br><?php
if($_POST){
	$ad = $_POST['ad'];
	$soyad = $_POST['soyad'];
	$telefon = $_POST['telefon'];
	$email = $_POST['email'];
	$adsoyad="$ad "."$soyad";

$sql="select adsoyad from musteri WHERE adsoyad='$adsoyad'|| telefon='$telefon'|| email='$email'";

$sonuc1= mysqli_query($vt,$sql);
$satirsay=mysqli_num_rows($sonuc1);

if ($satirsay>0)
{
echo "Bu Kayıt Zaten Var!";

} else{
$sqlekle="INSERT INTO musteri( adsoyad, telefon, email)
VALUES ('$adsoyad','$telefon','$email')";

$sonuc=mysqli_query($vt,$sqlekle);

if ($sonuc==0)
echo "Eklenemedi, kontrol ediniz";
else
echo "Kayıt Başarıyla Eklendi !";
}
};
?>

</div>
  </form>

</div>



</div>


</body>

</html>
