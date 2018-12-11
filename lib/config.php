<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "eclaim";
$con = mysqli_connect ("$host","$user","$pass","$db");
if (!$con){ mysqli_connect_error_no($con);}


// conversi tgl dari database
function tgl_indo ($date){
$db = explode("-", $date);
return $db[2]."-".$db[1]."-".$db[0];
}

// tahun 2018-12-01
function tahun ($date){
    $db = explode("-", $date);
    return $db[0];
    }

function bulan ($date){
        $db = explode("-", $date);
        return $db[1];
        }

function hari ($date){
    $db = explode("-", $date);
    return $db[2];
    }


function tgl_db($tanggal){
        $pecahkan = explode('-', $tanggal);
        return $pecahkan[2] . '-' .$pecahkan[1]. '-' . $pecahkan[0];   
}


// $dirranap = 'D:\DATA-CLAIM\RAJAL-'.substr($tgl, -4).'\/'.$tgl.'\/'.$sep;
// $pathranap = 'D:\DATA-CLAIM\RANAP -'.substr($tgl, -4).'\/'.$tgl.'\/'.$sep;

?>
