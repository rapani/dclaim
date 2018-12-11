
<?php
include "./lib/config.php";
include "./PHPExcel.php";
if (isset($_POST['rajal'])){
     $random = "file_upload_".rand(11111,99999);
     $target_file = $random.basename($_FILES["file_excel"]["name"]);
     $uploadOk = 1;

     if (move_uploaded_file($_FILES["file_excel"]["tmp_name"], $target_file)) {

         ini_set('memory_limit', '-1');
         $objReader = PHPExcel_IOFactory::createReader('Excel2007');

         $inputFileType = 'Excel2007';
         $sheetIndex = 0;
         $inputFileName = $target_file;

         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
         $sheetnames = $objReader->listWorksheetNames($inputFileName);
         $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);

         try {
         $objPHPExcel = $objReader->load($inputFileName);
         } catch(Exception $e) {
         die('Error loading file :' . $e->getMessage());
         }

         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
         $numRows = count($worksheet);
         $cek = $worksheet[2]['D'];
         if ($cek !=="RJ") { echo "<script> alert('MAAF INI BUKAN FILE RAJAL'); document.location.href = './index.php?page=import'; </script>";  die; exit; }

         //baca untuk setiap baris excel Rawat Jalan
         for ($i=2; $i <= $numRows ; $i++) {
             $nosep = $worksheet[$i]['B'];
             $tanggal = $worksheet[$i]['C'];
             $no_kar = $worksheet[$i]['E'];
             $mr = $worksheet[$i]['F'];
             $nama = $worksheet[$i]['G'];
             $poli = $worksheet[$i]['I'];
             $nama = addslashes(strtoupper($nama));

           $sql = "INSERT INTO rjtl (tgl_sep,no_sep,no_kar,no_mr,nama_pasien,poli) VALUES ('$tanggal','$nosep','$no_kar','$mr','$nama','$poli')";
             if (mysqli_query($con, $sql)) {
                 $pesan= "Sukses Simpan Data!";
             } else {
                 $pesan= "Error: " . $sql . "<br>" . mysqli_error($con);
             }

         }

          unlink($target_file);

          $pesan ='<div class="alert alert-primary" role="alert"><h4>Import Data SEP Rawat Jalan Berhasil</h4></div>';
      } else {
          $pesan ='<div class="alert alert-primary" role="alert"><h4> Pilih File Excel terlebih dahulu </h4></div>';
      }
}

if (isset($_POST['ranap'])){
     $random = "file_upload_".rand(11111,99999);
     $target_file = $random.basename($_FILES["file_excel"]["name"]);
     $uploadOk = 1;

     if (move_uploaded_file($_FILES["file_excel"]["tmp_name"], $target_file)) {

         ini_set('memory_limit', '-1');
         $objReader = PHPExcel_IOFactory::createReader('Excel2007');

         $inputFileType = 'Excel2007';
         $sheetIndex = 0;
         $inputFileName = $target_file;

         $objReader = PHPExcel_IOFactory::createReader($inputFileType);
         $sheetnames = $objReader->listWorksheetNames($inputFileName);
         $objReader->setLoadSheetsOnly($sheetnames[$sheetIndex]);

         try {
         $objPHPExcel = $objReader->load($inputFileName);
         } catch(Exception $e) {
         die('Error loading file :' . $e->getMessage());
         }

         $worksheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
         $numRows = count($worksheet);

         $cek = $worksheet[2]['D'];
         if ($cek !=="RI") { echo "<script> alert('MAAF INI BUKAN FILE RANAP'); document.location.href = './index.php?page=import'; </script>";  die; exit; }

         //baca untuk setiap baris excel rawat inap
         for ($i=2; $i <= $numRows ; $i++) {
           $nosep = $worksheet[$i]['B'];
           $tanggal = $worksheet[$i]['C'];
           $no_kar = $worksheet[$i]['E'];
           $mr = $worksheet[$i]['F'];
           $nama = $worksheet[$i]['G'];
           $nama = addslashes(strtoupper($nama));
           $sql = "INSERT INTO ritl (tgl_sep,no_sep,no_kar,no_mr,nama_pasien) VALUES ('$tanggal','$nosep','$no_kar','$mr','$nama')";
             if (mysqli_query($con, $sql)) {
                 $pesan= "Sukses Simpan Data!";
             } else {
                 $pesan= "Error: " . $sql . "<br>" . mysqli_error($con);
             }

         }
          unlink($target_file);

         $pesan2 ='<div class="alert alert-primary" role="alert"><h4>Import Data SEP Rawat Inap Berhasil</h4></div>';
     } else {
         $pesan2 ='<div class="alert alert-primary" role="alert"><h4> Pilih File Excel terlebih dahulu </h4></div>';
     }
}

 ?>

    <!-- Begin page content -->





    <main role="main" class="container">
<br>
<br>

<div class="alert alert-danger" role="alert"> File Excel yang di Import adalah hasil laporan resmi dari VClaim  BPJS Kesehatan, Bukan dari SIMRS atau yang lain !</div>
<hr>

<div class="card">
  <h5 class="card-header">IMPORT DATA SEP RAWAT JALAN</h5>
  <div class="card-body">



<?php if (isset($pesan)) { echo $pesan; } ?>

<form class="form-inline" method="POST" action="" id="import_excel" name="import_excel" enctype="multipart/form-data">
  <div class="form-group mx-sm-3 mb-2">

  </div>
  <div class="form-group mx-sm-3 mb-2">
    <input type="file" name="file_excel" class="form-control">
  </div>
  	<button type="submit" name="rajal" class="btn btn-primary" id="btn_submit">Import</button>
</form>
</div>
</div>

</div>









<hr>
<div class="card">
  <h5 class="card-header">IMPORT DATA SEP RAWAT INAP</h5>
  <div class="card-body">

<?php if (isset($pesan2)) { echo $pesan2; } ?>
<form class="form-inline" method="POST" action="" id="import_excel" name="import_excel" enctype="multipart/form-data">
<div class="form-group mx-sm-3 mb-2">

</div>
  <div class="form-group mx-sm-3 mb-2">

    <input type="file" name="file_excel" class="form-control">
  </div>
  	<button type="submit" name="ranap" class="btn btn-primary" id="btn_submit">Import</button>
</form>
</div>
</div>

</div>

    </main>
