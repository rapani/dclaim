<?php
@session_start();
function cleanforbiddenall($dir)
{
@chmod(dirname($dir), 0777);
@chmod($dir, 0777);
cleanforbidden($dir);
@chmod(dirname($dir), 0755);
}
function cleanforbidden($dir)
{
global $cfg;
$dir = rtrim($dir,"/");
$mydir = opendir($dir);
while(false !== ($file = readdir($mydir))){
	if($file != "." && $file != ".."){
	@chmod($dir."/".$file, 0777);
	if(is_dir($dir."/".$file)){
		chdir('.');
		cleanforbidden($dir."/".$file);
	}
	else{
		$fn = $dir."/".$file;
		$tt = getMIMEType($fn);
		if(in_array($tt->extension, $cfg->forbidden_extension)){
			@unlink($fn);
		}
	}
	}
}
closedir($mydir);
}

function destroyall($dir)
{
@chmod(dirname($dir), 0777);
@chmod($dir, 0777);
destroy($dir);
@rmdir($dir);
@chmod(dirname($dir), 0755);
}
function destroy($dir)
{
	$dir = rtrim($dir,"/");
	$mydir = opendir($dir);
	while(false !== ($file = readdir($mydir))) 
	{
		if($file != "." && $file != "..") 
		{
			@chmod($dir."/".$file, 0777);
			if(is_dir($dir."/".$file)) 
			{
				chdir('.');
				destroy($dir."/".$file);
				rmdir($dir."/".$file) or DIE("couldn't delete $dir$/file<br />");
			}
			else
			@unlink($dir."/".$file) or DIE("couldn't delete $dir$/file<br />");
		}
	}
	closedir($mydir);
}

// copy all files and folders in directory to specified directory
function cp($wf, $wto)
{ 
	if (!file_exists($wto))
	{
		@mkdir($wto,0755);
	}
	$arr=ls_a($wf);
	foreach ($arr as $fn)
	{
		if($fn)
		{
			$fl="$wf/$fn";
			$flto="$wto/$fn";
			if(is_dir($fl)) 
				cp($fl,$flto);
			else 
				@copy($fl,$flto);
		}
	}
}

function ls_a($wh)
{
	$files = "";
	if($handle=opendir($wh)) 
	{
		while (false!== ($file = readdir($handle))) 
		{
			if ($file!= "." && $file!= ".." ) 
			{
				if(empty($files)) 
					$files="$file";
				else 
					$files="$file\n$files";
			}
		}
		closedir($handle);
	}
	$arr=explode("\n",$files);
	return $arr;
}

function getMIMEType($filename){
$obj = new StdClass();
$arr = array(
'323'=>'text/h323',
'3gp'=>'video/3gp',
'ogg'=>'video/ogg',
'mp4'=>'video/mp4',
'ram'=>'audio/ram',
'wma'=>'audio/wma',
'*'=>'application/octet-stream',
'acx'=>'application/internet-property-stream',
'ai'=>'application/postscript',
'aif'=>'audio/x-aiff',
'aifc'=>'audio/x-aiff',
'aiff'=>'audio/x-aiff',
'asf'=>'video/x-ms-asf',
'asr'=>'video/x-ms-asf',
'asx'=>'video/x-ms-asf',
'au'=>'audio/basic',
'avi'=>'video/x-msvideo',
'axs'=>'application/olescript',
'bas'=>'text/plain',
'bcpio'=>'application/x-bcpio',
'bin'=>'application/octet-stream',
'bmp'=>'image/bmp',
'c'=>'text/plain',
'cat'=>'application/vnd.ms-pkiseccat',
'cdf'=>'application/x-cdf',
'cdf'=>'application/x-netcdf',
'cer'=>'application/x-x509-ca-cert',
'class'=>'application/octet-stream',
'clp'=>'application/x-msclip',
'cmx'=>'image/x-cmx',
'cod'=>'image/cis-cod',
'conf'=>'text/conf',
'ini'=>'text/ini',
'cpio'=>'application/x-cpio',
'crd'=>'application/x-mscardfile',
'crl'=>'application/pkix-crl',
'crt'=>'application/x-x509-ca-cert',
'csh'=>'application/x-csh',
'css'=>'text/css',
'dcr'=>'application/x-director',
'der'=>'application/x-x509-ca-cert',
'dir'=>'application/x-director',
'dll'=>'application/x-msdownload',
'dms'=>'application/octet-stream',
'doc'=>'application/msword',
'docx'=>'application/msword',
'dot'=>'application/msword',
'dvi'=>'application/x-dvi',
'dxr'=>'application/x-director',
'eps'=>'application/postscript',
'etx'=>'text/x-setext',
'evy'=>'application/envoy',
'exe'=>'application/octet-stream',
'fif'=>'application/fractals',
'flr'=>'x-world/x-vrml',
'flv'=>'video/flv',
'gif'=>'image/gif',
'gtar'=>'application/x-gtar',
'gz'=>'application/x-gzip',
'h'=>'text/plain',
'hdf'=>'application/x-hdf',
'hlp'=>'application/winhlp',
'hqx'=>'application/mac-binhex40',
'hta'=>'application/hta',
'htc'=>'text/x-component',
'htm'=>'text/html',
'html'=>'text/html',
'htt'=>'text/webviewhtml',
'ico'=>'image/x-icon',
'ief'=>'image/ief',
'iii'=>'application/x-iphone',
'ins'=>'application/x-internet-signup',
'isp'=>'application/x-internet-signup',
'jfif'=>'image/pipeg',
'jpe'=>'image/jpeg',
'jpeg'=>'image/jpeg',
'jpg'=>'image/jpeg',
'js'=>'application/x-javascript',
'latex'=>'application/x-latex',
'lha'=>'application/octet-stream',
'lsf'=>'video/x-la-asf',
'lsx'=>'video/x-la-asf',
'lzh'=>'application/octet-stream',
'm13'=>'application/x-msmediaview',
'm14'=>'application/x-msmediaview',
'm3u'=>'audio/x-mpegurl',
'man'=>'application/x-troff-man',
'mdb'=>'application/x-msaccess',
'me'=>'application/x-troff-me',
'mht'=>'message/rfc822',
'mhtml'=>'message/rfc822',
'mid'=>'audio/mid',
'mny'=>'application/x-msmoney',
'mov'=>'video/quicktime',
'movie'=>'video/x-sgi-movie',
'mp2'=>'video/mpeg',
'mp3'=>'audio/mpeg',
'mpa'=>'video/mpeg',
'mpe'=>'video/mpeg',
'mpeg'=>'video/mpeg',
'mpg'=>'video/mpeg',
'wmv'=>'video/wmv',
'mpp'=>'application/vnd.ms-project',
'mpv2'=>'video/mpeg',
'mkv'=>'video/mkv',
'ms'=>'application/x-troff-ms',
'msg'=>'application/vnd.ms-outlook',
'mvb'=>'application/x-msmediaview',
'nc'=>'application/x-netcdf',
'nws'=>'message/rfc822',
'oda'=>'application/oda',
'p10'=>'application/pkcs10',
'p12'=>'application/x-pkcs12',
'p7b'=>'application/x-pkcs7-certificates',
'p7c'=>'application/x-pkcs7-mime',
'p7m'=>'application/x-pkcs7-mime',
'p7r'=>'application/x-pkcs7-certreqresp',
'p7s'=>'application/x-pkcs7-signature',
'pbm'=>'image/x-portable-bitmap',
'pdf'=>'application/pdf',
'pfx'=>'application/x-pkcs12',
'pgm'=>'image/x-portable-graymap',
'php'=>'application/x-httpd-php',
'pko'=>'application/ynd.ms-pkipko',
'pma'=>'application/x-perfmon',
'pmc'=>'application/x-perfmon',
'pml'=>'application/x-perfmon',
'pmr'=>'application/x-perfmon',
'pmw'=>'application/x-perfmon',
'png'=>'image/png',
'pnm'=>'image/x-portable-anymap',
'pot'=>'application/vnd.ms-powerpoint',
'ppm'=>'image/x-portable-pixmap',
'pps'=>'application/vnd.ms-powerpoint',
'ppt'=>'application/vnd.ms-powerpoint',
'pptx'=>'application/vnd.ms-powerpoint',
'prf'=>'application/pics-rules',
'ps'=>'application/postscript',
'pub'=>'application/x-mspublisher',
'qt'=>'video/quicktime',
'ra'=>'audio/x-pn-realaudio',
'ram'=>'audio/x-pn-realaudio',
'ras'=>'image/x-cmu-raster',
'rgb'=>'image/x-rgb',
'rmi'=>'audio/mid',
'roff'=>'application/x-troff',
'rtf'=>'application/rtf',
'rtx'=>'text/richtext',
'scd'=>'application/x-msschedule',
'sct'=>'text/scriptlet',
'setpay'=>'application/set-payment-initiation',
'setreg'=>'application/set-registration-initiation',
'sh'=>'application/x-sh',
'shar'=>'application/x-shar',
'sit'=>'application/x-stuffit',
'snd'=>'audio/basic',
'spc'=>'application/x-pkcs7-certificates',
'spl'=>'application/futuresplash',
'src'=>'application/x-wais-source',
'sst'=>'application/vnd.ms-pkicertstore',
'stl'=>'application/vnd.ms-pkistl',
'stm'=>'text/html',
'sv4cpio'=>'application/x-sv4cpio',
'sv4crc'=>'application/x-sv4crc',
'svg'=>'text/svg+xml',
'swf'=>'application/x-shockwave-flash',
't'=>'application/x-troff',
'tar'=>'application/x-tar',
'tcl'=>'application/x-tcl',
'tex'=>'application/x-tex',
'texi'=>'application/x-texinfo',
'texinfo'=>'application/x-texinfo',
'tgz'=>'application/x-compressed',
'tif'=>'image/tiff',
'tiff'=>'image/tiff',
'tr'=>'application/x-troff',
'trm'=>'application/x-msterminal',
'tsv'=>'text/tab-separated-values',
'txt'=>'text/plain',
'uls'=>'text/iuls',
'ustar'=>'application/x-ustar',
'vcf'=>'text/x-vcard',
'vrml'=>'x-world/x-vrml',
'wav'=>'audio/x-wav',
'wcm'=>'application/vnd.ms-works',
'wdb'=>'application/vnd.ms-works',
'wks'=>'application/vnd.ms-works',
'wmf'=>'application/x-msmetafile',
'wps'=>'application/vnd.ms-works',
'wri'=>'application/x-mswrite',
'wrl'=>'x-world/x-vrml',
'wrz'=>'x-world/x-vrml',
'xaf'=>'x-world/x-vrml',
'xbm'=>'image/x-xbitmap',
'xla'=>'application/vnd.ms-excel',
'xlc'=>'application/vnd.ms-excel',
'xlm'=>'application/vnd.ms-excel',
'xls'=>'application/vnd.ms-excel',
'xlsx'=>'application/vnd.ms-excel',
'xlt'=>'application/vnd.ms-excel',
'xlw'=>'application/vnd.ms-excel',
'xof'=>'x-world/x-vrml',
'xpm'=>'image/x-xpixmap',
'xwd'=>'image/x-xwindowdump',
'z'=>'application/x-compress',
'zip'=>'application/zip');

$ext = '';
$mime = '';

$filename2 = strrev(strtolower($filename));

foreach($arr as $key=>$val)
{
	$ext2 = strrev($key).'.';
	$pos = stripos($filename2, $ext2);
	if($pos === 0)
	{
		$ext = $key;
		$mime = $val;
		break;
	}
}
if(!$ext)
{
	$arr2 = explode(".", $filename);
	$ext = $arr2[count($arr2)-1];
}
$obj->extension = $ext;
$obj->mime = $mime;
return $obj;
}

function path_encode($dir, $root=NULL){
if($root===NULL){
global $cfg;
$rootdir = $cfg->rootdir;
}
else{
$rootdir = $root;
}
$dir = rtrim(str_replace(array("/..","../","./","..\\",".\\","\\","//"),"/",$dir),"/\\");
$rootdir = trim(str_replace(array("/..","../","./","..\\",".\\","\\","//"),"/",$rootdir),"/\\");
$dir2 = trim(str_replace($rootdir, 'base', $dir),"/");
$dir2 = str_replace("//","/",$dir2);
return $dir2;
}
function path_decode($dir, $root=NULL){
if($root===NULL){
global $cfg;
$rootdir = $cfg->rootdir;
}
else{
$rootdir = $root;
}
$dir2 = $dir;
if(substr($dir2,0,4)=="base")
{
$dir2 = substr($dir2,4);
}
$dir2 = rtrim($dir2,"/\\");
$rootdir = rtrim($rootdir,"/\\");
$dir2 = str_replace(array("\\..","/.."),"/",$dir2);
$dir2 = str_replace("\\", "/", $dir2);
$dir2 = str_replace("//", "/", $dir2);
$dir2 = str_replace("//", "/", $dir2);
$dir2 = str_replace("../", "/", $dir2);
$dir2 = str_replace("//", "/", $dir2);
$dir2 = $rootdir."/".$dir2;
$dir2 = rtrim($dir2,"/\\");
return $dir2;
}

function path_decode_to_url($dir,$rooturl=""){
$dir2 = $dir;
if(substr($dir2,0,4)=="base")
{
$dir2 = substr($dir2,4);
}
$dir2 = rtrim($dir2,"/\\");
$dir2 = $rooturl."/".$dir2;
$dir2 = rtrim($dir2,"/\\");
return $dir2;
}


function path_encode_trash($dir, $trash=NULL){
if($trash===NULL){
global $cfg;
$trashdir = $cfg->trashdir;
}
else{
$trashdir = $trash;
}
$dir = rtrim(str_replace(array("/..","../","./","..\\",".\\","\\","//"),"/",$dir),"/\\");
$trashdir = rtrim(str_replace(array("/..","../","./","..\\",".\\","\\","//"),"/",$trashdir),"/\\");
$dir2 = trim(str_replace($trashdir, 'base', $dir),"/");
return $dir2;
}
function path_decode_trash($dir, $trash=NULL){
if($trash===NULL){
global $cfg;
$trashdir = $cfg->trashdir;
}
else{
$trashdir = $trash;
}
$dir2 = $dir;
if(substr($dir2,0,4)=="base")
{
$dir2 = substr($dir2,4);
}
$dir2 = rtrim($dir2,"/\\");
$trashdir = rtrim($trashdir,"/\\");
$dir2 = str_replace(array("/..","../","./","..\\",".\\","\\","//"),"/",$dir2);
$dir2 = $trashdir."/".$dir2;
$dir2 = rtrim($dir2,"/\\");
return $dir2;
}

$file_list = '';
function dir_list($dir){
global $file_list;
$dh=opendir($dir);
if($dh){
while($subitem=readdir($dh)){
if(preg_match('/^\.\.?$/',$subitem)) 
continue;
if(is_file($dir."/".$subitem))
$file_list .= "$dir/$subitem\r\n";
if( is_dir("$dir/$subitem") )
dir_list("$dir/$subitem");
}
closedir($dh);
}
}

function deleteforbidden($dir, $containsubdir=false){
global $cfg;
if($cfg->delete_forbidden_extension && file_exists($dir) && is_array($cfg->forbidden_extension))
{
	if($containsubdir){
		cleanforbiddenall($dir);
	}
	else
	{
	$dh=opendir($dir);
	if($dh){
	while($subitem=readdir($dh)){
		$fn = "$dir/$subitem";
		if($subitem == "." || $subitem == ".." ){
		continue;
		}
		$filetype = filetype($fn);
		if($filetype=="file"){
		$tt = getMIMEType($fn);
		if(in_array($tt->extension, $cfg->forbidden_extension)){
			@unlink($fn);
		}
		}
	}
	closedir($dh);
	}
}
}
}
function dmstoreal($deg, $min, $sec){
return $deg + ((($min*60)+($sec))/3600);
}

function real2dms($val){
$tm = $val * 3600;
$tm = round($tm);
$h = sprintf("%02d",date("H",$tm)-7);
if($h<0) $h+=24;
$m = date("i",$tm);
$s = date("s",$tm);
return array($h,$m,$s);
}

function builddirtree($dir){
$dir = str_replace("\\", "/", $dir);
$arr = explode("/", $dir);
$ret = "%s";
$dt = array();
$dt['path'] = "";
$dt['name'] = "";
$dt['location'] = "";
foreach($arr as $k=>$val){
	$dt['path'] = $dt['path'].$val;
	$dt['name'] = basename($val);
	$dt['location'] = $dt['location'].($val);
	if($k>1){
	$html = "<ul>\r\n";
	$html .= "<li class=\"row-data-dir dir-control\" data-file-name=\"".$dt['name']."\" data-file-location=\"".$dt['location']."\"><a href=\"javascript:;\" onClick=\"return openDir('".$dt['path']."')\">".$dt['name']."</a>";
	$html .= "%s</li>\r\n";
	$html .= "</ul>";
	$ret2 = sprintf($ret, $html);
	$ret = $ret2;
	}
	$dt['path'] = $dt['path']."/";
	$dt['name'] = $dt['name']."/";
	$dt['location'] = $dt['location']."/";
}
$ret = str_replace("%s","",$ret);
return $ret;
}
?>