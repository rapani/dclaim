<?php
$tgl ="06-09-2018";
$tglsep = trim(substr($tgl,3,2));
$tahunsep = trim(substr($tgl,8,2));
$kode = "0304R005";
$file = "395";
$file = sprintf("%06d", $file);
$name =  $kode.$tglsep.$tahunsep.'V'.$file;
echo $name;
