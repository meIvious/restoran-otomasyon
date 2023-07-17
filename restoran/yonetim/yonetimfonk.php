<?php
ob_start();
$vt=new mysqli("localhost","root","","restoran") or die ("Bağlanamadı");
$vt->set_charset("utf8");


class yonetici {
	
	protected  $toplamsayi,$toplamSayfamiz,$limitimiz,$gosAdet;




function sayfalama ($deger1,$deger2) {
	
		$this->toplamsayi=$deger1; //**
		$this->gosAdet=$deger2; //**
			
		$this->toplamSayfamiz=ceil($deger1 / $this->gosAdet) + 1;			
		
			  						
		$sayfa=isset($_GET["hareket"]) ? (int) $_GET["hareket"] : 1;		
		if ($sayfa<1) $sayfa=1;				
		if ($sayfa > $this->toplamSayfamiz) $sayfa = $this->toplamSayfamiz;		
		$this->limitimiz=($sayfa - 1 ) * $this->gosAdet;	 //**	
	
	
	
}

  private function sorgum3 ($dv,$sorgu){
		$sorgum=$dv->prepare($sorgu);
		$sorgum->execute();
		return $sorguson=$sorgum->get_result();
	}

  private function uyari($tip,$metin,$sayfa){
		echo '<div class="alert alert-'.$tip.'">'.$metin.'</div>';
		header('refresh:2,url='.$sayfa.'');
	}

  function kulad($db){
    $sorgu="select * from yonetici";
    $gelensonuc=$this->sorgum3($db,$sorgu);
    $b=$gelensonuc->fetch_assoc();
    return $b["kulad"];
  }

  function cikis ($deger) {
    $deger=md5(sha1(md5($deger)));
    setcookie("kul",$deger, time() - 10);
    $this->uyari("success","Çıkış yapılıyor","index.php");
  }



  function toplamsiparisadeti($vt) {
    $geldi=$this->sorgum3($vt,"select SUM(adet) from siparis")->fetch_assoc();
    echo $geldi['SUM(adet)'];
  }


  function toplamurunler($vt){
      echo $this->sorgum3($vt,"select*from urunler")->num_rows;
  }

  function hasilat($vt){
	  $geldi1 = $this->sorgum3($vt,"select * from gecicigarson");
                                $toplamhasilat = 0;
                                while ($listele = $geldi1->fetch_assoc()):
                                        $toplamhasilat += $listele["hasilat"];
                                endwhile;
								echo "$toplamhasilat";
  }

  public   function giriskontrolu($r,$k,$s){
      $sonhal=md5(sha1(md5($s)));
      $sorgu="select * from yonetici where kulad='$k' and sifre='$sonhal'";
      $sor=$r->prepare($sorgu);
      $sor->execute();
      $sonbilgi=$sor->get_result();

      if($sonbilgi->num_rows==0):

        $this->uyari("danger","Bilgiler Hatalı","index.php");
        else:
        $this->uyari("success","Giriş Yapılıyor","ayarlar.php");

      $kulson=md5(sha1(md5($k)));
      setcookie("kul",$kulson, time() + 60*60*24);

      endif;
    }

    public  function cookcon($d,$durum=false) {
  		if(isset($_COOKIE["kul"])) :

  		 $deger=$_COOKIE["kul"];

       $sorgu="select * from yonetici";
  		 $sor=$d->prepare($sorgu);
  		 $sor->execute();
  		 $sonbilgi=$sor->get_result();
       $veri=$sonbilgi->fetch_assoc();
       $sonhal=md5(sha1(md5($veri["kulad"])));
  		 if ($sonhal!=$_COOKIE["kul"]):
  		setcookie("kul",$deger, time() - 10);
  		  header("Location:index.php");
      else:
       if ($durum==true) : header("Location:ayarlar.php"); endif;
     endif;

   else:
   if($durum==false) : header("Location:index.php");
  	endif;
  	endif;
  }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////// Masa yönetimi ve listeleme fonksiyonu///////////////////
        public function masayon ($vt) {
			
        	$this->sayfalama($this->sorgum3($vt,"select * from masalar")->num_rows,5);		
			$so=$this->sorgum3($vt,"select * from masalar LIMIT ".$this->limitimiz.",".$this->gosAdet."");
				
			
        echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4">
        <thead>
            <tr>
                <th scope="col">MASA ADI <a href = "ayarlar.php?islem=masaekle" class="btn btn-success">+</a></th>
                <th scope="col">GÜNCELLE</th>
                <th scope="col">SİL</th>
            </tr>
        </thead>
        <tbody>';

        while ($sonuc=$so->fetch_assoc()):
            echo    '<tr>
                        <td>'.$sonuc["ad"].'</td>
                        <td><a href = "ayarlar.php?islem=masaguncelle&masaid='.$sonuc["id"].'" class="btn btn-warning"</a>Güncelle</td>
                        <td><a href = "ayarlar.php?islem=masasil&masaid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Masayı silmek istediğinize emin misiniz?"</a>Sil</td>
                    </tr>';

        endwhile;

        echo '</tbody>           
			<tr>		
		<td colspan="5">
		<nav aria-label="Page navigation example">
		
				<ul class="pagination mx-auto">';
							
				$link="ayarlar.php?islem=masayon";
				
			
					for ($s=1; $s<$this->toplamSayfamiz; $s++) :
						
						echo '<li class="page-item">
						
						<a class="page-link" href="'.$link.'&hareket='.$s.'">'.$s.'</a>					
						
						</li>';
						
						endfor;

				
				echo '</ul></nav>
		
		
		</td>
	
		</tr>

			</table>';

    }

////////////////////////// Yönetici masa sil fonksiyonu///////////////////
    public function masasil ($vt) {
        $masaid = $_GET["masaid"];

        if ($masaid != "" && is_numeric($masaid)):
            $this->sorgum3($vt, "delete from masalar where id=$masaid");
            $this->uyari("success", "Masa Silindi", "ayarlar.php?islem=masayon");
        else:
            $this->uyari("danger", "Hata Oluştu", "ayarlar.php?islem=masayon");

        endif;
    }

/////////////////////// Yönetici masa güncelle fonksiyonu/////////////////
    public function masaguncelle($vt) {

        @$buton = $_POST["buton"];

        echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :
                // db işlemleri
                @$masaad = htmlspecialchars($_POST["masaad"]);
                @$masaid = htmlspecialchars($_POST["masaid"]);

                if ($masaad == "" || $masaid == "") :
                    $this->uyari("danger","Bilgiler boş olamaz","ayarlar.php?islem=masayon");

                else:
                    $this->sorgum3($vt, "update masalar set ad = '$masaad' where id = $masaid");
                    $this->uyari("success","Masa Güncellendi","ayarlar.php?islem=masayon");

                endif;
        else:
            $masaid = $_GET["masaid"];
            $aktar = $this->sorgum3($vt, "select * from masalar where id = $masaid")->fetch_assoc();

            echo '
                    <form action = "" method = "post">

                        <div class="col-md-12 table-light border-bottom"><h4>MASA GÜNCELLE</h4></div>
                        <div class="col-md-12 table-light"><input type = "text" name = "masaad" class = "form-control mt-3" value = "'.$aktar["ad"].'"/></div>
                        <div class="col-md-12 table-light"><input name = "buton" value = "Güncelle" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>

                        <input type = "hidden" name = "masaid" value = "'.$aktar["id"].'"/>
                    </form>
                ';

        endif;

        echo '</div>';

    }

////////////////////////////// Yönetici masa ekle fonksiyonu//////////////////////////////
    public function masaekle ($vt) {

        @$buton = $_POST["buton"];

        if ($buton) :
                // db işlemleri
                @$masaad = htmlspecialchars($_POST["masaad"]);

                if ($masaad == "") :
                    $this->uyari("danger", "Masa adı boş olamaz", "ayarlar.php?islem=masayon");

                else:
                    $this->sorgum3($vt, "insert into masalar (ad) values ('$masaad')");
                    $this->uyari("success", "Masa Eklendi", "ayarlar.php?islem=masayon");

                endif;

        else:

            echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">
                    <form action = "" method = "post">

                        <div class="col-md-12 table-light border-bottom"><h4>MASA EKLE</h4></div>
                        <div class="col-md-12 table-light"><input type = "text" name = "masaad" class = "form-control mt-3" require /></div>
                        <div class="col-md-12 table-light"><input name = "buton" value = "Ekle" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>

                    </form>
                </div>';

        endif;
    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Yönetici Ürün Ekleme - Güncelleme - Silme Fonksiyonları
    public function urunyon ($vt, $tercih) {

        if ($tercih == 1):
            // Kategori içerisinde arama
            $aramabuton = $_POST["aramabuton"];
            $urun = $_POST["urun"];

            if ($aramabuton):
                $so=$this->sorgum3($vt, "select * from urunler where ad LIKE '%$urun%'");
            endif;

            elseif ($tercih == 2):
            // Kategorileri listeleme
                $arama = $_POST["arama"];
                $katid = $_POST["katid"];

                if ($arama):
                    $so=$this->sorgum3($vt, "select * from urunler where katid = $katid");
                endif;
			elseif ($tercih == 3):

				$olcu=@$_GET["olcu"];
                $so=$this->sorgum3($vt, "select * from urunler where stok<>0 order by stok $olcu");

            elseif ($tercih == 0):
			$this->sayfalama($this->sorgum3($vt,"select * from urunler")->num_rows,5);		
			$so=$this->sorgum3($vt,"select * from urunler LIMIT ".$this->limitimiz.",".$this->gosAdet."");
                
        endif;

        // Yönetim Paneli Ürün Arama Bölümü
        echo '<table class="table text-center table-striped table-bordered mx-auto col-md-7 mt-4 table-dark">
                <thead>
                    <tr>
                        <th><form action="ayarlar.php?islem=aramasonuc" method="post"><input type="search" name="urun" class="form-control" placeholder="🔍 Ürün adı..."/></th>

                        <th><input type="submit" name="aramabuton" value="ARA" class="btn btn-danger"/></form></th>

                        <th><form action="ayarlar.php?islem=katgore" method="post"><select name="katid" class="form-control">';

                                $kategorilistesi = $this->sorgum3($vt, "select * from kategoriler");

                                while ($katson = $kategorilistesi->fetch_assoc()) :
                                    echo '<option value="'.$katson["id"].'">'.$katson["ad"].'</option>';
                                endwhile;

        echo '</select></th>
                    <th><input type="submit" name="arama" value="GETİR" class="btn btn-danger"/></form></th>
                    </tr>
                </thead>
             </table>';

        echo '<table class="table text-center table-striped table-bordered table-hover mx-auto col-md-7 mt-4">
        <thead>
            <tr>
                <th scope="col">ÜRÜN ADI <a href = "ayarlar.php?islem=urunekle" class="btn btn-success">+</a></th>
                <th scope="col">FİYAT</th>
				<th scope="col">STOK <a href="ayarlar.php?islem=siralama&olcu=desc"><i class="fas fa-arrow-up" style=font-size:12px;color:blue;"></i></a> | <a href="ayarlar.php?islem=siralama&olcu=asc"><i class="fas fa-arrow-down" style=font-size:12px;color:blue;"></i></a></th>
                <th scope="col">GÜNCELLE</th>
                <th scope="col">SİL</th>
            </tr>
        </thead>
        <tbody>';

        while ($sonuc=$so->fetch_assoc()):
            echo    '<tr>
                        <td>'.$sonuc["ad"].'</td>
                        <td>'.$sonuc["fiyat"].'</td>
						<td>';
						if ($sonuc["stok"]=="Yok") :
						echo '<font class="text-danger"><b>-</b></font>';

						else:
						echo '<font class="text-success"><b>'.$sonuc["stok"].'</b></font>';

						endif;


						echo'</td>
                        <td><a href = "ayarlar.php?islem=urunguncelle&urunid='.$sonuc["id"].'" class="btn btn-warning"</a>Güncelle</td>
                        <td><a href = "ayarlar.php?islem=urunsil&urunid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Ürünü silmek istediğinize emin misiniz?"</a>Sil</td>
                    </tr>';

        endwhile;

        echo '</tbody>
		
		<tr>		
		<td colspan="5">
		<nav aria-label="Page navigation example">
		
				<ul class="pagination mx-auto">';
							
				$link="ayarlar.php?islem=urunyon";
				
			
					for ($s=1; $s<$this->toplamSayfamiz; $s++) :
						
						echo '<li class="page-item">
						
						<a class="page-link" href="'.$link.'&hareket='.$s.'">'.$s.'</a>					
						
						</li>';
						
						endfor;

				
				echo '</ul></nav>
		
		
		</td>
	
		</tr>
		
            </table>';

    }

    // Yönetici ürün silme fonksiyonu
    public function urunsil ($vt) {
        @$urunid = $_GET["urunid"];

        if ($urunid != "" && is_numeric($urunid)):

            $satir = $this->sorgum3($vt, "select * from siparis where urunid = $urunid");

            if ($satir->num_rows != 0):

                echo '<div class = "alert alert-info mt-5">
                Bu ürün aşağıdaki masalarda sipariş olarak mevcut;<br>';
                while ($masabilgi = $satir->fetch_assoc()):
                    $masaid = $masabilgi["masaid"];
                    $masasonuc = $this->sorgum3($vt, "select * from masalar where id = $masaid")->fetch_assoc();

                    echo "- ".$masasonuc["ad"]."<br>";
                endwhile;
                echo '</div>';

            else:
                $this->sorgum3($vt, "delete from urunler where id=$urunid");
                $this->uyari("success", "Ürün Silindi", "ayarlar.php?islem=urunyon");
            endif;


        else:
            $this->uyari("danger", "Hata Oluştu", "ayarlar.php?islem=urunyon");

        endif;
    }

    // Yönetici ürün güncelleme fonksiyonu
    public function urunguncelle($vt) {

        @$buton = $_POST["buton"];

        echo '<div class="col-md-3 text-center mx-auto mt-4 table-bordered">';

					$urunid = $_GET["urunid"];
                    $aktar = $this->sorgum3($vt, "select * from urunler where id = $urunid")->fetch_assoc();


        if ($buton) :
                // db işlemleri
                @$urunad = htmlspecialchars($_POST["urunad"]);
                @$urunid = htmlspecialchars($_POST["urunid"]);
                @$fiyat = htmlspecialchars($_POST["fiyat"]);
				@$stok = htmlspecialchars($_POST["stok"]);
				@$tercih = htmlspecialchars($_POST["tercih"]);
                @$katid = htmlspecialchars($_POST["katid"]);

                if ($urunad == "" || $urunid == "" || $fiyat == ""	 || $katid == "") :
                    $this->uyari("danger", "Bilgiler boş olamaz", "ayarlar.php?islem=urunyon");

                else:

				if ($stok!="") :
					if ($tercih=="ekle") :
					$sonstok=$stok + $aktar["stok"];
					elseif ($tercih=="sil") :
					$sonstok=$aktar["stok"] - $stok;
					endif;
				else:
					$sonstok=$aktar["stok"];
				endif;


                    $this->sorgum3($vt, "update urunler set ad = '$urunad', fiyat = $fiyat , stok = $sonstok, katid = $katid where id = $urunid");
                    $this->uyari("success", "Ürün Güncellendi", "ayarlar.php?islem=urunyon");

                endif;
                else:

            ?>
                    <form action = "<?php $_SERVER['PHP_SELF']; ?>" method = "post">

            <?php

                    echo '<div class="col-md-12 table-light border-bottom"><h4>ÜRÜN GÜNCELLE</h4></div>
                        <div class="col-md-12 table-light"><b>Ürün Adı</b><input type = "text" name = "urunad" class = "form-control mt-3" value = "'.$aktar["ad"].'"/></div>
                        <hr>
						<div class="col-md-12 table-light"><b>Ürün Fiyat</b><input type = "text" name = "fiyat" class = "form-control mt-3" value = "'.$aktar["fiyat"].'"/></div>
                        <hr>
						<div class="col-md-12 table-light">';

                            $katid = $aktar["katid"];
                            $katcek = $this->sorgum3($vt, "select * from kategoriler");

                            echo 'Kategori  <select name = "katid" class = "mt-3">';

                            while ($katson = $katcek->fetch_assoc()):

                                if ($katson["id"] == $katid):

                                    echo '<option value = "'.$katson["id"].'" selected = "selected">'.$katson["ad"].'</option>';

                                else:

                                    echo '<option value = "'.$katson["id"].'">'.$katson["ad"].'</option>';

                                endif;

                            endwhile;

                           echo '</select>';

                        echo  '</div>
						<hr>

						<div class="col-md-12 table-light mt-2"><b>Stok</b></div>
						<div class="col-md-12 table-light mt-2 text-success">Mevcut Stok ('.$aktar["stok"].')</div>
						<div class="col-md-12 table-light mt-2"><input type = "text" name = "stok" class = "form-control mt-3"/></div>

						<div class="col-md-12 table-light mt-2">EKLE <input type="radio" name="tercih" value="ekle" class="mr-5" checked="checked"/>
						SİL <input type="radio" name="tercih" value="sil"/></div>


						<hr>

                            <div class="col-md-12 table-light"><input name = "buton" value = "Güncelle" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>
                            <input type = "hidden" name = "urunid" value = "'.$urunid.'"/>

                    </form>';

            endif;

        echo '</div>';

    }

        // Yönetici ürün ekleme fonksiyonu
        public function urunekle($vt) {

            @$buton = $_POST["buton"];

            echo '<div class="col-md-3 text-center mx-auto mt-4 table-bordered">';

            if ($buton) :
                    // db işlemleri
                    @$urunad = htmlspecialchars($_POST["urunad"]);
                    @$fiyat = htmlspecialchars($_POST["fiyat"]);
                    @$katid = htmlspecialchars($_POST["katid"]);
					@$stok = htmlspecialchars($_POST["stok"]);
					@$tercih = htmlspecialchars($_POST["tercih"]);

                    if ($urunad == "" || $fiyat == "" || $katid == "") :
                        $this->uyari("danger", "Bilgiler boş olamaz", "ayarlar.php?islem=urunyon");

                    else:

					if ($stok!="") :
					if ($tercih=="var") :
					$sonstok=$stok;
					elseif ($tercih=="yok") :
					$sonstok="Yok";
					endif;
				else:
					$sonstok="Yok";
				endif;



                        $this->sorgum3($vt, "insert into urunler (katid, ad, fiyat, stok) values ($katid, '$urunad', $fiyat, '$sonstok')");
                        $this->uyari("success", "Ürün Eklendi", "ayarlar.php?islem=urunyon");

                    endif;
                    else:

                ?>
                        <form action = "<?php $_SERVER['PHP_SELF']; ?>" method = "post">

                <?php

                        echo '<div class="col-md-12 table-light border-bottom"><h4>ÜRÜN EKLE</h4></div>
                            <div class="col-md-12 table-light">Ürün Adı<input type = "text" name = "urunad" class = "form-control mt-3"/></div>
                            <hr>
							<div class="col-md-12 table-light">Ürün Fiyat<input type = "text" name = "fiyat" class = "form-control mt-3"/></div>
                            <hr>
							<div class="col-md-12 table-light">';

                                $katcek = $this->sorgum3($vt, "select * from kategoriler");

                                echo 'Kategori  <select name = "katid" class = "mt-3">';

                                while ($katson = $katcek->fetch_assoc()):

                                    echo '<option value = "'.$katson["id"].'">'.$katson["ad"].'</option>';

                                endwhile;

                               echo '</select>';

                            echo  '</div>
							<hr>
							<div class="col-md-12 table-light mt-2"><b>Stok</b></div>
						<div class="col-md-12 table-light mt-2"><input type = "text" name = "stok" class = "form-control mt-3"/></div>

						<div class="col-md-12 table-light mt-2">VAR <input type="radio" name="tercih" value="var" class="mr-5"/>
						YOK <input type="radio" name="tercih" value="yok" checked="checked"/></div>

							<hr>


                                <div class="col-md-12 table-light"><input name = "buton" value = "EKLE" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>

                        </form>';

                endif;

            echo '</div>';

        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function kategoriyon ($vt) {
        $this->sayfalama($this->sorgum3($vt,"select * from kategoriler")->num_rows,5);		
$so=$this->sorgum3($vt,"select * from kategoriler LIMIT ".$this->limitimiz.",".$this->gosAdet."");

        echo '<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4">
        <thead>
            <tr>
                <th scope="col">KATEGORİ ADI <a href = "ayarlar.php?islem=kategoriekle" class="btn btn-success">+</a></th>
                <th scope="col">GÜNCELLE</th>
                <th scope="col">SİL</th>
            </tr>
        </thead>
        <tbody>';

        while ($sonuc=$so->fetch_assoc()):
            echo    '<tr>
                        <td>'.$sonuc["ad"].'</td>
                        <td><a href = "ayarlar.php?islem=kategoriguncelle&katid='.$sonuc["id"].'" class="btn btn-warning"</a>Güncelle</td>
                        <td><a href = "ayarlar.php?islem=kategorisil&katid='.$sonuc["id"].'" class="btn btn-danger" data-confirm="Kategoriyi silmek istediğinize emin misiniz?"</a>Sil</td>
                    </tr>';

        endwhile;

        echo '</tbody>
		
		<tr>		
		<td colspan="5">
		<nav aria-label="Page navigation example">
		
				<ul class="pagination mx-auto">';
							
				$link="ayarlar.php?islem=kategoriyon";
				
			
					for ($s=1; $s<$this->toplamSayfamiz; $s++) :
						
						echo '<li class="page-item">
						
						<a class="page-link" href="'.$link.'&hareket='.$s.'">'.$s.'</a>					
						
						</li>';
						
						endfor;

				
				echo '</ul></nav>
		
		
		</td>
	
		</tr>
            </table>';

    }

    // Yönetici kategori silme fonksiyonu
    public function kategorisil ($vt) {
        $katid = $_GET["katid"];

        if ($katid != "" && is_numeric($katid)):
            $this->sorgum3($vt, "delete from kategoriler where id=$katid");
            $this->uyari("success", "Kategori Silindi", "ayarlar.php?islem=kategoriyon");
        else:
            $this->uyari("danger", "Hata Oluştu", "ayarlar.php?islem=kategoriyon");

        endif;
    }

    // Yönetici kategori ekleme fonksiyonu
    public function kategoriekle ($vt) {

        @$buton = $_POST["buton"];

        //echo '<div class="col-md-3 table-light text-center mx-auto mt-5 table-bordered" style="border-radius:10px;">';

        if ($buton) :
                // db işlemleri
                @$katad = htmlspecialchars($_POST["katad"]);
                @$mutfakdurum = htmlspecialchars($_POST["mutfakdurum"]);

                if ($katad == "") :
                    $this->uyari("danger", "Kategori adı boş olamaz", "ayarlar.php?islem=kategoriyon");

                else:
                    $this->sorgum3($vt, "insert into kategoriler (ad, mutfakdurum) values ('$katad', $mutfakdurum)");
                    $this->uyari("success", "Kategori Eklendi", "ayarlar.php?islem=kategoriyon");

                endif;

        else:
            ?>

            <div class="col-md-3 text-center mx-auto mt-5 table-bordered">
                    <form action = "<?php $_SERVER['PHP_SELF'];?>" method = "post">
            <?php
                    echo '<div class="col-md-12 table-light border-bottom"><h4 class = "mt-2">KATEGORİ EKLE</h4></div>
                        <div class="col-md-12 table-light"><input type = "text" name = "katad" class = "form-control mt-3" require placeholder="Kategori Adı"/></div>
                            <div class="col-md-12">
                                <select name="mutfakdurum" class="form-control mt-3">
                                    <option value="0">Mutfak Uygun</option>
                                    <option value="1">Mutfak Dışı</option>
                                </select>
                            </div>
                        <div class="col-md-12 table-light"><input name = "buton" value = "Ekle" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>

                    </form>';

        endif;

        echo '</div>';
    }

    // Yönetici kategori güncelle fonksiyonu
    public function kategoriguncelle($vt) {

        @$buton = $_POST["buton"];

        echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">';

        if ($buton) :
                // db işlemleri
                @$katad = htmlspecialchars($_POST["katad"]);
                @$katid = htmlspecialchars($_POST["katid"]);
                @$mutfakdurum = htmlspecialchars($_POST["mutfakdurum"]);

                if ($katad == "" || $katid == "") :
                    $this->uyari("danger", "Kategori adı boş olamaz", "ayarlar.php?islem=kategoriyon");

                else:
                    $this->sorgum3($vt, "update kategoriler set ad='$katad', mutfakdurum=$mutfakdurum where id = $katid");
                    $this->uyari("success", "Kategori Güncellendi", "ayarlar.php?islem=kategoriyon");

                endif;
                else:
                    $katid = $_GET["katid"];
                    $aktar = $this->sorgum3($vt, "select * from kategoriler where id = $katid")->fetch_assoc();
            ?>
                    <form action = "<?php $_SERVER['PHP_SELF']; ?>" method = "post">

            <?php

                    echo '<div class="col-md-12 table-light border-bottom"><h4>KATEGORİ GÜNCELLE</h4></div>
                            <div class="col-md-12 table-light">Kategori Adı<input type = "text" name = "katad" class = "form-control mt-3" value = "'.$aktar["ad"].'"/></div>

                                <div class="col-md-12 text-danger mt-2">
                                    <select name="mutfakdurum" class="form-control mt-3">';

                                        if($aktar["mutfakdurum"] == 0):

                                            echo '<option value="0" selected="selected">Mutfak Uygun</option>
                                                    <option value="1">Mutfak Dışı</option>';

                                            else:

                                                echo '<option value="1" selected="selected">Mutfak Dışı</option>
                                                        <option value="0">Mutfak Uygun</option>';

                                        endif;

                                   echo ' </select>
                                </div>
                                    <div class="col-md-12 table-light"><input name = "buton" value = "Güncelle" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>
                                    <input type = "hidden" name = "katid" value = "'.$katid.'"/>
                        </form>';

                endif;

        echo '</div>';

    }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function rapor($vt) {
            @$tarih = $_GET["tar"];
            switch ($tarih):

                case "bugun":
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih = CURDATE()");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih = CURDATE()");
					$veri3 = $this->sorgum3($vt, "select * from rapor where tarih = CURDATE()");
                break;

                case "dun":
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
					$veri3 = $this->sorgum3($vt, "select * from rapor where tarih = DATE_SUB(CURDATE(), INTERVAL 1 DAY)");
                break;

                case "hafta":
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
					$veri3 = $this->sorgum3($vt, "select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)");
                break;

                case "ay":
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
					$veri3 = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                break;

                case "tum":
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor");
                    $veri2 = $this->sorgum3($vt, "select * from rapor");
					$veri3 = $this->sorgum3($vt, "select * from rapor");
                break;

                case "tarih":
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $tarih1 = $_POST["tarih1"];
                    $tarih2 = $_POST["tarih2"];
                    echo '<div class = "alert alert-info text-center mx-auto mt-4">

                       Tarih Seçimi: '.$tarih1.' - '.$tarih2.'

                    </div>';
                    $veri = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
					$veri3 = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                break;

                default;
				$this->sayfalama($this->sorgum3($vt,"select * from rapor")->num_rows,5);		
$so=$this->sorgum3($vt,"select * from rapor LIMIT ".$this->limitimiz.",".$this->gosAdet."");
                    $this->sorgum3($vt, "Truncate gecicimasa");
                    $this->sorgum3($vt, "Truncate geciciurun");
					$this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)LIMIT ".$this->limitimiz.",".$this->gosAdet."");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)LIMIT ".$this->limitimiz.",".$this->gosAdet."");
					$veri3 = $this->sorgum3($vt, "select * from rapor where YEARWEEK(tarih) = YEARWEEK(CURRENT_DATE)LIMIT ".$this->limitimiz.",".$this->gosAdet."");
                break;

            endswitch;


            echo '<table class = "table text-center table-dark table-bordered mx-auto mt-4 col-md-10">

                    <thead>
                        <tr>
                            <th colspan="8">';

                            echo '

                            <th><a href="ayarlar.php?islem=rapor&tar=bugun" class="text-white">Bugün</a></th>
                            <th><a href="ayarlar.php?islem=rapor&tar=dun" class="text-white">Dün</a></th>
                            <th><a href="ayarlar.php?islem=rapor&tar=hafta" class="text-white">Bu Hafta</a></th>
                            <th><a href="ayarlar.php?islem=rapor&tar=ay" class="text-white">Bu Ay</a></th>
                            <th><a href="ayarlar.php?islem=rapor&tar=tum" class="text-white">Tüm Zamanlar</a></th></font>
                            <th colspan="2"><form action="ayarlar.php?islem=rapor&tar=tarih" method="post">
                                <input type="date" name = "tarih1" class="form-control col-md-10"><br>
                                <input type="date" name = "tarih2" class="form-control col-md-10">
                            </th>
                            <th><input name="buton" type="submit" class="btn btn-danger" value="RAPOR"></form></th>
                        </tr>
                    </thead>
					</table>
   <table class = "table text-center table-light table-bordered mx-auto mt-4 table-striped col-md-10">
                    <tbody>
                    <tr>
                        <th colspan = "4">
                            <table class="table text-center table-bordered col-md-12">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="table-dark text-white">Masa Sipariş ve Hasılat</th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="bg-warning">
                                        <th colspan="2">Ad</th>
                                        <th colspan="1">Adet</th>
                                        <th colspan="1">Hasılat</th>
                                    </tr>
                                </thead><tbody>';

                                $kilit = $this->sorgum3($vt, "select * from gecicimasa");
                                if($kilit->num_rows==0) :

                                    while ($gel = $veri->fetch_assoc()):
                                        // Raporlama için masa adını çekiyorum
                                        $id = $gel["masaid"];
                                        $masaveri = $this->sorgum3($vt, "select * from masalar where id=$id")->fetch_assoc();
                                        $masaad = $masaveri["ad"];
                                        // Raporlama için masa adını çekiyorum

                                        $raporbak = $this->sorgum3($vt, "select * from gecicimasa where masaid=$id");

                                        if ($raporbak->num_rows==0) :
                                            // gecici masaya, sipariş verilmediyse ekleme yap
                                            $has = $gel["adet"] * $gel["urunfiyat"];
                                            $adet = $gel["adet"];
                                            $this->sorgum3($vt, "insert into gecicimasa (masaid, masaad, hasilat, adet) values ($id, '$masaad', $has, $adet)");

                                        else:
                                            // yada güncelleme yap
                                            $raporson = $raporbak->fetch_assoc();
                                            $gelenadet = $raporson["adet"];
                                            $gelenhas = $raporson["hasilat"];

                                            $sonhasilat = $gelenhas + ($gel["adet"] * $gel["urunfiyat"]);
                                            $sonadet = $gelenadet + $gel["adet"];

                                            $this->sorgum3($vt, "update gecicimasa set hasilat=$sonhasilat, adet=$sonadet where masaid=$id");

                                        endif;

                                    endwhile;

                                endif;

                                $son = $this->sorgum3($vt, "select * from gecicimasa order by hasilat desc;");

                                $toplamadet = 0;
                                $toplamhasilat = 0;

                                while ($listele = $son->fetch_assoc()):
                                    echo '<tr>
                                            <td colspan="2">'.$listele["masaad"].'</td>
                                            <td colspan="1">'.$listele["adet"].'</td>
                                            <td colspan="1">₺'.number_format($listele["hasilat"],2,'.','.').'</td>
                                        </tr>';
                                        $toplamadet += $listele["adet"];
                                        $toplamhasilat += $listele["hasilat"];
                                endwhile;

                        echo '<tr class="table-success">
                                <td colspan="2">TOPLAM</td>
                                <td colspan="1">'.$toplamadet.'</td>
                                <td colspan="1">₺'. number_format($toplamhasilat,2,'.','.').'</td>
                            </tr>

                                </tbody>
                                    </table>
                                        </th>
                                            <th colspan = "4">
                                            <table class="table text-center table-bordered col-md-12">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="table-dark text-white">Ürün Sipariş ve Hasılat</th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="bg-warning">
                                        <th colspan="2">Ad</th>
                                        <th colspan="1">Adet</th>
                                        <th colspan="1">Hasılat</th>
                                    </tr>
                                </thead><tbody>';

                                $kilit2 = $this->sorgum3($vt, "select * from geciciurun");
                                if($kilit2->num_rows==0) :

                                    while ($gel2 = $veri2->fetch_assoc()):
                                        // Raporlama için ürün id ve ad çekiyorum
                                        $id = $gel2["urunid"];
                                        $urunad = $gel2["urunad"];

                                        $raporbak = $this->sorgum3($vt, "select * from geciciurun where urunid=$id");

                                        if ($raporbak->num_rows==0) :
                                            // gecici masaya, sipariş verilmediyse ekleme yap
                                            $has = $gel2["adet"] * $gel2["urunfiyat"];
                                            $adet = $gel2["adet"];
                                            $this->sorgum3($vt, "insert into geciciurun (urunid, urunad, hasilat, adet) values ($id, '$urunad', $has, $adet)");

                                        else:
                                            // yada güncelleme yap
                                            $raporson = $raporbak->fetch_assoc();
                                            $gelenadet = $raporson["adet"];
                                            $gelenhas = $raporson["hasilat"];

                                            $sonhasilat = $gelenhas + ($gel2["adet"] * $gel2["urunfiyat"]);
                                            $sonadet = $gelenadet + $gel2["adet"];

                                            $this->sorgum3($vt, "update geciciurun set hasilat=$sonhasilat, adet=$sonadet where urunid=$id");

                                        endif;

                                    endwhile;

                                endif;

                                $son2 = $this->sorgum3($vt, "select * from geciciurun order by hasilat desc;");

                                $toplamadet2 = 0;
                                $toplamhasilat2 = 0;

                                while ($listele2 = $son2->fetch_assoc()):
                                    echo '<tr>
                                            <td colspan="2">'.$listele2["urunad"].'</td>
                                            <td colspan="1">'.$listele2["adet"].'</td>
                                            <td colspan="1">₺'.number_format($listele2["hasilat"],2,'.','.').'</td>
                                        </tr>';
                                        $toplamadet2 += $listele2["adet"];
                                        $toplamhasilat2 += $listele2["hasilat"];
                                endwhile;

                        echo '<tr class="table-success">
                                <td colspan="2">TOPLAM</td>
                                <td colspan="1">'.$toplamadet2.'</td>
                                <td colspan="1">₺'.number_format($toplamhasilat2,2,'.','.').'</td>
                            </tr>

                            </tbody>
                        </table>
                    </th>
                </tr>
            </tbody>
			<tr>		
		<td colspan="5">
		<nav aria-label="Page navigation example">
		
				<ul class="pagination mx-auto">';
							
				$link="ayarlar.php?islem=rapor";
				
			
					for ($s=1; $s<$this->toplamSayfamiz; $s++) :
						
						echo '<li class="page-item">
						
						<a class="page-link" href="'.$link.'&hareket='.$s.'">'.$s.'</a>					
						
						</li>';
						
						endfor;

				
				echo '</ul></nav>
		
		
		</td>
	
		</tr>
        </table>
                    </th>
                </tr>
            </tbody>
        </table>
		';

        }
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function musteriper($vt) {

@$ara = $_POST["aramabuton"];
@$urun = $_POST["masa"];
@$urun2 = $_POST["odeme"];
@$tarih = $_GET["tar"];
            switch ($tarih):
	
			

    			

                case "ay":
                    $this->sorgum3($vt, "Truncate gecicimusteri");
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                break;
				
				case "ara":
					$this->sorgum3($vt, "Truncate gecicimusteri");
					$veri=$this->sorgum3($vt, "select * from rapor where masaad LIKE '%$urun%'");
					$veri2=$this->sorgum3($vt, "select * from rapor where musveri LIKE '%$urun%'");
				break;
				
				case "ara2":
					$this->sorgum3($vt, "Truncate gecicimusteri");
					$veri=$this->sorgum3($vt, "select * from rapor where odeme LIKE '%$urun2%'");
					$veri2=$this->sorgum3($vt, "select * from rapor where odeme LIKE '%$urun2%'");
				break;

                case "tarih":
                    $this->sorgum3($vt, "Truncate gecicimusteri");
                    $tarih1 = $_POST["tarih1"];
                    $tarih2 = $_POST["tarih2"];
                    echo '<div class = "alert alert-info text-center mx-auto mt-4">

                       Tarih Seçimi: '.$tarih1.' - '.$tarih2.'

                    </div>';
                    $veri = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                break;

                default;
				$this->sorgum3($vt,"Truncate gecicimusteri");
				$this->sayfalama($this->sorgum3($vt,"select * from rapor")->num_rows,5);		
				$so=$this->sorgum3($vt,"select * from rapor LIMIT ".$this->limitimiz.",".$this->gosAdet."");			
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) LIMIT ".$this->limitimiz.",".$this->gosAdet."");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH) LIMIT ".$this->limitimiz.",".$this->gosAdet."");
                break;
			

            endswitch;
			
			
			
		

            echo '<table class = "table text-center table-light table-bordered mx-auto mt-4 table-striped col-md-12">

                    <thead>
                        <tr>
                            <th colspan="7">';

                                if(@$tarih1!="" || @$tarih2!=""):

                                endif;


                            echo '<thead class="table-dark">
                            <tr>
                                <th><a href="ayarlar.php?islem=musteriper&tar=ay" class="text-white">Bu Ay</a></th>
<th><form action="ayarlar.php?islem=musteriper&tar=ara" method="post"><input type="search" name="masa" class="form-control" placeholder="🔍 Ara..."/></th>
<th><input type="submit" name="ara" value="ARA" class="btn btn-danger"/></form></th>
<th><form action="ayarlar.php?islem=musteriper&tar=ara2" method="post"><select name="odeme" class="form-control">';
                             
                                    echo '<option value="NAKİT">NAKİT</option>
									<option value="KREDİ">KREDİ</option>';
                                

        echo '</select></th>
                    <th><input type="submit" name="ara2" value="GETİR" class="btn btn-danger"/></form></th>
                                <form action="ayarlar.php?islem=musteriper&tar=tarih" method="post">                               
                                <th><input type="date" name = "tarih1" class="form-control col-md-10 mx-auto"><br><input type="date" name = "tarih2" class="form-control col-md-10 mx-auto"></th>

                            <th><input name="buton" type="submit" class="btn btn-danger" value="RAPOR"></form></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th colspan = "8">
                            <table class="table text-center table-bordered col-md-12">
                                <thead>
                                    <tr>
                                        <th colspan="7" class="table-dark">Müşteri Performans</th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="bg-warning">
										<th colspan="1">Masa Adı</th>
                                        <th colspan="1">Adı Soyadı</th>
										<th colspan="1">Telefon Numarası</th>
										<th colspan="1">E-mail</th>
										<th colspan="1">Ödeme Şekli</th>
                                        <th colspan="1">Adet</th>
										<th colspan="1">Hasılat</th>
                                    </tr>
                                </thead><tbody>';

                                $kilit = $this->sorgum3($vt, "select * from gecicimusteri");
                                if($kilit->num_rows==0) :
								
								if($veri2->num_rows==0):
                                    while ($gel = $veri->fetch_assoc()):
                                        // Raporlama için masa adını çekiyorum
                                        $musteriid = $gel["musteriid"];
                                        $masaveri = $this->sorgum3($vt, "select * from musteri where id=$musteriid")->fetch_assoc();
                                        $adsoyad = $masaveri["adsoyad"];
										$telefon = $masaveri["telefon"];
										$email = $masaveri["email"];
										$masaad = $gel["masaad"];
										$odeme = $gel["odeme"];
                                        // Raporlama için masa adını çekiyorum
                                    
										// gecici masaya, sipariş verilmediyse ekleme yap
										$has = $gel["adet"] * $gel["urunfiyat"];
										$adet = $gel["adet"];
										$this->sorgum3($vt, "insert into gecicimusteri (musteriid, masaad, adsoyad, telefon, email, hasilat, adet, odeme) values ($musteriid, '$masaad', '$adsoyad', $telefon, '$email', $has ,$adet, '$odeme')");

                                    endwhile;
									else:
									
									while ($gel2 = $veri2->fetch_assoc()):
                                        // Raporlama için masa adını çekiyorum
                                        $musteriid = $gel2["musteriid"];
                                        $masaveri = $this->sorgum3($vt, "select * from musteri where id=$musteriid")->fetch_assoc();
                                        $adsoyad = $masaveri["adsoyad"];
										$telefon = $masaveri["telefon"];
										$email = $masaveri["email"];
										$masaad = $gel2["masaad"];
										$odeme = $gel2["odeme"];
                                        // Raporlama için masa adını çekiyorum
                                    
										// gecici masaya, sipariş verilmediyse ekleme yap
										$has = $gel2["adet"] * $gel2["urunfiyat"];
										$adet = $gel2["adet"];
										$this->sorgum3($vt, "insert into gecicimusteri (musteriid, masaad, adsoyad, telefon, email, hasilat, adet, odeme) values ($musteriid, '$masaad', '$adsoyad', $telefon, '$email', $has ,$adet, '$odeme')");

                                    endwhile;
									
									
								

                                endif;
								endif;
								

                                $son = $this->sorgum3($vt, "select * from gecicimusteri order by adet desc;");

                                $toplamadet = 0;
								$toplamhas = 0;

                                while ($listele = $son->fetch_assoc()):
                                    echo '<tr>
											<td colspan="1">'.$listele["masaad"].'</td>
                                            <td colspan="1">'.$listele["adsoyad"].'</td>
											<td colspan="1">'.$listele["telefon"].'</td>
											<td colspan="1">'.$listele["email"].'</td>
											<td colspan="1">'.$listele["odeme"].'</td>
                                            <td colspan="1">'.$listele["adet"].'</td>
                                            <td colspan="1">₺'. number_format($listele["hasilat"],2,'.','.').'</td>
                                        </tr>';
                                        $toplamadet += $listele["adet"];
										$toplamhas += $listele["hasilat"];
                                endwhile;

                        echo '<tr class="table-success">
                                <td colspan="5">TOPLAM</td>
                                <td colspan="1">'.$toplamadet.'</td>
								<td colspan="1">₺'. number_format($toplamhas,2,'.','.').'</td>
                            </tr>

                                </tbody>
                                    </table>
                                        </th>

                            </tr>
                                </tbody>
								
								<tr>		
		<td colspan="8">
		<nav aria-label="Page navigation example">
		
				<ul class="pagination mx-auto">';
							
				$link="ayarlar.php?islem=musteriper";
				
			
					for ($s=1; $s<$this->toplamSayfamiz; $s++) :
						
						echo '<li class="page-item">
						
						<a class="page-link" href="'.$link.'&hareket='.$s.'">'.$s.'</a>					
						
						</li>';
						
						endfor;

				
				echo '</ul></nav>
		
		
		</td>
	
		</tr>
								
                                    </table>';
									
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
public function sifredegistir ($vt) {

            @$buton = $_POST["buton"];

            if ($buton) :
                    // db işlemleri
                    @$eskisifre = htmlspecialchars($_POST["eskisifre"]);
                    @$yeni1 = htmlspecialchars($_POST["yeni1"]);
                    @$yeni2 = htmlspecialchars($_POST["yeni2"]);

                    if ($eskisifre == "" || $yeni1 == "" || $yeni2 == "") :
                        $this->uyari("danger", "Bilgiler boş olamaz", "ayarlar.php?islem=sifredegistir");

                    else:
                        $eskisifreson=md5(sha1(md5($eskisifre)));

                        if($this->sorgum3($vt, "select * from yonetici where sifre = '$eskisifreson' ")->num_rows == 0) :
                            //Kayıt yoksa eski şifre hatalı
                            $this->uyari("danger", "Eski şifre hatalı", "ayarlar.php?islem=sifredegistir");

                        elseif($yeni1 != $yeni2):
                            $this->uyari("danger", "Yeni şifreler aynı değil", "ayarlar.php?islem=sifredegistir");

                        else:
                            $yenisifre=md5(sha1(md5($yeni1)));

                            $this->sorgum3($vt, "update yonetici set sifre = '$yenisifre'");
                            $this->uyari("success", "Şifre Değiştirildi", "ayarlar.php");

                        endif;

                    endif;

            else:
                ?>

                <div class="col-md-3 text-center mx-auto mt-5 table-bordered">
                        <form action = "<?php $_SERVER['PHP_SELF'] ?>" method = "post">
                <?php
                        echo '<div class="col-md-12 table-light border-bottom"><h4>ŞİFRE DEĞİŞTİR</h4></div>
                            <div class="col-md-12 table-light"><input type = "text" name = "eskisifre" class = "form-control mt-3" require placeholder="Eski Şifreniz"/></div>
                            <div class="col-md-12 table-light"><input type = "text" name = "yeni1" class = "form-control mt-3" require placeholder="Yeni Şifreniz"/></div>
                            <div class="col-md-12 table-light"><input type = "text" name = "yeni2" class = "form-control mt-3" require placeholder="Yeni Şifreniz Tekrar"/></div>
                            <div class="col-md-12 table-light"><input name = "buton" value = "Değiştir" type = "submit" class = "btn btn-success mt-3 mb-3"/></div>

                        </form>
                    </div>';

            endif;
        }

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function garsonyon ($vt) {
		$this->sayfalama($this->sorgum3($vt,"select * from garson")->num_rows,5);		
$so=$this->sorgum3($vt,"select * from garson LIMIT ".$this->limitimiz.",".$this->gosAdet."");
		echo'<table class="table text-center table-striped table-bordered mx-auto col-md-6 mt-4" >
	<thead>
	<tr>
	<th scope"col"><a href="ayarlar.php?islem=garsonekle" class="btn btn-success">+</a> Garson Adı</th>
	<th scope"col">Güncelle</th>
	<th scope"col">Sil</th>
	</tr>
	</thead>
	<tbody>';
		while ($sonuc=$so->fetch_assoc()):
		echo '
	<tr>
	<td>'.$sonuc["ad"].'</td>
	<td><a href="ayarlar.php?islem=garsonguncel&garsonid='.$sonuc["id"].'" class="btn btn-warning">Güncelle</a></td>
	<td><a href="ayarlar.php?islem=garsonsil&garsonid='.$sonuc["id"].'" class="btn btn-danger">Sil</a></td>
	</tr>';
		endwhile;
		echo'</tbody>
		
		<tr>		
		<td colspan="5">
		<nav aria-label="Page navigation example">
		
				<ul class="pagination mx-auto">';
							
				$link="ayarlar.php?islem=garsonyon";
				
			
					for ($s=1; $s<$this->toplamSayfamiz; $s++) :
						
						echo '<li class="page-item">
						
						<a class="page-link" href="'.$link.'&hareket='.$s.'">'.$s.'</a>					
						
						</li>';
						
						endfor;

				
				echo '</ul></nav>
		
		
		</td>
	
		</tr>
	</table>';
	}
	function garsonsil($vt) {
		$garsonid=$_GET["garsonid"];
				if($garsonid!==""&& is_numeric($garsonid)) :
					$this->sorgum3($vt,"delete from garson where id=$garsonid");
					@$this->uyari("success","Garson Silindi","ayarlar.php?islem=garsonyon");
					else:
					@$this->uyari("danger","hata oluştu","ayarlar.php?islem=garsonyon");
				endif;
		}

		function garsonekle($vt) {
			@$buton=$_POST["buton"];
			echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">';
			if($buton):
					@$garsonad=htmlspecialchars($_POST["garsonad"]);
					@$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);

					if($garsonad=="" || $garsonsifre=="") :
						$this->uyari("danger","bilgiler boş olamaz","ayarlar.php?islem=garsonyon");
					else:
						$this->sorgum3($vt,"insert into garson (ad,sifre) VALUES ('$garsonad','$garsonsifre')");
						$this->uyari("success","Garson Eklendi","ayarlar.php?islem=garsonyon");
					endif;

			else:
		?>

		<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
			<?php
			echo'
		<div class="col-md-12 table-light border-bottom"><h4>Garson Ekle</h4></div>
		<div class="col-md-12 table-light">Garson Adı<input type="text" name="garsonad" class="form-control mt-3" require /></div>
		<div class="col-md-12 table-light">Şifresi<input type="text" name="garsonsifre" class="form-control mt-3" require /></div>
		<div class="col-md-12 table-light"><input name="buton" type="submit" class="btn btn-success mt-3 mb-3" /></div>
		</form>
		';
		endif;
		echo'</div>';
		}

		function garsonguncel($vt) {
			@$buton=$_POST["buton"];
			echo '<div class="col-md-3 text-center mx-auto mt-5 table-bordered">';
			if($buton):
					@$garsonad=htmlspecialchars($_POST["garsonad"]);
					@$garsonsifre=htmlspecialchars($_POST["garsonsifre"]);
					@$garsonid=htmlspecialchars($_POST["garsonid"]);

					if($garsonad=="" || $garsonsifre=="") :
						$this->uyari("danger","bilgiler boş olamaz","ayarlar.php?islem=garsonyon");
					else:
						$this->sorgum3($vt,"update garson set ad='$garsonad', sifre='$garsonsifre' where id=$garsonid");
						$this->uyari("success","garson Güncellendi","ayarlar.php?islem=garsonyon");
					endif;

			else:

			$garsonid=$_GET["garsonid"];
			$aktar=$this->sorgum3($vt,"select * from garson where id=$garsonid")->fetch_assoc();

		?>
	  <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
			<?php
			echo'
	  <div class="col-md-12 table-light border-bottom"><h4>GARSON GÜNCELLE</h4></div>
	  <div class="col-md-12 table-light">garson adı<input type="text" name="garsonad" class="form-control mt-3" value="'.$aktar["ad"].'"/></div>
	  <div class="col-md-12 table-light">garson şifresi<input type="text" name="garsonsifre" class="form-control mt-3" value="'.$aktar["sifre"].'"/></div>
		<div class="col-md-12 table-light"><input name="buton" value="Güncelle" type="submit" class="btn btn-success mt-3 mb-3"/></div>
	  <input type="hidden" name="garsonid" value="'.$garsonid.'" />
	  </form>
	  ';
	  endif;
		echo'</div>';

		}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

public function garsonper($vt) {

            @$tarih = $_GET["tar"];
            switch ($tarih):

                case "ay":
                    $this->sorgum3($vt, "Truncate gecicigarson");
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                break;

                case "tarih":
                    $this->sorgum3($vt, "Truncate gecicigarson");
                    $tarih1 = $_POST["tarih1"];
                    $tarih2 = $_POST["tarih2"];
                    echo '<div class = "alert alert-info text-center mx-auto mt-4">

                       Tarih Seçimi: '.$tarih1.' - '.$tarih2.'

                    </div>';
                    $veri = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where DATE(tarih) BETWEEN '$tarih1' AND '$tarih2'");
                break;

                default;
                    $this->sorgum3($vt, "Truncate gecicigarson");
                    $veri = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                    $veri2 = $this->sorgum3($vt, "select * from rapor where tarih >= DATE_SUB(CURDATE(), INTERVAL 1 MONTH)");
                break;

            endswitch;

            echo '<table class = "table text-center table-light table-bordered mx-auto mt-4 table-striped col-md-10">

                    <thead>
                        <tr>
                            <th colspan="4">';

                                if(@$tarih1!="" || @$tarih2!=""):

                                endif;


                            echo '<thead class="table-dark">
                            <tr>
                                <th><a href="ayarlar.php?islem=garsonper&tar=ay" class="text-white">Bu Ay</a></th>
                                <form action="ayarlar.php?islem=garsonper&tar=tarih" method="post">
                                <th><input type="date" name = "tarih1" class="form-control col-md-10"></th>
                                <th><input type="date" name = "tarih2" class="form-control col-md-10"></th>

                            <th><input name="buton" type="submit" class="btn btn-danger" value="RAPOR"></form></th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th colspan = "4">
                            <table class="table text-center table-bordered col-md-12">
                                <thead>
                                    <tr>
                                        <th colspan="6" class="table-dark">Garson Performans</th>
                                    </tr>
                                </thead>
                                <thead>
                                    <tr class="bg-warning">
                                        <th colspan="2">Garson Ad</th>
                                        <th colspan="2">Adet</th>
										<th colspan="2">Hasılat</th>
                                    </tr>
                                </thead><tbody>';

                                $kilit = $this->sorgum3($vt, "select * from gecicigarson");
                                if($kilit->num_rows==0) :

                                    while ($gel = $veri->fetch_assoc()):
                                        // Raporlama için masa adını çekiyorum
                                        $garsonid = $gel["garsonid"];
                                        $masaveri = $this->sorgum3($vt, "select * from garson where id=$garsonid")->fetch_assoc();
                                        $garsonad = $masaveri["ad"];
                                        // Raporlama için masa adını çekiyorum

                                        $raporbak = $this->sorgum3($vt, "select * from gecicigarson where garsonid=$garsonid");

                                        if ($raporbak->num_rows==0) :
                                            // gecici masaya, sipariş verilmediyse ekleme yap
											$has = $gel["adet"] * $gel["urunfiyat"];
                                            $adet = $gel["adet"];
                                            $this->sorgum3($vt, "insert into gecicigarson (garsonid, garsonad, adet, hasilat) values ($garsonid, '$garsonad', $adet ,$has)");

                                        else:
                                            // yada güncelleme yap
                                            $raporson = $raporbak->fetch_assoc();
                                            $gelenadet = $raporson["adet"];
											$gelenhasilat = $raporson["hasilat"];

											$sonhasilat = $gelenhasilat + ($gel["adet"] * $gel["urunfiyat"]);



                                            $sonadet = $gelenadet + $gel["adet"];

                                            $this->sorgum3($vt, "update gecicigarson set hasilat=$sonhasilat, adet=$sonadet where garsonid=$garsonid");

                                        endif;

                                    endwhile;

                                endif;

                                $son = $this->sorgum3($vt, "select * from gecicigarson order by adet desc;");

                                $toplamadet = 0;
								$toplamhas = 0;

                                while ($listele = $son->fetch_assoc()):
                                    echo '<tr>
                                            <td colspan="2">'.$listele["garsonad"].'</td>
                                            <td colspan="2">'.$listele["adet"].'</td>
                                            <td colspan="2">₺'. number_format($listele["hasilat"],2,'.','.').'</td>
                                        </tr>';
                                        $toplamadet += $listele["adet"];
										$toplamhas += $listele["hasilat"];
                                endwhile;

                        echo '<tr class="table-success">
                                <td colspan="2">TOPLAM</td>
                                <td colspan="2">'.$toplamadet.'</td>
								<td colspan="2">₺'. number_format($toplamhas,2,'.','.').'</td>
                            </tr>

                                </tbody>
                                    </table>
                                        </th>

                            </tr>
                                </tbody>
                                    </table>';

        }




}

ob_flush();
?>
