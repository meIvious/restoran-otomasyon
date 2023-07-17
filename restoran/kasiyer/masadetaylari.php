
<?php
	include("fonksiyon/fonksiyon.php");
	$masadetay=new restoraniskelet;
	@$masaid=$_GET["masaid"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="../dosyalar/jquery.js"></script>
<link rel="stylesheet" href="../dosyalar/bootstrap.css" >

<script>
$(document).ready(function(){
	var id="<?php echo $masaid; ?>";
	$("#veri").load("islemler.php?islem=goster&id="+id);

	$('#btn').click(function(){
		$.ajax({
				type :"POST",
				url  :'islemler.php?islem=ekle',
				data :$('#ilkform').serialize(),
				success : function(donen_veri){
					$("#veri").load("islemler.php?islem=goster&id="+id);
							$('#ilkform').trigger("reset"); //seçilenleri ekledikten sonra temizler
							$("#donenveri").html(donen_veri).slideUp(2000); //eklendiğinde ekledi yoksa eklenmedimesajı verir
				},
		})
	})
	
					$("#veri2").load("islemler.php?islem=goster2&id="+id);
					
	$('#urunler a').click(function(){
		var sectionId=$(this).attr('sectionId');
		$("#sonuc").load("islemler.php?islem=urun&kategorid=" + sectionId).fadeIn();

	})
});

</script>

<title>Masa Detayları</title>

<style>
#rows{
	height:50px;
	font-size:30px;
	font-family:Comic Sans MS;
}
#kategorirows{
	height:50px;
	font-size:30px;
	margin-top: 21px;
}


</style>
<body>
<?php

	if($masaid!=""):
		$son=$masadetay->masalarigetir($db,$masaid);
		$dizi=$son->fetch_assoc();

?>

  <div class="container-fluid">

				<div class="row" id="rows">
					<!-- masa numarası-->
							<div class="col-md-12	bg-warning  mx-auto text-center" id="rows"><?php echo $dizi["ad"];?></div>
					<!-- masa numarası-->
							
				</div>
					<div class="row border  border-dark" style="min-height:600px;">


						<!-- Hesap-->
						<div class="col-md-12 border-right border-dark">
							<div class="row">
									<div class="col-md-6 mx-auto" style="min-height:551px;">
										<div  class="col-md-12" id="veri"></div>
										<div  class="col-md-12" id="veri2"></div>
										
										<div id="donenveri"></div>
									</div>
									</div>
										<!-- Hesap-->
										<div class="col-md-6 p-2 mx-auto">
									<a href="index.php" class="btn btn-primary btn-block">Masalara Geri Dön</a>
										</div>
							
						</div>
					
										
						<!-- Kategoriler-->
							
							<!-- Kategoriler-->


						
										</div>
										



				</div>

		</div>
<?php
else:
	echo"hata var";
endif;
?>
</div>
</body>
</html>
