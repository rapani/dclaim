<?php
include_once dirname(__FILE__)."/functions.php";
include_once dirname(__FILE__)."/auth.php";
include dirname(__FILE__)."/conf.php";
if(@$_GET['option']=='openfile')
{
$filepath = path_decode($_GET['filepath'], $cfg->rootdir);
if(file_exists($filepath))
{
$cnt = file_get_contents($filepath);
?>
<form id="filetexteditor" name="filetexteditor" method="post" action="">
<div class="filename-area"><input type="text" class="input-text" name="filepath" id="filepath" value="<?php echo path_encode($filepath, $cfg->rootdir);?>" autocomplete="off" />
  <input type="button" name="open" id="open" value="Open" class="com-button" onclick="editFile($('#filepath').val())" />
</div>
<div class="fileeditor">
<textarea name="filecontent" id="filecontent" cols="80" rows="10" spellcheck="false"><?php echo htmlspecialchars($cnt);?></textarea>
</div>
</form>
<?php
}
}
if(@$_GET['option']=='savefile')
{
	if($cfg->readonly){
		die('READONLY');
	}
	
	$filepath = path_decode($_POST['filepath']);
	
	// prepare dir
	$dir = dirname($filepath);
	$dir = str_replace("\\","/",$dir);
	$arr = explode("/", $dir);
	if(is_array($arr))
	{
		$d2c = "";
		foreach($arr as $k=>$v)
		{
			$d2c .= $v;
			if(strlen($d2c)>=strlen($cfg->rootdir))
			{
				if(!file_exists($d2c))
				{
					mkdir($d2c);
				}
			}
			$d2c .= "/";
		}
	}
	
	
	$content = $_POST['filecontent'];
	if(get_magic_quotes_gpc()){
		$content = str_replace(array("\\\"", "\\'"), array("\"", "'"), $content); // replace \" to " and \' to '
		$content = str_replace(array("\\\\"), array("\\"), $content); // replace \\ to \
	}
	$content = str_replace(array("\n"), array("\r\n"), $content);
	$fp = fopen($filepath, "w");
	fwrite($fp, $content);
	fclose($fp);
	echo 'SAVED';
}
?>