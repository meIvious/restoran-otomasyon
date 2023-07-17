	
<?php
session_start();
include("fonksiyon/fonksiyon.php");
@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script src="dosyalar/jquery.js"></script>
<link rel="stylesheet" href="dosyalar/bootstrap.css" >
<link rel="stylesheet" href="dosyalar/style.css" >

<script>
$(document).ready(function(){
	$('#hesapalbtn').click(function(){
		$.ajax({
				type :"POST",
				url  :'islemler.php?islem=hesap',
				data :$('#hesapal').serialize(),
				success : function(donen_veri){
					$('#hesapal').trigger("reset");
						window.location.reload();
				},
		})
	})
	$('#yakala a').click(function() {
		var sectionId=$(this).attr('sectionId');
		$.post("islemler.php?islem=sil",{"urunid":sectionId},function(post_veri){
			window.location.reload();
		})
	})
});
</script>
<title>Restaurant Otomasyonu</title>
</head>
<body>
<?php

function sorgum2($vt,$sorgu,$tercih) {
	$a=$sorgu;
	$b=$vt->prepare($a);
	$b->execute();
	if($tercih==1):
	return	$c=$b->get_result();
	endif;
}

	function uyari($mesaj,$renk){
		echo '<div class="alert alert-'.$renk.' mt-4 text-center">'.$mesaj.' </div>';
	}

	@$islem=$_GET["islem"];

	switch($islem):

		case "hesap" :
			if(!$_POST):

				echo "posttan gelmiyorsun";
			else:
				$masaid=htmlspecialchars($_POST["masaid"]);
				$sorgu="select * from siparis where masaid=$masaid";
				$verilericek=sorgum2($db,$sorgu,1);
				while($don=$verilericek->fetch_assoc()) :
					$a=$don["masaid"];
					$b=$don["garsonid"];
					$c=$don["urunid"];
					$d=$don["urunad"];
					$e=$don["urunfiyat"];
					$f=$don["adet"];
					$g=$don["musteri"];
					$bugun = date ("Y-m-d");
				$raporekle="insert into rapor (masaid,garsonid,urunid,urunad,urunfiyat,adet,musteri,tarih)
				VALUES($a,$b,$c,'$d',$e,$f,'$g','$bugun')";
				$raporekles=$db->prepare($raporekle);
				$raporekles->execute();
				
				$urunebak = sorgum2($db, "select stok from urunler where id=$c", 1);
				$urunbilgi = $urunebak->fetch_assoc();
				if ($urunbilgi["stok"]!="Yok") :
				$urunStokson=$urunbilgi["stok"] - $e;
			
				$raporekles = $db->prepare("update urunler set stok='$urunStokson' where id=$b");
				$raporekles->execute();
				endif;
				endwhile;
				$sorgu="delete  from siparis where masaid=$masaid";
				$silme=$db->prepare($sorgu);
				$silme->execute();

			endif;

	break;

		case "sil":
			if(!$_POST):
				echo "Posttan Gelmiyorsun";
			else:
				$gelenid=htmlspecialchars($_POST["urunid"]);
				$sorgu="delete from siparis where urunid=$gelenid";
				$silme=$db->prepare($sorgu);
	      $silme->execute();
				uyari("Ürün Silindi","success");
			endif;
	break;

		case "goster"://goster............................................

	 $id=htmlspecialchars($_GET["id"]);

		$a="select * from siparis where masaid=$id";
		$d=sorgum2($db,$a,1);

		if($d->num_rows==0) :

		uyari("Henüz Sipariş Yok","warning");

		else:

			echo '<table class="table table-bordered  text-center">
			<thead>
			<tr class="bg-dark text-white">
			<th scope="col">Ürün Adı</th>
			<th scope="col">Adet</th>
			<th scope="col">Tutar</th>
			<th scope="col">İşlem</th>
				</tr>
				</thead>
				<tbody>';
				$adet=0;
				$sontutar=0;

				while($gelensonuc=$d->fetch_assoc()) :
					$tutar=$gelensonuc["adet"] * $gelensonuc["urunfiyat"];
					$adet +=$gelensonuc["adet"];
					$sontutar +=$tutar;
					$masaid=$gelensonuc["masaid"];
					
					echo '<tr>
						<td class="mx-auto text-center p-4">'.$gelensonuc["urunad"].'</td>
						<td class="mx-auto text-center p-4">'.$gelensonuc["adet"].'</td>
						<td class="mx-auto text-center p-4">'.$tutar.'</td>
							<td id="yakala"><a class="btn btn-danger mt-2 text-white" sectionId="'.$gelensonuc["urunid"].'">Sil</a></td>
				</tr>';

			endwhile;
			echo '
			<tr class="bg-dark text-white text-center">
				<td class="font-weight-bold">Toplam</td>
				<td class="font-weight-bold">'.$adet.'</td>
				<td colspan="2" class="font-weight-bold text-warning">'.$sontutar.' TL</td>
			</tr>
			
			</tbody></table>

			<div class="row">
			&nbsp;
			
			</div>';

		endif;

		break;
		
		
		
		
		
		case "goster2"://goster............................................

	 $id=htmlspecialchars($_GET["id"]);

		$a2="select * from musterimasa where masaid=$id";
		$d2=sorgum2($db,$a2,1);

		if($d2->num_rows==0) :

		uyari("Henüz Müşteri Yok","primary");

		else:

			

				while($gelensonuc=$d2->fetch_assoc()) :
					
					$ad=$gelensonuc["adsoyad"];
					
					

			endwhile;
			echo '
			<table class="table table-bordered  text-center">
			
				<tbody>
			<tr class="bg-dark text-white text-center">
				<td class="col-md-6 font-weight-bold">MÜŞTERİ BİLGİSİ</td></tr>
				<tr class="bg-dark text-white text-center">
				<td class="col-md-6 font-weight-bold text-success">'.$ad.'</td>
			</tr>
			</tbody></table>

			<div class="row">
			&nbsp;
			
			</div>';

		endif;

		break;
		
		
		
		
		
		
		
		
		

		case "ekle":

		if($_POST):

		@$masaid=htmlspecialchars($_POST["masaid"]);
		@$urunid=htmlspecialchars($_POST["urunid"]);
		@$adet=htmlspecialchars($_POST["adet"]);
		
		

		if($masaid=="" || $urunid=="" || $adet==""):
		uyari(" Boş Alan Bırakmayın","danger");


		else:
			$varmi="select * from siparis where urunid=$urunid and masaid=$masaid";
			$var=sorgum2($db,$varmi,1);
		if($var->num_rows!=0) :
			$urundizi=$var->fetch_assoc();
			$sonadet=$adet + $urundizi["adet"];
			$islemid=$urundizi["id"];	
						
			$guncel="UPDATE siparis set adet=$sonadet where id=$islemid";
			$guncelsonuc=$db->prepare($guncel);
			$guncelsonuc->execute();
				uyari("Adet Güncellendi","success"); 
				
				
		else:
			$gelen = sorgum2($db, "select * from garson where durum = 1", 1)->fetch_assoc();
                $garsonidyaz = $gelen["id"];
			$gelen = sorgum2($db, "select musteriid from musterimasa where masaid=$masaid", 1)->fetch_assoc();
                $musteriidyaz = $gelen["musteriid"];
			
			$a="select * from urunler where id=$urunid";
			$d=sorgum2($db,$a,1);
			$son=$d->fetch_assoc();
			$urunad=$son["ad"];
			$urunfiyat=$son["fiyat"];
			
			
			
			
			
		
			$ekle="insert into siparis (masaid,garsonid,urunid,musteriid,urunad,urunfiyat,adet) VALUES
			($masaid,$garsonidyaz,$urunid,$musteriidyaz,'$urunad',$urunfiyat,$adet)";
			$eklesonuc=$db->prepare($ekle);
			$eklesonuc->execute();

				uyari("Ürün Eklendi","success");

		endif;
	endif;
		else:

				uyari("Hata Var","danger");

		endif;

		break;

		case "urun":
	    	$kategorid=htmlspecialchars($_GET["kategorid"]);
				$a="select * from urunler where katid=$kategorid";
				$d=sorgum2($db,$a,1);

				while($sonuc=$d->fetch_assoc()):
					echo'<label class="btn btn-dark m-3">
				<input name="urunid" type="radio" value="'.$sonuc["id"].'"/>'.$sonuc["ad"].'</label>';
				endwhile;
		break;
		
		
		
		
		
		
		
		case "ekle2":

		if($_POST):

		@$masaid=htmlspecialchars($_POST["masaid"]);
		@$musteri=htmlspecialchars($_POST["musteri"]);
		

		if($musteri=="" || $masaid==""):
		uyari(" Boş Alan Bırakmayın","danger");
			
			
			else:
			$gelen = sorgum2($db, "select * from musteri where adsoyad='$musteri'", 1)->fetch_assoc();
                $musteriidyaz = $gelen["id"];

			$ekle="insert into musterimasa (masaid,musteriid,adsoyad) VALUES
			($masaid,$musteriidyaz,'$musteri')";
			$eklesonuc=$db->prepare($ekle);
			$eklesonuc->execute();

				uyari("Müşteriye masa açıldı","success");
endif;

		else:

				uyari("Hata Var","danger");

endif;
		break;

		case "urun":
	    	$kategorid=htmlspecialchars($_GET["kategorid"]);
				$a="select * from urunler where katid=$kategorid";
				$d=sorgum2($db,$a,1);

				while($sonuc=$d->fetch_assoc()):
					echo'<label class="btn btn-dark m-3">
				<input name="urunid" type="radio" value="'.$sonuc["id"].'"/>'.$sonuc["ad"].'</label>';
				endwhile;
		break;
		
		
		
		
		
		
		
		
		
		
	case "kontrol" :
	$ad=htmlspecialchars($_POST["ad"]);
	$sifre=htmlspecialchars($_POST["sifre"]);
	
	if (@$ad!="" && @$sifre!="") :
	
	$var=sorgum2($db,"select * from garson where ad='$ad' and sifre='$sifre'",1);
	
	if ($var->num_rows==0) :
	echo'<div class="alert alert-danger text-center">Bilgiler uyuşmuyor</div>';
	else:
	$garson=$var->fetch_assoc();
	$garsonid=$garson["id"];
	sorgum2($db,"update garson set durum=1 where id=$garsonid",1);
	
	?>
	<script>
	window.location.reload();
	</script>
	<?php
	endif;
	
	else:
	
	echo'<div class="alert alert-danger text-center">Boş bölüm bırakma</div>';
	endif;
	break;
	
	case "cikis":
	sorgum2($db,"update garson set durum=0",1);
	header("Location:index.php");
	?>
	<script>
	window.location.reload();
	</script>
	<?php
	break;

	endswitch;
?>
</body>
</html>
