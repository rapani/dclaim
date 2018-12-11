<?php 
include "./lib/config.php";
?>


<main role="main" class="container-fluid">
<br>
<br>
<br>
<br>

<div class="card">
  <h3 class="card-header">COMBINE FILE RAWAT JALAN</h3>
  <div class="card-body">

 <form method="POST" autocomplete="off">
   <div class="form-group row">
     <label for="inputPassword" class="col-sm-2 col-form-label"><b>TANGGAL SEP </b> </label>
     <div class="col-sm-6">
       <input type="text" class="form-control" id="filterdata" name="tgl" required>
     </div>
     </div>
   </div>
   <button type="submit" name="combinerajal" class="btn btn-primary">COMBINE DOCUMENT PDF RAJAL</button>
 </form>
  </div>
  </div>

<hr> 

<div class="card">
  <h3 class="card-header">COMBINE FILE RAWAT INAP</h3>
  <div class="card-body">

 <form method="POST" autocomplete="off">
   <div class="form-group row">
     <label for="inputPassword" class="col-sm-2 col-form-label"><b>TANGGAL PULANG </b> </label>
     <div class="col-sm-6">
       <input type="text" class="form-control" id="filterdata2" name="tgl" required>
     </div>
     </div>
   </div>
   <button type="submit" name="combineranap" class="btn btn-primary">COMBINE DOCUMENT PDF RANAP</button>
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
  <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
  <script src="./assets/popper.min.js"></script>
  <script src="./assets/bootstrap.min.js"></script>

<script>

$(function() {
$('#filterdata').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });
  $('#filterdata').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
  });
  $('#filterdata').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  $('#filterdata2').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });
  $('#filterdata2').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
  });
  $('#filterdata2').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });



});

</script>
  </body>
  </html>

<?php 
if (isset($_POST['combinerajal'])) {

$tgl = $_POST['tgl'];
$a = tgl_db(substr($tgl,0,10));
$b = tgl_db(substr($tgl,13,23));
$q = mysqli_query($con, "SELECT * FROM rjtl WHERE pdf_camscan=1 AND pdf_individual=1 AND pdf_billing=1 AND tgl_sep BETWEEN '$a' AND '$b'");

$sumber = "/data/UPLOAD/RAJAL";
$hasil = "/data/COMBINE/RAJAL";

while ($row = mysqli_fetch_assoc($q)) {
  $nosep =  $row['no_sep'];
  $tglsep = $row['tgl_sep'];
  $tahun = tahun($tglsep);
  $bulan = bulan($tglsep);
  $hari = hari($tglsep);
  
  $cam = $sumber.'/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$nosep.'-CAMSCAN.pdf';
  if ($row['pdf_lainnya']==1) { 
  $lain = $sumber.'/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$nosep.'-LAINNYA.pdf';
  }
  $lip = $sumber.'/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$nosep.'-LIP.pdf';
  $bil = $sumber.'/'.$tahun.'/'.$bulan.'/'.$hari.'/'.$nosep.'-BILLING.pdf';

  // output hasil combine
  $dirresult = $hasil.'/'.$tahun.'/'.$bulan.'/'.$hari;
  if((!file_exists($dirresult))) { mkdir($dirresult, 0777, true); }  
  $fileout = "$dirresult/$nosep.pdf";

  if ($row['pdf_lainnya']==1) {
    $pdf = "pdftk ". $cam ." ". $lain ." ".$lip. " ". $bil ." cat output ". $fileout;
  } else {  
   $pdf = "pdftk ". $cam ." ".$lip. " ". $bil ." cat output ". $fileout;
}
  $generatepdf = shell_exec($pdf);
  mysqli_query($con, "UPDATE rjtl SET pdf_combine=1 WHERE no_sep='$nosep'");
}
 
echo "<script> alert('Data Berhasil di Generate'); </script>"; 

}

// combine file ranap 
if (isset($_POST['combineranap'])) {
  
  $tgl = $_POST['tgl'];
  $a = tgl_db(substr($tgl,0,10));
  $b = tgl_db(substr($tgl,13,23));
  $q = mysqli_query($con, "SELECT * FROM ritl WHERE pdf_camscan=1 AND pdf_individual=1 AND pdf_billing=1 AND tgl_pulang BETWEEN '$a' AND '$b'");
  
  $sumber = "/data/UPLOAD/RANAP";
  $hasil = "/data/COMBINE/RANAP";
  
  while ($row = mysqli_fetch_assoc($q)) {
    $nosep =  $row['no_sep'];
    $tpulang = $row['tgl_pulang'];
    $tahun = tahun($tpulang);
    $bulan = bulan($tpulang);
    $hari = hari($tpulang);
    
    $cam = $sumber.'/'.$tahun.'/'.$bulan.'/'.$nosep.'-CAMSCAN.pdf';
    if ($row['pdf_lainnya']==1) { 
    $lain = $sumber.'/'.$tahun.'/'.$bulan.'/'.$nosep.'-LAINNYA.pdf';
    }
    $lip = $sumber.'/'.$tahun.'/'.$bulan.'/'.$nosep.'-LIP.pdf';
    $bil = $sumber.'/'.$tahun.'/'.$bulan.'/'.$nosep.'-BILLING.pdf';
  
    // output hasil combine
    $dirresult = $hasil.'/'.$tahun.'/'.$bulan;
    if((!file_exists($dirresult))) { mkdir($dirresult, 0777, true); }  
    $fileout = "$dirresult/$nosep.pdf";
  
    if ($row['pdf_lainnya']==1) {
      $pdf = "pdftk ". $cam ." ". $lain ." ".$lip. " ". $bil ." cat output ". $fileout;
    } else {  
     $pdf = "pdftk ". $cam ." ".$lip. " ". $bil ." cat output ". $fileout;
  }
    $generatepdf = shell_exec($pdf);
    mysqli_query($con, "UPDATE ritl SET pdf_combine=1 WHERE no_sep='$nosep'");
  }
   
  echo "<script> alert('Data Berhasil di Generate'); </script>"; 
  
  }


?>