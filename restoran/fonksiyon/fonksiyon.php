<?php
$db = new mysqli("localhost","root","","restoran")or die ("Bağlanamadı");
$db->set_charset("utf8");


class restoraniskelet{

    public function sorgum($vt,$sorgu,$tercih) {
      $a=$sorgu;
      $b=$vt->prepare($a);//yazılmış olan sorguyu ön belleğe atar,güvenlik içinde kullanılır
      $b->execute();//sorguyu calıstır
      if($tercih==1): //eger tercih eşitse 1 bana getresultu ver
      return	$c=$b->get_result();//sonucu aktarma
      endif;
    }     //ilk sorgum
	public function sorgum2($vt,$sorgu,$tercih) {
	$a=$sorgu;
	$b=$vt->prepare($a);
	$b->execute();
	if($tercih==1):
	return	$c=$b->get_result();
	endif;
}

    //masalaricek.....................................................................
    function masalaricek($dv) {
    $masalar="select * from masalar";
    $sonuc=$this->sorgum($dv,$masalar,1);

    while($masasonuc=$sonuc->fetch_assoc())://masasonuc verisini aktar veri oldukça bu divden oluştur.
      $siparisler='select * from siparis where masaid='.$masasonuc["id"].'';
      $sonuc2=$this->sorgum($dv,$siparisler,1);
	  $this->sorgum($dv,$siparisler,1)->num_rows==0 ? $renk="danger" : $renk="success";

      echo '<div id="masalink" class="col-md-3 col-sm-6 mr-2  mx-auto p-2 text-center text-white">
            <a href="masadetaylari.php?masaid='.$masasonuc["id"].'">
            <div class="bg-'.$renk.' mx-auto p-2 text-center text-white" id="masa">'.$masasonuc["ad"].'</div></a> </div>';
    endwhile;
  
  }


      //masalaricek.....................................................................




  //masa detaylari fonksiyonu........................................................

  function masalarigetir($vt,$id){
    $get="select  *from masalar where id=$id";
    return $this->sorgum($vt,$get,1);

  }
  
   function musterigetir($vt,$id){
    $get="select  *from musteri where id=$id";
    return $this->sorgum($vt,$get,1);

  }

  //masa detaylari fonksiyonu..........................................................


  //masa detaylari fonksiyonu..........................................................

  function urunkategori($db){
     $urunk="select * from kategoriler";
     $gelen=$this->sorgum($db,$urunk,1);
     while($son=$gelen->fetch_assoc()) :
       echo '<a class="btn btn-warning p-2 m-2 text-dark" sectionId="'.$son["id"].'">'.$son["ad"].'</a><br>';
     endwhile;
  }

  //masa detaylari fonksiyonu..........................................................
  function garsonbak($db) {
	   
	   $gelen=$this->sorgum($db,"select * from garson where durum=1",1)->fetch_assoc();
	   
		if (@$gelen["ad"]!="") :
		   
		echo $gelen["ad"];
		
		echo'<a href="islemler.php?islem=cikis" class="m-3"><kbd class="bg-info">ÇIK</kbd></a>';
		
		else:
		
		echo "Giriş yapan garson yok";
		
		endif;
	   
   }


 }
 
?>
