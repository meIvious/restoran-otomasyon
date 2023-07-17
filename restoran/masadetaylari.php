
<?php
	include("fonksiyon/fonksiyon.php");
	$masadetay=new restoraniskelet;
	function sorgum2($vt,$sorgu,$tercih) {
	$a=$sorgu;
	$b=$vt->prepare($a);
	$b->execute();
	if($tercih==1):
	return	$c=$b->get_result();
	endif;
}
	@$masaid=$_GET["masaid"];
	$durumabak = sorgum2($db, "select durum from musterimasa where masaid=$masaid", 1);
	$veri = $durumabak->fetch_assoc();
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="dosyalar/jquery.js"></script>
<link rel="stylesheet" href="dosyalar/bootstrap.css" >

<script>
$(document).ready(function(){
	var id="<?php echo $masaid; ?>";
	$("#veri").load("islemler.php?islem=goster&id="+id);
	$("#veri2").load("islemler.php?islem=goster2&id="+id);

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
	
	
	$('#btn2').click(function(){
		$.ajax({
				type :"POST",
				url  :'islemler.php?islem=ekle2',
				data :$('#ilkform2').serialize(),
				success : function(donen_veri){
					$("#veri2").load("islemler.php?islem=goster2&id="+id);

							$("#donenveri").html(donen_veri).slideUp(2000); //eklendiğinde ekledi yoksa eklenmedimesajı verir
				},
		})
	})
	
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
#rows1{
	height:80px;
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
							<div class="col-md-5	bg-warning  mx-auto text-center" id="rows"><?php echo $dizi["ad"];?></div>
					<!-- masa numarası-->
							<div class="col-md-2	bg-light  mx-auto  text-center" id="rows">Kategoriler</div>

							<div class="col-md-5 	bg-warning  mx-auto  text-center" id="rows">Ürünler</div>
				</div>
					<div class="row border  border-dark" style="min-height:600px;">


						<!-- Hesap-->
						<div class="col-md-5 border-right border-dark">
							<div class="row">
									<div class="col-md-12" style="min-height:550px;">
										<div  class="col-md-12" id="veri"></div>
										<div  class="col-md-12" id="veri2"></div>
										<div id="donenveri"></div>
										
									</div>
										<!-- Hesap-->
										<div class="col-md-12 p-2">
									<a href="index.php" class="btn btn-primary btn-block">Masalara Geri Dön</a>
										</div>
							</div>
						</div>

						<!-- Kategoriler-->
							<div class="col-md-2 border-right border-dark table-dark" id="urunler">
									<div class="row" id="kerem">
									<?php $masadetay->urunkategori($db);?>
									</div>
							</div>
							<!-- Kategoriler-->


									<div class="col-md-5 border-left">
										<div class="row">
											<form id="ilkform">
												<div class="col-md-12" id="sonuc" style="min-height:417px;">	</div>
											</div>
											<div class="row">
												<div class="col-md-12" style="min-height:80px;">

												<?php

													echo'<div class="col-md-12 mx-auto  text-center" id="rows">Adet Girin

													<div class="form-group">
													      <input type="number" class="form-control text-center" min="0" id="email" name="adet">
													    </div>
													</div>';

												?>
												</div>
													</div>
													<div class="row">
												<div class="col-md-12" style="min-height:50px;">
&nbsp;&nbsp;
												<?php
												for($i=1; $i<=8; $i++) :
													echo'<label class="btn btn-secondary m-2"><input name="adet" type="radio" value="'.$i.'"/>'.$i.'</label>';
												endfor;
												?>
												</div>
												
												
													
													
												</div>
												
													<div class="row">
												<div class="col-md-12 p-2">
												
													<input type="hidden" name="masaid" value="<?php echo $dizi["id"];?>"/>
													<input type="button" id="btn" value="EKLE" class="btn btn-success btn-block">


													</div>
														</div>
															</form>
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
<link rel="stylesheet" href="dosyalar/bootstrap.css">
  <script src="dosyalar/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>



  
  <!-- Trigger the modal with a button -->


  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<h4>Müşteri Seçimi</h4>
          
          
        </div>
		
        <div class="modal-body">
		<form id="ilkform2">
		
          <select name="musteri" id="musteri" class="mx-auto p-2" style="width: 100%;height: 40px;">
													  <?phpecho "<option>'.$musteri.'</option>"?>
													  
													<?php
														$baglanti=mysqli_connect("localhost","root","","restoran");
														$sql=mysqli_query($baglanti,"select*from musteri");
														while($row=mysqli_fetch_assoc($sql)) {
														  $ID=$row["ID"];
														  ?> 

														  <?php	  
														  echo "

														  <option name=$musteri value=$ID>".$row["adsoyad"]."</option>";  
														}	
														?>
														
	

													</select>
													
        <div class="mt-3 mx-auto" style="text-align:center;">
			<input type="hidden" name="masaid" value="<?php echo $dizi["id"];?>"/>
			<hr />
			<button type="button" id="btn2" class="btn btn-danger mx-auto" data-dismiss="modal">Masayı Aç</button>
		</div>
</form>
        </div>
      </div>
      
    </div>
  </div>
  


<script>
$(document).ready(function(){
	var durum = "<?php echo $veri; ?>";
	
	if (durum==0) {
		$("#myModal").modal({
		backdrop: 'static',
		keyboard: false
	});
	}
	else  {
		$('#myModal').modal('hide');
	}
	
});
</script>
