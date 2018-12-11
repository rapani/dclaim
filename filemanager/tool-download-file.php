<?php
include_once dirname(__FILE__)."/functions.php";
include_once dirname(__FILE__)."/auth.php";
include dirname(__FILE__)."/conf.php";
$filepath = rawurldecode(path_decode($_GET['filepath'], $cfg->rootdir));
$ft = getMIMEType($filepath);
$mime = $ft->mime;
header('Content-type: '.$mime);
header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
readfile($filepath);
?>