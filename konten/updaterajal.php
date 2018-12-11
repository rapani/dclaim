<?php
include "./lib/config.php";

$id = $_GET['id'];
$sql = "SELECT * FROM rjtl WHERE id='$id'";
$data = mysqli_query($con,$sql);
$row = mysqli_fetch_assoc($data);
 ?>

<main role="main" class="container-fluid">
<br>
<br>
<br>

<div class="card">
  <h5 class="card-header">UPLOAD DOCUMENT DIGITAL CLAIM RAWAT JALAN : <?php echo $row['no_sep']; ?></h5>
  <div class="card-body">


<form action="konten/prosesrj.php" method="post" enctype="multipart/form-data">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
    <input type="hidden" name="nomorsep" value="<?php echo $row['no_sep']; ?>">
    <input type="hidden" name="tanggal_sep" value="<?php echo $row['tgl_sep']; ?>">

  <div class="form-row">

    <div class="form-group col-md-6">
      <label for="inputPassword4">NOMOR KARTU BPJS</label>
      <input type="text" class="form-control" id="nokar" value="<?php echo $row['no_kar']; ?>" disabled>
    </div>

    <div class="form-group col-md-6">
      <label for="inputEmail4">NAMA PASIEN</label>
      <input type="text" class="form-control" id="nama" value="<?php echo $row['nama_pasien']; ?>" disabled>
    </div>

  </div>
<div class="form-row">
  <div class="form-group col-md-6">
    <label for="inputEmail4">NOMOR SEP (SURAT ELIGIBILITAS PESERTA)</label>
    <input type="text" class="form-control" id="sep" name="sep" value="<?php echo $row['no_sep']; ?>" disabled>
  </div>
  <div class="form-group col-md-3">
    <label for="inputPassword4">TANGGAL SEP</label>
    <input type="text" class="form-control" name="tglsep" value="<?php echo tgl_indo($row['tgl_sep']); ?>" disabled>
  </div>

  <div class="form-group col-md-3">
    <label for="inputPassword4">POLIKLINIK</label>
    <input type="text" class="form-control" id="poli" value="<?php echo $row['poli']; ?>" disabled>
  </div>




</div>


<div class="form-group">
  <label for="cam"><b>DOCUMENT PDF CAMSCAN </b>: </label>
  <input type="file" id="cam" class="btn btn-outline-success form-control-file" name="camscan" accept="application/pdf">
</div>

<div class="form-group">
  <label for="lip"><b>DOCUMENT PDF LEMBAR INDIVIDUAL PASIEN (LIP) </b></label>
  <input type="file" class="btn btn-outline-success form-control-file" id="lip" name="lip"" accept="application/pdf">
</div>

<div class="form-group">
  <label for="bil"><b>DOCUMENT PDF BILLING </b></label>
  <input type="file" class="btn btn-outline-success form-control-file" id="bil" name="billing"  accept="application/pdf">
</div>

<div class="form-group">
  <label for="lain"><b>DOCUMENT PDF LAINNYA </b></label>
  <input type="file" class="btn btn-outline-success form-control-file" id="lain" name="lain"  accept="application/pdf">
</div>



  <button type="submit" name="simpan" class="btn btn-primary">UPLOAD</button>
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



