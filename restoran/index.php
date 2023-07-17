<?php
	include("fonksiyon/fonksiyon.php");
	$restoraniskelet=new restoraniskelet;
	$veri=$restoraniskelet->sorgum2($db,"select * from garson where durum=1",1)->num_rows;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
#rows{
    height:80px;
  }
#yonet:hover a{
	color:		#000000;
}
#yonet:hover {
	background-color:#EEEEEE;
	border-radius: 10px;
}

#ana{
	height:50px;
	width:100
	font-size:20px;
	font-family:Comic Sans MS;
}

#kucuk{
	color:#000000;

}
#mus{
	height:5px;
}

</style>
<script src="dosyalar/jquery.js"></script>
<link rel="stylesheet" href="dosyalar/bootstrap.css" >
<link rel="stylesheet" href="dosyalar/style.css" >
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<title>Restoran Otomasyonu</title>
<script>
$(document).ready(function() {
	var deger = "<?php echo $veri; ?>";
	
	if (deger==0) {
		$('#girismodal').modal({
		backdrop: 'static',
		keyboard: false
	})
	$('body').on('hidden.bs.modal','.modal', function() {
		$(this).removeData('bs.modal');
	});
	}
	else  {
		$('#girismodal').modal('hide');
	}

	
	$('#girisbak').click(function() {
			$.ajax({
					type :"POST",
					url  :'islemler.php?islem=kontrol',
					data :$('#garsonform').serialize(),
					success : function(donen_veri){
						$('#garsonform').trigger("reset");
						$('.modalcevap').html(donen_veri);
					},
			})
		})
	
});
</script>

<body style="background-color:#e5e5e5">



  <div class="container-fluid">
  <div class="row table-dark" id="rows">
	<div class="col-md-3 border-right text-center" style="align:center;"><br>Garson Adı : <a class="text-warning"><?php $restoraniskelet->garsonbak($db);?></a></div>				
	<div class="col-md-3 border-right text-center"><br>Tarih  : <a class="text-warning"><?php echo date("d.m.Y");?></a></div>
	<div class="col-md-3 border-right text-center"><a href="musterikayit.php" class="btn btn-info mx-auto mt-3" style="width: 200px;height: 40px;">Yeni Müşteri Kayıt</a></div>
	<div class="col-md-3 text-center">
	<div id="yonet" class="col-md-6 col-sm-6 m-1  mx-auto p-2 text-center text-black bg-gray">
	<a href="anasayfa.php" style="text-decoration:none;" id="ana"><i class="fa fa-user" id="kucuk" style="font-size:36px;"></i> ANASAYFA
	<div class="bg-gray mx-auto p-2 text-center text-black" id="yonet"></div></a> </div></div>
  </div>

			  		<div class="row">
			          <?php
			            $restoraniskelet->masalaricek($db);
			          ?>
			      </div>
				  <!-- The Modal -->
  <div class="modal fade" id="girismodal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header text-center">
          <h4 class="modal-title">Garson Girişi</h4>
          
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
        
        
         <form id="garsonform">
         
         <div class="row mx-auto text-center">
         
         
         
         		<div class="col-md-12">Garson Ad</div>
        		 <div class="col-md-12"><select name="ad" class="form-control mt-2">
                  <option value="0">Seç</option>
				  
				  <?php
					
					$b=$restoraniskelet->sorgum2($db,"select * from garson",1);
					while ($garsonlar=$b->fetch_assoc()) :
					echo '<option value="'.$garsonlar["ad"].'">'.$garsonlar["ad"].'</option>';
					endwhile;
					?>
				  
              
                </select></div>
				
        
         
        		
         
        		 <div class="col-md-12">Şifre </div>         
                <div class="col-md-12">
                <input name="sifre" type="password" class="form-control  mt-2" />                
                </div>  
                 
                
                <div class="col-md-12">
               <input type="button" id="girisbak" value="GİR" class="btn btn-info mt-4"/>                
                </div>
         
         </div>
         
         
         </form>
        </div>
        
        
         <div class="modalcevap">
          
        </div>
     
        
      </div>
    </div>
  





</body>
</html>