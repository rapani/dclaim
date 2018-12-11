<?php
include_once dirname(__FILE__)."/functions.php";
include dirname(__FILE__)."/conf.php";
if(!isset($_SESSION['userid']) && $cfg->authentification_needed) exit();
?>