<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Make Or Buy Analysis - SCM</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
  <link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
    <link rel="stylesheet" href="vendors/iconfonts/font-awesome/css/font-awesome.css">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="images/favicon.png" />
</head>
<?php
	include 'connectionSQL.php';
?>

<body>
	<div class="jumbotron text-center" style="background-image:url('images/background3.jpg')">
	  <h1>Make Or Buy Analysis</h1>
	  
	</div>
	
	<div class="container">
	  <div class="row">
		<h6 style="text-align:center;margin: auto;font-family:Times New Roman">Make or Buy Analysis adalah keputusan yang melibatkan apakah akan membuat produk sendiri atau membelinya dari pihak lain. Hasil analisis ini harus berupa keputusan yang memaksimalkan hasil keuangan jangka panjang bagi perusahaan.
		<br></br>
		<span style="font-family:Times New Roman"; >Aplikasi ini digunakan untuk menghitung biaya total dari kategori-kategori yang diinput. Kategori tersebut adalah opsi strategi yang memuat biaya tetap dan biaya variabel. Aplikasi ini akan menampilkan grafik total cost terhadap jumlah produksi. Aplikasi ini juga menampilkan kategori mana yang memberikan total biaya termurah pada range jumlah produksi/permintaan. Maka user dapat melihat kategori apa yang sebaiknya dipilih.</span></h6>
	  </div>
	  <br></br>
	  <div class="row">
		<div class="col-sm-3">
		  <h4 style="text-align:center;margin: auto;">Adelia Debrina (1616006)</h4>
		  <p style="text-align:center;margin: auto;">Be Light In The Dark</p>
		   <br></br>
		  <img style="display: block;margin-left: auto;margin-right: auto;" src="images/adel.jpg" alt="logo" height="150px" weight="150px"/>
		</div>
		<div class="col-sm-3">
		  <h4 style="text-align:center;margin: auto;">Tabita Parley (1616023)</h4>
		  <p style="text-align:center;margin: auto;"> Standing In The Hall Of Fame</p>
		   <br></br>
		 <img style="display: block;margin-left: auto;margin-right: auto;" src="images/tab.jpg" alt="logo" height="150px" weight="150px"/>
		</div>
		<div class="col-sm-3">
		  <h4 style="text-align:center;margin: auto;">Febe Gracela (1616038)</h4>        
		  <p style="text-align:center;margin: auto;">You Are Your Best Thing</p>
		   <br></br>
		  <img style="display: block;margin-left: auto;margin-right: auto;" src="images/feb.jpg" alt="logo" height="150px" weight="150px"/>
		</div>
		<div class="col-sm-3">
		  <h4 style="text-align:center;margin: auto;">Christian Renata (1616043)</h4>        
		  <p style="text-align:center;margin: auto;">To The Stars</p>
		   <br></br>
		  <img style="display: block;margin-left: auto;margin-right: auto;" src="images/cr.jpg" alt="logo" height="150px" weight="150px"/>
		</div>
	  </div>
	  <br></br>
	  <div class="row">
		<button style="margin-left:500px" class="btn btn-success mr-2" onClick="window.location='input.php'" >Start Now!</button>
	  </div>
	</div>
  <!-- container-scroller -->


  <!-- jQuery -->
  <script src="js/jquery.js"></script>
  <!-- plugins:js -->
  <script src="vendors/js/vendor.bundle.base.js"></script>
  <script src="vendors/js/vendor.bundle.addons.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <!-- End plugin js for this page-->
  <!-- endinject -->
  <!-- End custom js for this page-->
</body>

</html>