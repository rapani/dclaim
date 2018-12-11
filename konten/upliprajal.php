<?php
include "./lib/config.php";


 // upload file dokumen
if (isset($_POST['simpan'])) {
   // Loop $_FILES to exeicute all files
   foreach ($_FILES['files']['name'] as $f => $name) {
    $replace = array(" ", ".pdf");
    $name = str_replace($replace, '', $name);
    
    // $bulan = trim(substr($name,8,2));
    // $tahun = trim(substr($name,10,2));
    //$tahun = "20".$tahun;

       if ($_FILES['files']['error'][$f] == 4) {
           continue; // Skip file if any error found
       }
       if ($_FILES['files']['error'][$f] == 0) {

        // periksa nomor SEP
        $q = mysqli_query($con, "SELECT tgl_sep FROM rjtl WHERE no_sep='$name'");
        if (mysqli_num_rows($q) == 0 )
        { $pesan = '<div class="alert alert-danger" role="alert">
          <h4> SEP tidak ditemukan di database, Silahkan Import SEP terlebih dahulu..! </h4>
        </div>'; continue; }

        $result = mysqli_fetch_assoc($q);
        $tahun = tahun($result['tgl_sep']);
        $bulan =  bulan ($result['tgl_sep']);
        $tgl = hari ($result['tgl_sep']);

        $dir = 'D:\UPLOAD\RAJAL\/'.$tahun.'\/'.$bulan.'\/'.$tgl.'\/';


        if((file_exists($dir))) {
        $up = move_uploaded_file($_FILES["files"]["tmp_name"][$f], "$dir/$name-LIP.pdf");
        } else {
        mkdir($dir, null, true);
        $up = move_uploaded_file($_FILES["files"]["tmp_name"][$f], "$dir/$name-LIP.pdf");
        }
        $input = mysqli_query($con, "UPDATE rjtl SET pdf_individual=1 WHERE no_sep='$name'");
  }
}
 if ($up){ $pesan = '<div class="alert alert-primary" role="alert">
  <h3> Terima Kasih :) Document LIP Berhasil di Upload </h3>
</div>';}
}

  ?>

<main role="main" class="container-fluid">
<br>
<br>
<br>
<br>

<div class="card">
  <h3 class="card-header">UPLOAD LEMBAR INDIVIDUAL PASIEN (LIP) RAWAT JALAN</h3>
  <div class="card-body">

<?php if (isset($pesan)) echo $pesan; ?>
 <form method="POST" enctype="multipart/form-data" autocomplete="off">
   <div class="form-group row">
     <label for="inputPassword" class="col-sm-2 col-form-label"><b> PDF LIP </b> </label>
     <div class="col-sm-6">
       <input type="file" class="form-control-file btn btn-outline-success" id="file" name="files[]" multiple="multiple" accept="application/pdf">
     </div>
     </div>
   </div>
   <button type="submit" name="simpan" class="btn btn-primary">UPLOAD DOCUMENT</button>
 </form>


  </div>
  </div>
  </main>



  <footer class="footer">
    <div class="container">
      <span class="text-muted">Digital Claim RSI Ibnu Sina Bukittinggi - Version 1.0</span>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="./assets/jquery-3.3.1.js"></script>

  <script src="./assets/popper.min.js"></script>
  <script src="./assets/bootstrap.min.js"></script>
  </body>
  </html>

<!--
<script src="./assets/bootstrap-datepicker.js"></script>
  // datepicker
// $('#tgl').datepicker({format: "dd-mm-yyyy",autoclose: true});
-->
