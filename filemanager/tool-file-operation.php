<?php
include_once dirname(__FILE__)."/functions.php";
include_once dirname(__FILE__)."/auth.php";
include dirname(__FILE__)."/conf.php";
if($cfg->readonly){
	die('READONLY');
}


$rooturl = $cfg->rootdir;
if(@$_GET['option']=='createdir')
{
$dir2 = path_decode(@$_POST['location'], $cfg->rootdir);
$name = stripslashes(@$_POST['name']);
$name = trim(str_replace(array("../","./","..\\",".\\","\\"),"/",$name),"/\\");
if(file_exists($dir2))
{
	if(!file_exists($dir2."/".$name)){
		if(mkdir($dir2."/".$name))
		{
			echo 'SUCCESS';
		}
		else
		{
			echo 'FAILED';
		}
	}
	else
	{
		echo 'EXIST';
	}
}
}
if(@$_GET['option']=='createfile')
{
$dir2 = path_decode(@$_POST['location'], $cfg->rootdir);
$name = stripslashes(@$_POST['name']);
$name = trim(str_replace(array("../","./","..\\",".\\","\\"),"/",$name),"/\\");
if(file_exists($dir2))
{
	if(!file_exists($dir2."/".$name)){
		$fp = fopen($dir2."/".$name, "w");
		if($fp)
		{
			fclose($fp);
			echo 'SUCCESS';
		}
		else
		{
			echo 'FAILED';
		}
	}
	else
	{
		echo 'EXIST';
	}
}
deleteforbidden($dir2);
}

if(@$_GET['option']=='copyfile')
{
	
parse_str(@$_POST['postdata'], $_POST);
if(isset($_POST) && (@get_magic_quotes_gpc() || @get_magic_quotes_runtime()))
{
	array_walk_recursive($_POST, 'array_stripslashes');
	/*
	foreach($_POST as $k=>$val)
	{
		if(!is_array($val)) $_POST[$k] = my_stripslashes($val);
	}
	*/
}

$targetdir = path_decode(@$_POST['targetdir'], $cfg->rootdir);

// prepare dir
$dir = str_replace("\\","/",$targetdir);
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


$files = @$_POST['file'];
$filemoved = array();
$dirmoved = array();
if(is_array($files))
{
	foreach($files as $k=>$file)
	{
		$source = path_decode($file, $cfg->rootdir);
		if(file_exists($source))
		{
			if(is_dir($source))
			{
				if($source != $targetdir."/".basename($source))
				{
					cp($source, $targetdir."/".basename($source));
					$dirmoved[] = $source;
				}
			}
			else
			{
				if($source != $targetdir."/".basename($source))
				{
					copy($source, $targetdir."/".basename($source));
					$filemoved[] = $source;
				}
			}
		}
	}
	echo 'SUCCESS';
}
else{
echo 'FAILED';
}
if(isset($_GET['deletesource']))
{
	foreach($dirmoved as $k=>$path)
	{
		destroyall($path);
	}
	foreach($filemoved as $k=>$path)
	{
		@unlink($path);
	}
}
deleteforbidden($targetdir, true);
}

if(@$_GET['option']=='deletefile')
{
parse_str(@$_POST['postdata'], $_POST);
if(isset($_POST) && (@get_magic_quotes_gpc() || @get_magic_quotes_runtime()))
{
	array_walk_recursive($_POST, 'array_stripslashes');
	/*
	foreach($_POST as $k=>$val)
	{
		if(!is_array($val)) $_POST[$k] = my_stripslashes($val);
	}
	*/
}
$files = @$_POST['file'];
if(is_array($files))
{
	foreach($files as $k=>$file)
	{
		$source = path_decode($file, $cfg->rootdir);
		if(is_dir($source))
		{
			destroyall($source);
		}
		else
		{
			@unlink($source);
		}
	}
	echo 'SUCCESS';
}
else{
echo 'FAILED';
}
}

if(@$_GET['option']=='renamefile')
{
$location = path_decode(@$_POST['location'], $cfg->rootdir);
$oldname = $location."/".trim(str_replace(array("../","./","..\\",".\\","\\"),"/",stripslashes(@$_POST['oldname'])),"/\\");
$newname = $location."/".trim(str_replace(array("../","./","..\\",".\\","\\"),"/",stripslashes(@$_POST['newname'])),"/\\");
if(file_exists($newname))
{
	echo 'EXIST';
}
else
{
if(rename($oldname, $newname))
	echo 'SUCCESS';
else
	echo 'FAILED';
}
deleteforbidden(dirname($newname));
}

if(@$_GET['option']=='extractfile')
{
$targetdir = path_decode($_POST['targetdir'], $cfg->rootdir);
$filepath = path_decode($_POST['filepath'], $cfg->rootdir);

if(file_exists($filepath))
{
	$zip = new ZipArchive;
	if ($zip->open($filepath) === TRUE) 
	{
		$zip->extractTo($targetdir.'/');
		$zip->close();
		deleteforbidden($targetdir, true);
		echo 'SUCCESS';
	}
	else
	{
		echo 'FAILED';
	}
}
}


if(@$_GET['option']=='compressfile')
{
if(isset($_POST['postdata']))
{
	parse_str(@$_POST['postdata'], $_POST);
	if(isset($_POST) && (@get_magic_quotes_gpc() || @get_magic_quotes_runtime()))
	{
		array_walk_recursive($_POST, 'array_stripslashes');
		/*
		foreach($_POST as $k=>$val)
		{
			if(!is_array($val)) $_POST[$k] = my_stripslashes($val);
		}
		*/
	}
}
$target = path_decode(@$_POST['targetpath'], $cfg->rootdir);

// prepare dir
$dir = dirname($target);
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



$file2compress = @$_POST['sourcepath'];
if(is_array($file2compress))
{
for($i=0;$i<count($file2compress);$i++){
$file2compress[$i] = path_decode($file2compress[$i], $cfg->rootdir);

if($file2compress[$i] == $target)
{
echo 'CONFLICK';
exit();
}

$arr2 = explode("/",$file2compress[$i]);
$nslashes=count($arr2);
if(count($arr2)<$nslashes||$nslashes==0){
$dir2remove=dirname($file2compress[$i]);
}
else
{
$dir2remove = dirname($file2compress[0]);
}


if(file_exists($file2compress[$i]))
{
	$file_list .= $file2compress[$i]."\r\n";
		if(filetype($file2compress[$i])=='dir')
		{
			dir_list($file2compress[$i]);
		}
	}
}

$file_list = trim($file_list,"\r\n");
$arrfile = explode("\r\n",$file_list);

if(count($arrfile) && !empty($target))
{
$zip = new ZipArchive;
$res = $zip->open($target, ZipArchive::CREATE);
if($res === TRUE) 
{
	foreach($arrfile as $entry)
	{
		$localname = trim(substr($entry, strlen($dir2remove)),"/");
		if(is_dir($entry))
		{
			$zip->addEmptyDir($localname);
		}
		else
		{
			$zip->addFile($entry, $localname);
		}
	} 
	$zip->close();
	echo 'SUCCESS';
	exit();
}
else 
{
	echo 'FAILED';
	exit();
}
}
}
}


?>