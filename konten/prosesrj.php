<?php

if ($_FILES['camscan']['error'] == 0 || $_FILES['lip']['error'] == 0 || $_FILES['billing']['error'] == 0 || $_FILES['lain']['error'] == 0) {

include "../lib/config.php";
  $id = $_POST['id'];
  $sep = $_POST['nomorsep'];
  $tgl = $_POST['tanggal_sep'];

// upload file dokumen
$dirranap = 'D:\UPLOAD\RAJAL\/'.tahun($tgl).'\/'.bulan($tgl).'\/'.hari($tgl).'\/';

       if ($_FILES['camscan']['error'] == 0) {
        $name = "$sep-CAMSCAN.pdf";
        if((file_exists($dirranap))) {
        $cam = move_uploaded_file($_FILES["camscan"]["tmp_name"], "$dirranap/$name");
        }
        else { mkdir($dirranap, 0777, true);
        $cam = move_uploaded_file($_FILES["camscan"]["tmp_name"], "$dirranap/$name");
        }
        if ($cam) { mysqli_query($con,"UPDATE rjtl SET pdf_camscan=1 WHERE id='$id'");}
        }

        if ($_FILES['lip']['error'] == 0) {
        if((file_exists($dirranap))) {
        $lip = move_uploaded_file($_FILES["lip"]["tmp_name"], "$dirranap/$sep-LIP.pdf");
        }
        else
        { mkdir($dirranap, 0777, true);
        $lip = move_uploaded_file($_FILES["lip"]["tmp_name"], "$dirranap/$sep-LIP.pdf");
        }
        if ($lip) { mysqli_query($con,"UPDATE rjtl SET pdf_individual=1 WHERE id='$id'");}
        }

        if ($_FILES['billing']['error'] == 0) {
        if((file_exists($dirranap))) {
        $bil = move_uploaded_file($_FILES["billing"]["tmp_name"], "$dirranap/$sep-BILLING.pdf");
        }
        else
        { mkdir($dirranap, 0777, true);
        $bil = move_uploaded_file($_FILES["billing"]["tmp_name"], "$dirranap/$sep-BILLING.pdf");
        }
        if ($bil) { mysqli_query($con,"UPDATE rjtl SET pdf_billing=1 WHERE id='$id'");}
        }

        if ($_FILES['lain']['error'] == 0) {
        if((file_exists($dirranap))) {
        $lain = move_uploaded_file($_FILES["lain"]["tmp_name"], "$dirranap/$sep-LAINNYA.pdf");
        }
        else
        { mkdir($dirranap, 0777, true);
        $lain = move_uploaded_file($_FILES["lain"]["tmp_name"], "$dirranap/$sep-LAINNYA.pdf");
        }  
        if ($lain) { mysqli_query($con,"UPDATE rjtl SET pdf_lainnya=1 WHERE id='$id'");}
      }

        if ($cam || $bil || $lip || $lain) { echo "<script> alert('file berhasil diupload'); document.location.href = '../index.php?page=rjtl'; </script>"; exit; } 
} else {  echo "<script> alert('Tidak ada file yang di Upload'); document.location.href = '../index.php?page=rjtl'; </script>"; exit;}
