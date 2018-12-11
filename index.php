
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="assets/favicon.ico">

    <title>DIGITAL CLAIM BPJS KESEHATAN</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/datepicker.css" rel="stylesheet">
    <link href="assets/daterangepicker.css" rel="stylesheet">
    <link href="assets/bootstrap.min.css" rel="stylesheet">
    <link href="assets/sticky-footer-navbar.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="datatables/datatables/media/css/jquery.dataTables.min.css"/>
  </head>

  <body>

    <header>
      <!-- Fixed navbar -->
      <nav class="navbar navbar-expand-md navbar navbar-dark fixed-top bg-dark">
        <a class="navbar-brand" href="#">DIGITAL CLAIM</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
          <ul class="navbar-nav mr-auto">

            <li class="nav-item <?php if ($_GET['page']=="rjtl"){echo "active";} ?>">
              <a class="nav-link" href="index.php?page=rjtl"><b> RAWAT JALAN </b> </a>
            </li>
            <li class="nav-item <?php if ($_GET['page']=="ritl"){echo "active";} ?>">
              <a class="nav-link" href="index.php?page=ritl"><b>RAWAT INAP</b></a>
            </li>


            <li class="nav-item <?php if ($_GET['page']=="import"){echo "active";} ?>">
              <a class="nav-link" href="index.php?page=import"><b>IMPORT SEP</b></a>
            </li>

            <li class="nav-item <?php if ($_GET['page']=="combine"){echo "active";} ?>">
              <a class="nav-link" href="index.php?page=combine"><b>COMBINE</b></a>
            </li>


            <li class="nav-item">
              <a class="nav-link" href="filemanager" target="_blank"><b>FILE MANAGER</b></a>
            </li>


            <li class="nav-item dropdown <?php if ($_GET['page']=="bilrajal" || $_GET['page']=="liprajal" || $_GET['page']=="camrajal"){echo "active";} ?>">
            <a class="nav-link dropdown-toggle"  id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><b>UPLOAD</b></a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
            <hr>
              <a class="dropdown-item" href="index.php?page=bilrajal">BILLING RAJAL</a>
              <hr>
              <a class="dropdown-item" href="index.php?page=liprajal">LIP RAWAT JALAN</a>
              <hr>
              <a class="dropdown-item" href="index.php?page=camrajal">CAMSCAN RAWAT JALAN</a>
              <hr>
              <a class="dropdown-item" href="">BILLING RANAP</a>
              <hr>
              <a class="dropdown-item" href="">LIP RANAP</a>
              <hr>
              <a class="dropdown-item" href="">CAMSCAN RAWAT INAP</a>
              <hr>
            </div>
          </li>



          </ul>
        </div>
      </nav>
    </header>

    <!-- Begin page content -->


      <?php
	if(isset($_GET['page'])){
		$page = $_GET['page'];

		switch ($page) {
                    case 'home':
                    include "konten/home.php";
                    break;
                    case 'import':
                    include "konten/import.php";
                    break;
                    case 'rjtl':
                    include "konten/rjtl.php";
                    break;
                    case 'bilrajal':
                    include "konten/upbilrajal.php";
                    break;
                    case 'liprajal':
                    include "konten/upliprajal.php";
                    break;
                    case 'camrajal':
                    include "konten/upcamrajal.php";
                    break;

                    case 'ritl':
                    include "konten/ritl.php";
                    break;
                    case 'urajal':
                    include "konten/updaterajal.php";
                    break;
                    case 'uranap':
                    include "konten/updateranap.php";
                    break;
                    case 'combine':
                    include "konten/combine.php";
                    break;

                    default:
                    include "konten/rjtl.php";
                    break;
                    }
	} else {
    include "konten/rjtl.php";
  }

	 ?>
