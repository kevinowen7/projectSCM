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
	
	$id=0;
	
	$sql = "SELECT * FROM `databaseBEP` order by Id DESC";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$id = $row['Id'];
			break;
		}
	}
	
?>
<style>
.loader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  margin-left: auto;
  margin-right: auto;
}

/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>


<body >
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a  href="input.php">
		<!-- insert logo -->
          <img src="images/make-or-buy.png" alt="logo" height="70px" weight="70px"/>
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">

        </ul>
        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item dropdown d-none d-xl-inline-block">
			<!-- keterangan nama tab-->
				<span class="profile-text"><a href="input.php" style="color:white">Home</a></span>
          </li>
        </ul>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
		  
           <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="menu-icon mdi mdi-home"></i>
              <span class="menu-title">Home</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="input.php">
              <i class="menu-icon mdi mdi-television"></i>
              <span class="menu-title">Input Data</span>
            </a>
          </li>
		  <li class="nav-item">
            <a class="nav-link" href="saved.php">
              <i class="menu-icon mdi mdi-content-copy"></i>
              <span class="menu-title">Saved Data</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div id="mainPanel" class="main-panel" style="display: none;">
        <div class="content-wrapper" style="background-image: url('images/background3.jpg');">
		  <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="card">
				<div class="card-body">
				  <h4 class="text-primary">Input Kategori</h4>
				  </br>
				  </br>
				  <form id="input" class="forms-sample">
					<div class="form-group row">
					  <label for="demand" class="col-sm-3 col-form-label">Demand</label>
					  <div class="col-sm-3">
						<input type="number" min="1" class="form-control" id="demand" name="demand" placeholder="Enter Demand">
					  </div>
					</div>
					<div class="form-group row">
					  <label for="jumlahKategori" class="col-sm-3 col-form-label">Jumlah Kategori</label>
					  <div class="col-sm-3">
						<input id="jumlahKategori" type="number" name="jumlahKategori" min="1" class="form-control" placeholder="Jumlah Kategori">
					  </div>
					</div>
					</br>
					</br>

          <!-- kategori -->
          <div id="tKategori" style="display: none;">
          
            <h4 class="text-primary">Kategori</h4>
            <div id="kategoriList" name="kategoriList">
            </div>
          </div>
          <!-- end kategori -->
          
          <button id="calculateD" name='calculateD' type="submit" class="btn btn-success mr-2">Calculate</button>
          </form>     
        </div>
        </div>
      </div>
      </div>
      <div id="set" class="row">
      </div>
      <!-- end loading -->
      <div id="hasil" style="display: none;">
        <div class="row">
        <div class="col-md-12 grid-margin">
          <div class="card">
          <div class="card-body">
            <!-- grafik -->
            <div class="stretch-card">
              <div class="card">
              <div id='remakeChart' class="card-body">
                <h4 class="text-primary">Result</h4>
                <!-- loading -->
                <div id="loader" class="loader" style="display: none;"></div>
                <canvas id="scatterChart" style="height:250px"></canvas>
              </div>
              </div>
            </div>
             <!-- menghasilkan result -->
        <div id="resultRecomend" class="row">

        </div>
            <!-- end grafix -->
          </div>
          </div>
        </div>
        </div>

      <form class="forms-sample" action='input.php' method='post'>
        <div style="display: none;">
          <input id="jumlahKategoriS" type="number" name="jumlahKategoriS" min="2" class="form-control">
          <input id="demandS" type="text" name="demandS"  class="form-control">
          <input id="varCostS" type="text" name="varCostS"  class="form-control">  
          <input id="fixCostS" type="text" name="fixCostS" class="form-control">  
          <input id="nameKategoriS" type="text" name="nameKategoriS"  class="form-control">
          <input id="hasilS" type="text" name="hasilS"  class="form-control">
        </div>
        <div id="save" class="grid-margin stretch-card" style="display: none;">
        <button id="savedata" name='savedata' type="submit" class="btn btn-primary mr-2">Save Data</button>
        </div>
      </form>
      <?php
      if(isset($_POST['savedata'])) {
        $sqlPush = "INSERT INTO `databaseBEP` (`NamaKategori`,`JumlahKategori`, `FixedCost`, `VarCost`, `Hasil`,`Demand`,`Id`) VALUES ('".$_POST['nameKategoriS']."','".$_POST['jumlahKategoriS']."','".$_POST['fixCostS']."', '".$_POST['varCostS']."', '".$_POST['hasilS']."', '".$_POST['demandS']."', ".($id+1).")";
        $result = $conn->query($sqlPush);
        $conn->close();
        echo "<script> window.location = 'saved.php' </script>";
      }
    ?>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
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
  <!-- to solve algebra question -->
  <script src="js/algebra.js"></script>
  <!-- Custom js for this page-->
  <script src="js/input.js"></script>
  <!-- End custom js for this page-->
</body>

</html>