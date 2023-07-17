
<?php
	include("yonetimfonk.php");
	include("vt.php");
	$yonetimclas=new yonetici;
	$yonetimclas->cookcon($vt,false);
?>
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

	.container-fluid,
	.row-fluid{
		height: inherit;
	}
	a:link, a:visited, a:active {
	font-family:Comic Sans MS;
	font-size: 18px;
	color :#000000;
	text-decoration : none;
	}

#btnyonetim2:hover a{
	color:		#FF3D00;
}
#btnyonetim2:hover {
	background-color:#EEEEEE;
	
}
#div1{
		background-color:#fff;
		border:1px; solid #F1F1F1;
		border-radius: 15px;
			min-height: 100%;
}
#div3{
		height:80px;
		font-size:20px;
			border-radius:10px;
		font-family:Comic Sans MS;
		background-color: #fff;

}

#div4{
	background-color:#5e72e4;
	min-height:137px;
}

h4{
		color:#5e72e4;
}


</style>
<body>
	<div class="container-fluid ">
  <div class="row row-fluid">
  <div class="col-md-2  border-right">
		<div class="row" >
			<div class="col-md-12  p-4 mx-auto text-center weight-bold">
		  <h4><?php 
$sorgu = $baglanti->query("SELECT * FROM yonetici"); // kayit tablosundaki tüm verileri çekiyoruz.
while ($sonuc = $sorgu->fetch_assoc()) 
$kulad = $sonuc['kulad']; // Veritabanından çektiğimiz id satırını $id olarak tanımlıyoruz.
// While döngüsü ile verileri sıralayacağız. Burada PHP tagını kapatarak tırnaklarla uğraşmadan tekrarlatabiliriz. 
			echo '<h4><i class="fas fa-user" style="color:#000"></i> YÖNETİCİ<hr color="#0000F8"/>'.$kulad.'<h4>'
			?> 
			</h4>
		</div>
	</div><br>
	<div class="row" >
		<div class="col-md-12 p-3 pl-3 border-top" id="btnyonetim2">
		<a href="../anasayfa.php"> <i class="fa fa-home" style="color:#363636"></i>  Anasayfa</a>
		</div>
		<div class="col-md-12 p-3 pl-3" id="btnyonetim2">
		<a href="ayarlar.php?islem=masayon"> <i class="fa fa-table" style="color:#2E7D32"></i>  Masa Yönetimi</a>
		</div>
		<div class="col-md-12 p-3 pl-3 "id="btnyonetim2">
		<a href="ayarlar.php?islem=urunyon" ><i class="fas fa-utensils" style="color:#E64A19"></i> Ürün Yönetimi</a>
		</div>
		<div class="col-md-12  p-3 pl-3 "id="btnyonetim2">
		<a href="ayarlar.php?islem=kategoriyon" ><i class="fas fa-clipboard-list" style="color:#6A1B9A"></i> Kategori Yönetimi</a>
		</div>
		<div class="col-md-12  p-3 pl-3 "id="btnyonetim2">
		<a href="ayarlar.php?islem=garsonyon" ><i class="fas fa-address-book" style="color:#005fbf"></i> Garson Yönetimi</a>
		</div>
		<div class="col-md-12  p-3 pl-3 "id="btnyonetim2">
		<a href="ayarlar.php?islem=garsonper" ><i class="fas fa-chart-line" style="color:#005fbf"></i> Garson Performans</a>
		</div>
		<div class="col-md-12  p-3 pl-3 "id="btnyonetim2">
		<a href="ayarlar.php?islem=musteriper" ><i class="fas fa-chart-line" style="color:red"></i> Müşteri Performans</a>
		</div>
		<div class="col-md-12  p-3 pl-3 " id="btnyonetim2">
		<a href="ayarlar.php?islem=rapor" ><i class="fas fa-book" style="color:#FFD600"></i> Rapor Yönetimi</a>
		</div>
		<div class="col-md-12  p-3 pl-3  "id="btnyonetim2">
		<a href="ayarlar.php?islem=sifredegistir" ><i class="fas fa-lock"style="color:#DD2C00"></i> Şifre Değişikliği</a>
		</div>
		
		<div class="col-md-12  p-3 pl-3  "id="btnyonetim2">
		<a href="ayarlar.php?islem=cikis" ><i class="fas fa-door-open"style="color:	#0D47A1"></i> Çıkış</a>
		</div>
</div>
		</div>

  <div class="col-md-10 ">
		<div class="row">
		<div class="col-md-12">
			<div class="row" id="div4">
			<div class="col-md-2 col-sm-6 mr-2  mx-auto mt-3 p-2 text-center text-dark" id="div3">Toplam Ürün<br>
					<i class="fas fa-hamburger " style="color:#C51162"></i> <?php $yonetimclas->toplamurunler($vt); ?></div>

			<div class="col-md-2 col-sm-6 mr-2  mx-auto mt-3 p-2 text-center text-dark " id="div3" >Toplam Sipariş<br>
					<i class="fas fa-utensils" style="color:#6A1B9A"></i> <?php $yonetimclas->toplamsiparisadeti($vt); ?> </div>

			
			<div class="col-md-2 col-sm-6 mr-2  mx-auto mt-3 p-2 text-center text-dark " id="div3" >Toplam Hasılat<br>
					<i class="fa fa-lira-sign" style="color:	#2E7D32"></i> <?php $yonetimclas->hasilat($vt); ?> </div>
			
		</div>
		


	<div class="col-md-12" id="div1">

	<div class="col-md-12 mt-4" id="div1">
	  <?php
	  @$islem=$_GET["islem"];
	  switch ($islem) :
/////////////////////////////MASA YÖNETİMİ///////////////////////
	  case "masayon":
		$yonetimclas->masayon($vt);
		break;

      case "masasil":
		$yonetimclas->masasil($vt);
		break;

      case "masaguncelle":
		$yonetimclas->masaguncelle($vt);
		break;

	  case "masaekle":
		$yonetimclas->masaekle($vt);
		break;
////////////////////////////////////////////////////////////////		
	  //------------ÜRÜN YÖNETİM İŞLEMLERİ---------------
                            case "urunyon":
                                $yonetimclas->urunyon($vt,0);
                                break;

                            case "urunsil":
                                $yonetimclas->urunsil($vt);
                                break;

                            case "urunguncelle":
                                $yonetimclas->urunguncelle($vt);
                                break;

                            case "urunekle":
                                $yonetimclas->urunekle($vt);
                                break;

                            case "katgore":
                                $yonetimclas->urunyon($vt, 2);
                                break;

                            case "aramasonuc":
                                $yonetimclas->urunyon($vt, 1);
                                break;
								
							case "siralama":
                                $yonetimclas->urunyon($vt, 3);
                                break;
//////////////////////////////////////////////////////////////////								
							case "kategoriyon":
                                $yonetimclas->kategoriyon($vt);
                                break;

                            case "kategoriekle":
                                $yonetimclas->kategoriekle($vt);
                                break;

                            case "kategorisil":
                                $yonetimclas->kategorisil($vt);
                                break;

                            case "kategoriguncelle":
                                $yonetimclas->kategoriguncelle($vt);
                                break;
///////////////////////////////////////////////////////////////////	
							case "garsonyon":
							$yonetimclas->garsonyon($vt);
							break;

							case "garsonekle":
							$yonetimclas->garsonekle($vt);
							break;

							case "garsonsil":
							$yonetimclas->garsonsil($vt);
							break;

							case "garsonguncel":
							$yonetimclas->garsonguncel($vt);
							break;
							
							case "garsonper":
							$yonetimclas->garsonper($vt);
							break;
///////////////////////////////////////////////////////////////////		
							case "musteriper":
							$yonetimclas->musteriper($vt);
							break;
							case "aramasonuc":
							$yonetimclas->musteriper($vt, 1);
							break;
///////////////////////////////////////////////////////////////////					
							case "rapor":
                                $yonetimclas->rapor($vt);
                                break;
///////////////////////////////////////////////////////////////////	
							case "sifredegistir":
                                $yonetimclas->sifredegistir($vt);
                                break;
///////////////////////////////////////////////////////////////////
	  case "cikis":
	  $yonetimclas->cikis($yonetimclas->kulad($vt));
	  break;
	  endswitch;
	  ?>

	 		</div>
			</div>
			</div>
			</div>
			</div>
			</div>
			</div>
</body>

</html>

