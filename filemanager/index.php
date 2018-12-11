<?php
include_once dirname(__FILE__)."/functions.php";
include dirname(__FILE__)."/conf.php";
if(!isset($_SESSION['userid']) && $cfg->authentification_needed)
{
include_once dirname(__FILE__)."/tool-login-form.php";
exit();
}
include dirname(__FILE__)."/conf.php";
$dir = trim(stripslashes(@$_GET['dir']),"/");
if(!is_dir(path_decode($dir, $cfg->rootdir))){
$dir = '';	
}
if(!$dir) $dir =  'base';
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>DIGITAL CLAIM YARSI BUKITTINGGI</title>
<link rel="shortcut icon" href="style/images/favicon.ico" />
<link rel="stylesheet" type="text/css" href="style/file-type.css" />
<link rel="stylesheet" type="text/css" href="style/style.css" />
<link rel="stylesheet" href="script/jquery/pw/jquery.ui.core.css">
<link rel="stylesheet" href="script/jquery/pw/jquery.ui.theme.css">
<link rel="stylesheet" href="script/jquery/pw/jquery.ui.resizable.css" />
<link rel="stylesheet" href="script/jquery/pw/jquery.ui.positioning.css" />
<link rel="stylesheet" href="script/jquery/pw/jquery.ui.dialog.css">
<script language="javascript" src="script/script.js"></script>
<script language="javascript" src="script/jquery/jquery.min.js"></script>
<script language="javascript" src="script/jquery/jquery-ui-1.8.21.custom.min.js"></script>
<script language="javascript" src="script/overlay-dialog.js"></script>
<script language="javascript">
window.onload = function(){
initContextMenuFile();
initContextMenuDir();
initContextMenuFileArea();
setCheckRelation();
setSize();
initDropable();
$(window).resize(function(){setSize();});
loadAnimationStop();
}
function selectFileIndex(url){
	// TODO: Add your code here
	// propertyFile(url2path(url));
	// Remember that this function is called by clicking file, so you must skip on drag and drop
	window.open(url);
}
function url2path(url)
{
	var rooturl = '<?php echo $cfg->rooturl;?>';
	var path = url;
	if(rooturl.length>1)
	{
		path = path.substr(rooturl.length+1);
	}
	return 'base/'+path;
}
</script>
<body>
<div id="all">
<div id="wrapper">
<div class="toolbar">
<div id="anim-loader" class="anim-active"></div>
  <ul>
    <li><a href="javascript:createFile()" title="Create New File"><img src="style/images/newfile.gif" alt="New" /></a></li>
    <li><a href="javascript:createDirectory()" title="Create New Directory"><img src="style/images/newfolder.gif" alt="New" /></a></li>
    <li><a href="javascript:uploadFile()" title="Upload File"><img src="style/images/upload.gif" alt="Upload" /></a></li>
    <li><a href="javascript:goToUpDir()" title="Go to One Up Level Directory"><img src="style/images/up.gif" alt="Up" /></a></li>
    <li><a href="javascript:refreshList()" title="Reload"><img src="style/images/refresh.gif" alt="Reload" /></a></li>
    <li><a href="javascript:selectAll(1)" title="Check All"><img src="style/images/check.gif" alt="Check" /></a></li>
    <li><a href="javascript:selectAll(0)" title="Uncheck All"><img src="style/images/uncheck.gif" alt="Uncheck" /></a></li>
    <li><a href="javascript:copySelectedFile()" title="Copy Selected File"><img src="style/images/copy.gif" alt="Copy" /></a></li>
    <li><a href="javascript:cutSelectedFile()" title="Cut Selected File"><img src="style/images/cut.gif" alt="Cut" /></a></li>
    <li><a href="javascript:moveSelectedFile()" title="Move Selected File"><img src="style/images/move.gif" alt="Move" /></a></li>
    <li><a href="javascript:pasteFile()" title="Paste File"><img src="style/images/paste.gif" alt="Paste" /></a></li>
    <li><a href="javascript:renameFile()" title="Rename First Selected File"><img src="style/images/rename.gif" alt="Rename" /></a></li>
    <li><a href="javascript:deleteSelectedFile()" title="Delete Selected File"><img src="style/images/delete.gif" alt="Delete" /></a></li>
    <li><a href="javascript:compressSelectedFile()" title="Compress Selected File"><img src="style/images/compress.gif" alt="Compress" /></a></li>
    <li><a href="javascript:extractFile()" title="Extract First Selected File"><img src="style/images/extract.gif" alt="Extract" /></a></li>
    <li id="tb-thumbnail"><a href="javascript:thumbnail()"><img src="style/images/view.gif" alt="" title="Change View Type" /></a></li>
    
    <li id="tb-clipboard" class="tb-hide"><a href="javascript:showClipboard()"><img src="style/images/clipboard.gif" alt="Clipboard" title="Show Clipboard" /></a></li>
    <li id="tb-clipboard-empty" class="tb-hide"><a href="javascript:emptyClipboard()"><img src="style/images/cleanup.gif" alt="Empty Clipboard" title="Empty Clipboard" /></a></li>
    <?php
	if($cfg->authentification_needed)
	{
	?>
    <li><a href="logout.php"><img src="style/images/logout.gif" alt="Logout" title="Logout"></a></li>
    <?php
	}
	?>
  </ul>
</div>

<div class="addressbar">
<form name="dirform" method="get" enctype="multipart/form-data" action="" onSubmit="return openDir()">
<input type="text" class="input-text address" name="address" id="address" value="<?php echo $dir;?>" autocomplete="off" /> <input type="submit" name="opendir" id="opendir" class="com-button" value="Open" />
</form>
</div>

<div class="middle">
	<div class="directory-area">
    	<div id="directory-container">
            <ul>
            <li class="basedir dir-control" data-file-name="base" data-file-location="">
            <a href="javascript:;" onClick="return openDir('base')">base</a>
			  <?php 
              include_once dirname(__FILE__)."/tool-load-dir.php";
              ?>
            </li>
            </ul>
    	</div>
    </div>
    
    <div class="file-area">
    	<div id="file-container">
    	  <?php 
		  include_once dirname(__FILE__)."/tool-load-file.php";
		  ?>
    	</div>
    </div>
    
</div>
</div>
</div>

<div style="display:none">
<div id="common-dialog" title="">
<div id="common-dialog-inner">
</div>
</div>
</div>
<div id="overlay-container" style="display:none"></div>
</body>
</html>