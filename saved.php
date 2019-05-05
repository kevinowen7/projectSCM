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

<?php
	include 'connectionSQL.php';
	

  //list
  $Id=array();
	$namaKategoriOn=array();
	$jumlahKategoriOn=array();
	$fixedCostOn=array();
	$varCostOn=array();
	$demandOn=array();
	$hasilOn=array();
	
	$sql = "SELECT * FROM `databaseBEP`";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
      array_push($Id,$row['Id']);
			array_push($namaKategoriOn,$row['NamaKategori']);
			array_push($jumlahKategoriOn,$row['JumlahKategori']);
			array_push($fixedCostOn,$row['FixedCost']);
			array_push($varCostOn,$row['VarCost']);
			array_push($demandOn,$row['Demand']);
			array_push($hasilOn,$row['Hasil']);
		}
  }
  

  $url = $_SERVER['REQUEST_URI'];
		$currentpage = explode("?delete=",$url);
		$len  = count($currentpage);
		if($len==2){
			//delete from SQL
			$sqlDel = "DELETE FROM `databasebep` WHERE Id='".$currentpage[1]."'";
			$result = $conn->query($sqlDel);
			echo "<script> window.location = 'saved.php' </script>";
		} else{
			echo '';
		}
		
	$conn->close();

?>
<script type="text/javascript">
  var Id = <?php echo json_encode($Id); ?>;
	var namaKategoriOn = <?php echo json_encode($namaKategoriOn); ?>;
	var jumlahKategoriOn = <?php echo json_encode($jumlahKategoriOn); ?>;
	var fixedCostOn = <?php echo json_encode($fixedCostOn); ?>;
	var varCostOn = <?php echo json_encode($varCostOn); ?>;
	var demandOn = <?php echo json_encode($demandOn); ?>;
	var hasilOn = <?php echo json_encode($hasilOn); ?>;
</script>

<body>
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
				<span class="profile-text"><a href="saved.php" style="color:white">Saved Data</a></span>
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
        <div class="content-wrapper">
		  <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Saved Data</h4>
                  <div class="table-responsive">
						<table id="tableSaved" class="table table-striped">
						  <thead>
							<tr>
                <th>
								Id Kategori
							  </th>
							  <th>
								Nama Kategori
							  </th>
							  <th>
								Fixed Cost
							  </th>
							  <th>
								Variable Cost
							  </th>
							  <th>
								Hasil
							  </th>
							  <th>
								Demand
							  </th>
							  <th>
								Action
							  </th>
							</tr>
						  </thead>
						  <tbody>
						  </tbody>
						</table>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial -->
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
        </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- Modal -->
  <div id="modalConfirm" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Delete Saved Data</h4>
					</div>
					<div class="modal-body">
						<p id="modalDesc"></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default btn-sm" data-dismiss="modal" aria-hidden="true">Cancel</button>
						<button id="confirmYes" type="button" class="btn btn-danger btn-sm" data-dismiss="modal" aria-hidden="true">Delete</button>
					</div>
				</div>
			</div>
		</div>


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
  <script src="js/saved.js"></script>
  <!-- End custom js for this page-->
</body>

</html>