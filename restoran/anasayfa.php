<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="../dosyalar/panelform/images/icons/faviconn.ico"/>
<script src="../dosyalar/jquery.js"></script>
<link rel="stylesheet" href="../dosyalar/bootstrap.css" >
<link rel="stylesheet" href="../dosyalar/style.css" >
<link href="../dosyalar/font-awesome/css/all.css" rel="stylesheet">
<link href="../dosyalar/font-awesome/webfonts" rel="stylesheet">
<title>Restoran Otomasyonu</title>
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
  width: 300px;
  padding: 70px 0;
  box-shadow: 0 0 20px rgba(104, 85, 224, 0.2);
  transition: 0.4s;
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

button:hover {
  color: white;
  width:;
  box-shadow: 0 0 20px rgba(104, 85, 224, 0.6);
  background-color: rgba(104, 85, 224, 1);
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

  


<h2	 style="text-align:center;" id="kero">RESTORAN OTOMASYONU GİRİŞ SEÇİMİ<h2>
<div class="container">
  <div>
    <a href="yonetim/ayarlar.php"><button class="log">Yönetici Girişi</button></a>
    <a href="kasiyer/index.php"><button class="log">Kasiyer Girişi</button></a>
    <a href="index.php"><button class="log">Garson Girişi</button></a>
  </div>
</div>
				</body>

</html>
