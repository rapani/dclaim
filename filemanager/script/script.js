var angle = 0;
var fliph = 0;
var flipv = 0;
var resize = 0;
var imgwidth = 1;
var imgheight = 1;
var crop = 0;
var filepath = '';
var fileurl = '';
function addslashes(input){
var searchStr = "\'";
var replaceStr = "\\'";
var re = new RegExp(searchStr , "g");
var output = input.replace(re, replaceStr);
return output;
}
function inArray(needle,haystack){
var i;
for(i in haystack){if(needle==haystack[i]){return true;}}
return false;
}
function basename(path){
return path.replace(/\\/g,'/').replace(/.*\//,'');
}
function dirname(path){
return path.replace(/\\/g,'/').replace(/\/[^\/]*$/,'');
}
function getfileextension(filename){
return (/[.]/.exec(filename))?/[^.]+$/.exec(filename):'';
}
function removefileextension(filename){
return filename.replace(/\.[^/.]+$/,'');
}
function setCheckRelation(){
$('.checkbox-selector').live('change',function(){
var id=$(this).attr('id');
var classname=id.substring(8);
var checked=$(this).attr('checked');
if(checked=='checked'){
$('.'+classname).attr('checked','checked');
}
else{
$('.'+classname).removeAttr('checked');
}
});
}
function jqAlert(msg, title, width, height)
{
	$('#message-box-dialog').remove();
	$('body').append('<div id="message-box-dialog"><div id="message-box-dialog-inner"></div></div>');
	if(!title) title = 'Alert';
	if(!width) width = 300;
	if(!height) height = 160;
	$('#message-box-dialog').dialog('destroy');
	$('#message-box-dialog').attr('title', title);
	$('#message-box-dialog-inner').html(msg);
	$('#message-box-dialog').dialog({
	width:width,
	height:height,
	modal:true,
	buttons:{
	'Close':function(){
		$('#message-box-dialog').dialog('destroy');
	}
	}
	});
}
function checkForm(frm){
var formid=$(frm).attr('id');
if(!formid || formid=='')
{
	formid='form'+Math.round(Math.random()*10000);
	$(frm).attr('id',formid);
}
var needed=0;
var inputid='';
$('#'+formid+' :input').each(function(index){
if($(this).attr('data-needed')=='true'&&!$(this).val())
{
needed++;
if(inputid=='') inputid=$(this).attr('id');
}
if($(this).attr('data-needed')=='true'&&$(this).attr('data-type')=='email'&&!isValidEmail($(this).val()))
{
needed++;
if(inputid=='') inputid=$(this).attr('id');
}
});
if(needed>0){
$('#'+inputid).focus();
return false;
}
return true;
}

function contextMenu(selector, menu){
$(selector).bind('contextmenu',function(e){
	e.preventDefault();
	var left = parseInt(e.clientX);
	var top  = e.clientY;
	var html;
	var scrllf = $(document).scrollLeft();
	var scrltp = $(document).scrollTop();
	left = parseInt(left)+parseInt(scrllf);
	top = parseInt(top)+parseInt(scrltp);
	var width = parseInt($(window).width());
	var height = parseInt($(window).height());
	$('.kams-context-menu').remove();
	html = '<div class="kams-context-menu"></div>';
	$('body').append(html);
	html = '<ul>';
	for(var i in menu)
	{
		var classname = menu[i]['classname'];
		html += '<li class="file-function file-function-'+classname+'"><a href="'+menu[i]['linkurl']+'">'+menu[i]['caption']+'</a></li>';
	}
	html += '</ul>';
	$('.kams-context-menu').html(html);
	$('.kams-context-menu').css({'display':'none','left':left+'px','top':top+'px'});
	var cmwidth = parseInt($('.kams-context-menu').width());
	var cmheight = parseInt($('.kams-context-menu').height());
	if((cmwidth + left + 16) >= width)
	{
		left = left - cmwidth;
		$('.kams-context-menu').css({'left':left+'px','top':top+'px'});
	}
	if((cmheight + top + 20) >= height)
	{
		top = height - parseInt(cmheight) - 20;
		$('.kams-context-menu').css({'left':left+'px','top':top+'px'});
	}
	$('.kams-context-menu').fadeIn(300);
	$(document).bind('click',function(){
	$('.kams-context-menu').remove();
	});
	$(document).keydown(function(event){if((event.keyCode&&event.keyCode===$.ui.keyCode.ESCAPE)){$('.kams-context-menu').remove();}});
	return false;
});
}

function setSize(){
var wh = parseInt($(window).height());
var ww = parseInt($(window).width());
$('.directory-area, .file-area').css('height', (wh-85)+'px');
$('.address').css('width', (ww-120)+'px');
}

function initContextMenuFileArea(){
var cm = [
{'caption':'Copy Selected File', 'linkurl':'javascript:copySelectedFile()', 'classname':'copy'},
{'caption':'Cut Selected File', 'linkurl':'javascript:cutSelectedFile()', 'classname':'cut'},
{'caption':'Move Selected File', 'linkurl':'javascript:moveSelectedFile()', 'classname':'move'},
{'caption':'Delete Selected File', 'linkurl':'javascript:deleteSelectedFile()', 'classname':'delete'},
{'caption':'Compress Selected File', 'linkurl':'javascript:compressSelectedFile()', 'classname':'compress'},
{'caption':'Paste File', 'linkurl':'javascript:pasteFile()', 'classname':'paste'},
{'caption':'Create New File', 'linkurl':'javascript:createFile()', 'classname':'createfile'},
{'caption':'Create New Directory', 'linkurl':'javascript:createDirectory()', 'classname':'createdir'},
{'caption':'Up Directory', 'linkurl':'javascript:goToUpDir()', 'classname':'up'},
{'caption':'Refresh File List', 'linkurl':'javascript:refreshList()', 'classname':'refresh'},
{'caption':'Change View Type', 'linkurl':'javascript:thumbnail()', 'classname':'viewtype'},
{'caption':'Upload File', 'linkurl':'javascript:uploadFile()', 'classname':'upload'},
{'caption':'Check All', 'linkurl':'javascript:selectAll(1)', 'classname':'check'},
{'caption':'Uncheck All', 'linkurl':'javascript:selectAll(0)', 'classname':'uncheck'},
{'caption':'Empty Clipboard', 'linkurl':'javascript:emptyClipboard()', 'classname':'empty-clipboard'}
];
contextMenu('.file-area', cm);
}

function initContextMenuFile(){
$('.row-data-file').each(function(index){
var filetype = $(this).attr('data-file-type');
var filename = $(this).attr('data-file-name');
var filelocation = $(this).attr('data-file-location');
var filepath = filelocation+'/'+filename;
var fileurl = $(this).attr('data-file-url');
var selfurl = $(this).attr('data-file-url');
if(filetype.indexOf('image')!=-1 || filetype.indexOf('shockwave')!=-1)
{
	var width = $(this).attr('data-image-width');
	var height = $(this).attr('data-image-height');	
	attr = {'width':width, 'height':height};
	contextMenu(this, contextMenuListFile(filetype, filepath, fileurl, attr));
}
else
{
contextMenu(this, contextMenuListFile(filetype, filepath, fileurl));
}
});
}

function initContextMenuDir(){
$('.row-data-dir').each(function(index){
var filetype = $(this).attr('data-file-type');
var filename = $(this).attr('data-file-name');
var filelocation = $(this).attr('data-file-location');
var filepath = filelocation+'/'+filename;
contextMenu(this, contextMenuListDir(filepath));
});
}

function contextMenuListFile(filetype, filepath, fileurl, attr){
	filepath = addslashes(filepath);
	fileurl = addslashes(fileurl);
	var width = '0';
	var height = '0';
	var cm = new Array();
	if(filetype.indexOf('image')==0)
	{
		width = parseInt(attr['width']);
		height = parseInt(attr['height']);
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Preview Image',				'linkurl':'javascript:previewFile(\''+fileurl+'\', '+width+', '+height+')',	'classname':'preview'},
		{'caption':'Edit Image',				'linkurl':'javascript:editImage(\''+filepath+'\')','classname':'edit-image'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'Image Properties',			'linkurl':'javascript:propertyImage(\''+filepath+'\')',	'classname':'property'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else if(filetype.indexOf('video')==0)
	{
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Play Video with Moxie Player','linkurl':'javascript:playVideo(\''+fileurl+'\', \'moxie\')',	'classname':'play'},
		{'caption':'Play Video (Embed)',		'linkurl':'javascript:playVideo(\''+fileurl+'\', \'embed\')',	'classname':'play'},
		{'caption':'Play Video (HTML5)',		'linkurl':'javascript:playVideo(\''+fileurl+'\', \'html5\')',	'classname':'play'},
		{'caption':'Play Video (IFRAME)',		'linkurl':'javascript:playVideo(\''+fileurl+'\', \'iframe\')',	'classname':'play'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else if(filetype.indexOf('audio')==0)
	{
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Play Audio (Embed)',		'linkurl':'javascript:playAudio(\''+fileurl+'\', \'embed\')',	'classname':'play'},
		{'caption':'Play audio (HTML5)',		'linkurl':'javascript:playAudio(\''+fileurl+'\', \'html5\')',	'classname':'play'},
		{'caption':'Play Audio (IFRAME)',		'linkurl':'javascript:playAudio(\''+fileurl+'\', \'iframe\')',	'classname':'play'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else if(filetype.indexOf('pdf')!=-1)
	{
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Read PDF Document',			'linkurl':'javascript:previewPDF(\''+fileurl+'\')',		'classname':'preview'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else if(filetype.indexOf('shockwave')!=-1)
	{
		width = parseInt(attr['width']);
		height = parseInt(attr['height']);
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'View Shock Wave',			'linkurl':'javascript:previewSWF(\''+fileurl+'\', '+width+', '+height+')','classname':'preview'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else if(filetype.indexOf('application/zip')==0)
	{
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Extract File',				'linkurl':'javascript:extractFile(\''+filepath+'\')',	'classname':'extract'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else if(filetype.indexOf('text')==0 || filetype.indexOf('php')!=-1)
	{
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Edit as Text',				'linkurl':'javascript:editFile(\''+filepath+'\')',		'classname':'edit'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	else
	{
		cm = [
		{'caption':'Select File',				'linkurl':'javascript:selectFile(\''+fileurl+'\')',		'classname':'select'},
		{'caption':'Copy File',					'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
		{'caption':'Cut File',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
		{'caption':'Rename File',				'linkurl':'javascript:renameFile(\''+filepath+'\')',	'classname':'rename'},
		{'caption':'Move File',					'linkurl':'javascript:moveFile(\''+filepath+'\')',		'classname':'move'},
		{'caption':'Delete File',				'linkurl':'javascript:deleteFile(\''+filepath+'\')',	'classname':'delete'},
		{'caption':'Compress File',				'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
		{'caption':'Download File',				'linkurl':fileurl+'" target="_blank',					'classname':'download'},
		{'caption':'Force Download File',		'linkurl':'javascript:forceDownloadFile(\''+filepath+'\')',	'classname':'download'},
		{'caption':'File Properties',			'linkurl':'javascript:propertyFile(\''+filepath+'\')',	'classname':'property'}
		];
	}
	return cm;
}
function contextMenuListDir(filepath){
	filepath = addslashes(filepath);
	var cm = new Array();
	cm = [
	{'caption':'Open Directory',				'linkurl':'javascript:;" onClick="return openDir(\''+filepath+'\')', 'classname':'open'},
	{'caption':'Copy Directory',				'linkurl':'javascript:copyFile(\''+filepath+'\')',		'classname':'copy'},
	{'caption':'Rename Directory',				'linkurl':'javascript:renameFile(\''+filepath+'\', true)',	'classname':'rename'},
	{'caption':'Cut Directory',					'linkurl':'javascript:cutFile(\''+filepath+'\')',		'classname':'cut'},
	{'caption':'Move Directory',				'linkurl':'javascript:moveFile(\''+filepath+'\', true)','classname':'move'},
	{'caption':'Delete Directory',				'linkurl':'javascript:deleteDirectory(\''+filepath+'\')','classname':'delete'},
	{'caption':'Compress Directory',			'linkurl':'javascript:compressFile(\''+filepath+'\')',	'classname':'compress'},
	{'caption':'Directry Properties',			'linkurl':'javascript:propertyDir(\''+filepath+'\')',	'classname':'property'}
	];
	return cm;
}

var skipondrop = false;
// file function

function goToUpDir(){
	openDir(dirname($('#address').val()));
}
function forceDownloadFile(filepath)
{
	window.open('tool-download-file.php?filepath='+encodeURIComponent(filepath));
}
function previewFile(url, width, height, fullsize)
{
	var w = width, h = height, html = '';
	if(fullsize){
	html = '<img src="'+url+'" width="'+w+'" height="'+h+'" class="image2zoomout" onclick="previewFile(\''+url+'\', \''+width+'\', \''+height+'\', false);" />';
	}
	else
	{
	if(width>500)
	{
		w = 500;
		h = (height/width)*w;
	}
	html = '<img src="'+url+'" width="'+w+'" height="'+h+'" class="image2zoomin" onclick="previewFile(\''+url+'\', \''+width+'\', \''+height+'\', true);" />';
	}
	overlayDialog(html, w, h);
}

function playVideo(url, type)
{
	var html = '';
	if(type=='iframe')
	html = '<iframe frameborder="0" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="auto" src="'+url+'" width="500" height="375" /></ifame>';
	else if(type=='html5')
	html = '<video src="'+url+'" poster="style/images/movie.png" controls="true" width="500" height="375">This is fallback content to display if the browser does not support the video element.</video>';
	else if(type=='moxie')
	html = '<object width="500" height="375" type="application/x-shockwave-flash" data="moxieplayer.swf"><param name="url" value="'+url+'"><param name="src" value="moxieplayer.swf"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="true"><param name="autoplay" value="true"><param name="flashvars" value="url='+url+'&amp;poster=style/images/movie.png&amp;autoplay=true"></object>';
	else
	html = '<object width="500" height="375" data="'+url+'" type="application/x-mplayer2"><param name="url" value="'+url+'" /></object>';
	overlayDialog(html, 500, 375);
}

function playAudio(url, type)
{
	var html = '';
	if(type=='iframe')
	html = '<iframe frameborder="0" hspace="0" vspace="0" marginheight="0" marginwidth="0" scrolling="auto" src="'+url+'" width="320" height="50" /></ifame>';
	else if(type=='html5')
	html = '<video src="'+url+'" poster="audio.jpg" controls="true" width="320" height="50">This is fallback content to display if the browser does not support the audio element.</video>';
	else if(type=='moxie')
	html = '<object width="320" height="50" type="application/x-shockwave-flash" data="moxieplayer.swf"><param name="url" value="'+url+'"><param name="src" value="moxieplayer.swf"><param name="allowfullscreen" value="true"><param name="allowscriptaccess" value="true"><param name="autoplay" value="true"><param name="flashvars" value="url='+url+'&amp;poster=style/images/audio.png&amp;autoplay=true"></object>';
	else 
	html = '<object width="320" height="50" data="'+url+'" type="application/x-mplayer2"><param name="url" value="'+url+'" /></object>';
	overlayDialog(html, 320, 50);
}

function previewPDF(url){
	var html = '<embed src="'+url+'#toolbar=0&amp;navpanes=0&amp;scrollbar=0" width="720" height="400">';
	overlayDialog(html, 720, 400);
}
function previewSWF(url, width, height)
{
	var html = '<object width="'+width+'" height="'+height+'" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0"><param name="src" value="'+url+'"><embed src="'+url+'" width="'+width+'" height="'+height+'"></embed></object>';
	overlayDialog(html, width, height);	
}
function propertyFile(filepath)
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'File Properties');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:260,
		buttons:
		{
			'Close':function(){
				$(this).dialog('destroy');
			}
		}
	});
	$.get('tool-property-file.php', {'filepath':filepath}, function(answer){
		$('#common-dialog-inner').html(answer);
	});
}
function propertyImage(filepath)
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Image Properties');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:400,
		buttons:
		{
			'Close':function(){
				$(this).dialog('destroy');
			}
		}
	});
	$.get('tool-property-file.php', {'filepath':filepath, 'type':'image'}, function(answer){
		$('#common-dialog-inner').html(answer);
	});
}
function propertyDir(filepath)
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Directory Properties');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:220,
		buttons:
		{
			'Close':function(){
				$(this).dialog('destroy');
			}
		}
	});
	$.get('tool-property-file.php', {'filepath':filepath, 'type':'directory'}, function(answer){
		$('#common-dialog-inner').html(answer);
	});
}
function renameFile(filepath, isdir)
{
	if(!filepath){
		// assume this is a file
		// get selected file
		var pth;
		$('.fileid:checked').each(function(index){
			if(pth==undefined)
			{
				pth = $(this).attr('value');
				if(pth!=undefined)
				{
					filepath = pth;
					if($(this).attr('data-isdir')=='true')
					{
						isdir = true;
					}
				}
			}
		});
	}
	if(filepath)
	{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	if(isdir){
	$('#common-dialog').attr('title', 'Rename Directory');
	}
	else{
	$('#common-dialog').attr('title', 'Rename File');
	}
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:190,
		buttons:
		{
			'OK':function(){
				var dl = $('#fflocation').val();
				var on = $('#ffoldname').val();
				var nn = $('#ffnewname').val();
				var oe = getfileextension(on.trim());
				var ne = getfileextension(nn.trim());
				nn = nn.trim();
				if(nn == '')
				{
					jqAlert('Please type new name.', 'Input Needed');
					$('#ffnewname').val(on);
					$('#ffnewname').select();
				}
				else if(on == nn)
				{
					jqAlert('New name and old name must be different.', 'Invalid Name');
				}
				else
				{
					if(oe.toString() != ne.toString() && !isdir)
					{
						if(!confirm('The new file extension is different with old one. '+
								   'If you change a file extension, the file might become unusable.\n'+
								   'Are you sure you want to change it?'))
						{
							return;
						}
					}
					$.post('tool-file-operation.php?option=renamefile', {'location':dl, 'oldname':on, 'newname':nn}, function(answer){
					if(answer=='SUCCESS')
					{
						openDir(dl);
						$('#common-dialog').dialog('destroy');				
					}
					else if(answer=='EXIST')
					{
						jqAlert(nn+' already exists. Please type another name.', 'Invalid Name');
					}
					else if(answer=='READONLY')
					{
						jqAlert('The operation was disabled on read only mode.', 'Read Only');
					}
					});
				}
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<form id="formfilerename" name="form1" method="post" action="">'+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Location</td>'+
	'<td><input type="text" name="fflocation" id="fflocation" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>Current Name</td>'+
	'<td><input type="text" name="ffoldname" id="ffoldname" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>New Name</td>'+
	'<td><input type="text" name="ffnewname" id="ffnewname" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'</form>';
	$('#common-dialog-inner').html(html);
	$('#fflocation').val(dirname(filepath));
	$('#ffoldname, #ffnewname').val(basename(filepath));
	$('#ffnewname').select();
	}
	else
	{
		jqAlert('No file or directory selected.', 'Invalid Operation');
		return;
	}
}

function compressFile(filepath)
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Compress File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:165,
		buttons:
		{
			'OK':function(){
				var sf = $('#ffsourcepath').val();
				var tf = $('#fftargetpath').val();
				$.post('tool-file-operation.php?option=compressfile', {'sourcepath[]':sf,'targetpath':tf}, function(answer){
					if(answer == 'CONFLIC')
					{
						jqAlert('Please enter another name.', 'Invalid Name');
					}
					else if(answer == 'SUCCESS')
					{
						openDir(dirname(tf));
						$('#common-dialog').dialog('destroy');
					}
					else if(answer == 'FAILED')
					{
						jqAlert('The operation was failed.', 'Unknown Error Occured');
					}
					else if(answer=='READONLY')
					{
						jqAlert('The operation was disabled on read only mode.', 'Read Only');
					}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<form id="formfilerename" name="form1" method="post" action="">'+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Source Name</td>'+
	'<td><input type="text" name="ffsourcepath" id="ffsourcepath" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>Target Name</td>'+
	'<td><input type="text" name="fftargetpath" id="fftargetpath" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'</form>';
	$('#common-dialog-inner').html(html);
	$('#ffsourcepath').val(filepath);
	$('#fftargetpath').val(removefileextension(filepath)+'.zip');
}
function compressSelectedFile(){
	var dl = $('#address').val();
	var file2compress = '';
	var chk = 0;
	var html = '';
	$('.fileid:checked').each(function(index){
		file2compress += '<div>'+$(this).val()+'</div>';
		chk++;
	});
	
	if(chk){
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Compress File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:250,
		buttons:
		{
			'OK':function(){
				var targetpath = $('#fftargetpath').val();
				var args = 'targetpath='+encodeURIComponent(targetpath);
				
				$('.fileid:checked').each(function(index){
				args+='&sourcepath[]='+encodeURIComponent($(this).val());
				});
				$.post('tool-file-operation.php?option=compressfile', {'postdata':args}, function(answer){
					if(answer=='SUCCESS' || answer=='EXIST')
					{
						openDir(dirname(targetpath));
						$('#common-dialog').dialog('destroy');
					}
					if(answer == 'CONFLIC')
					{
						jqAlert('Please enter another name.', 'Invalid Name');
					}
					else if(answer == 'SUCCESS')
					{
						openDir(dirname(tf));
						$('#common-dialog').dialog('destroy');
					}
					else if(answer == 'FAILED')
					{
						jqAlert('The operation was failed.', 'Unknown Error Occured');
					}
					else if(answer=='READONLY')
					{
						jqAlert('The operation was disabled on read only mode.', 'Read Only');
					}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});

	html = ''+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Target Name</td>'+
	'<td><input type="text" name="fftargetpath" id="fftargetpath" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'<div></div><div>File to be compressed:</div><div class="seleted-file-list">'+file2compress+'</div></div>';
	$('#common-dialog-inner').html(html);
	$('#fftargetpath').val(dl+'/new-compressed.zip');
	}
	else
	{
		jqAlert('No file selected.', 'Invalid Operation');
	}
}
function moveSelectedFile(){
	var dl = $('#address').val();
	var file2move = '';
	var chk = 0;
	var html = '';
	$('.fileid:checked').each(function(index){
		file2move += '<div>'+$(this).val()+'</div>';
		chk++;
	});
	if(chk){
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Move File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:250,
		buttons:
		{
			'OK':function(){
				var targetdir = $('#fftargetdir').val();
				if(dl!=targetdir)
				{
					var args = 'targetdir='+encodeURIComponent(targetdir);
					$('.fileid:checked').each(function(index){
						args+='&file[]='+encodeURIComponent($(this).val());
					});
					var q = '?option=copyfile&deletesource=1';
					$.post('tool-file-operation.php'+q, {'postdata':args}, function(answer){
						if(answer=='SUCCESS' || answer=='EXIST')
						{
							openDir($('#fftargetdir').val());
							$('#common-dialog').dialog('destroy');
						}
						else if(answer=='READONLY')
						{
							jqAlert('The operation was disabled on read only mode.', 'Read Only');
						}
					});
				}
				else
				{
					jqAlert('Please enter another name.', 'Invalid Name');
				}
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});

	html = ''+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">New Location</td>'+
	'<td><input type="text" name="fftargetdir" id="fftargetdir" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'<div></div><div>File to be moved:</div><div class="seleted-file-list">'+file2move+'</div></div>';
	$('#common-dialog-inner').html(html);
	$('#fftargetdir').focus();
	$('#fftargetdir').val(dl);
	}
	else
	{
		jqAlert('No file selected.', 'Invalid Operation');
	}
}
function extractFile(filepath)
{
	if(!filepath)
	{
		var pth = $('.fileid:checked[data-iszip=true]').attr('value');
		if(pth!=undefined)
		{
			filepath = pth;
		}
		else
		{
			jqAlert('No file selected.', 'Invalid Operation');
			return;
		}
	}
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Extract File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:160,
		buttons:
		{
			'OK':function(){
				var filepath = $('#ffsourcename').val();
				var targetdir = $('#fftargetdir').val();
				$.post('tool-file-operation.php?option=extractfile', {'filepath':filepath, 'targetdir':targetdir}, function(answer){
				if(answer=='SUCCESS')
				{
					openDir(targetdir);
					$('#common-dialog').dialog('destroy');
				}
				else if(answer=='FAILED')
				{
					jqAlert('This file is not a Zip file.', 'Invalid Format');
				}
				else if(answer=='READONLY')
				{
					jqAlert('The operation was disabled on read only mode.', 'Read Only');
				}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<form id="formfilerename" name="form1" method="post" action="">'+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Source Name</td>'+
	'<td><input type="text" name="ffsourcename" id="ffsourcename" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>Target Location</td>'+
	'<td><input type="text" name="fftargetdir" id="fftargetdir" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'</form>';
	$('#common-dialog-inner').html(html);
	$('#ffsourcename').val(filepath);
	$('#fftargetdir').val(dirname(filepath));
}

function createFile()
{
	var dir = $('#address').val();
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Create New File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:190,
		buttons:
		{
			'OK':function(){
				var dl = $('#fflocation').val();
				var dn = $('#ffname').val();
				$.post('tool-file-operation.php?option=createfile', {'location':dl, 'name':dn}, function(answer){
					if(answer == 'EXIST')
					{
						jqAlert(dl+'/'+dn+' already exists. Please type another name.');
						$('#ffname').select();
					}
					else if(answer == 'SUCCESS')
					{
						openDir(dl);
						$('#common-dialog').dialog('destroy');
					}
					else if(answer=='READONLY')
					{
						jqAlert('The operation was disabled on read only mode.', 'Read Only');
					}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<form id="formfilecreate" name="form1" method="post" action="">'+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Location</td>'+
	'<td><input type="text" name="fflocation" id="fflocation" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>Directory Name</td>'+
	'<td><input type="text" name="ffname" id="ffname" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'</form>';
	$('#common-dialog-inner').html(html);
	$('#fflocation').val(dir);
	$('#ffname').val('new-file.txt');
	$('#ffname').select();
}

function createDirectory()
{
	var dir = $('#address').val();
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Create Directory');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:190,
		buttons:
		{
			'OK':function(){
				var dl = $('#fflocation').val();
				var dn = $('#ffname').val();
				$.post('tool-file-operation.php?option=createdir', {'location':dl, 'name':dn}, function(answer){
					if(answer == 'EXIST')
					{
						jqAlert(dl+'/'+dn+' already exists. Please type another name.');
						$('#ffname').select();
					}
					else if(answer == 'SUCCESS')
					{
						openDir(dl);
						$('#common-dialog').dialog('destroy');
					}
					else if(answer=='READONLY')
					{
						jqAlert('The operation was disabled on read only mode.', 'Read Only');
					}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<form id="formfilerename" name="form1" method="post" action="">'+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Location</td>'+
	'<td><input type="text" name="fflocation" id="fflocation" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>Directory Name</td>'+
	'<td><input type="text" name="ffname" id="ffname" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'</form>';
	$('#common-dialog-inner').html(html);
	$('#fflocation').val(dir);
	$('#ffname').val('new-directory');
	$('#ffname').select();
	
}

function moveFile(filepath, isdir)
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	if(isdir){
	$('#common-dialog').attr('title', 'Move Directory');
	}
	else{
	$('#common-dialog').attr('title', 'Move File');
	}
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:180,
		buttons:
		{
			'OK':function(){
				var dl = $('#address').val();
				var targetdir = $('#ffnewlocation').val();
				var curlocation = $('#ffcurrentlocation').val();
				var args = 'targetdir='+encodeURIComponent(targetdir);
				args+='&file[]='+encodeURIComponent(curlocation+'/'+$('#ffpath').val());
				var q = '?option=copyfile&deletesource=1';
				$.post('tool-file-operation.php'+q, {'postdata':args}, function(answer){
					if(answer=='SUCCESS' || answer=='EXIST')
					{
						openDir(dl);
						$('#common-dialog').dialog('destroy');
					}
					else if(answer=='READONLY')
					{
						jqAlert('The operation was disabled on read only mode.', 'Read Only');
					}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<form id="formfilemove" name="form1" method="post" action="">'+
	'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
	'<tr>'+
	'<td width="30%">Base Name</td>'+
	'<td><input type="text" name="ffpath" id="ffpath" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>Current Location</td>'+
	'<td><input type="text" name="ffcurrentlocation" id="ffcurrentlocation" class="input-text" autocomplete="off" readonly="readonly" /></td>'+
	'</tr>'+
	'<tr>'+
	'<td>New location</td>'+
	'<td><input type="text" name="ffnewlocation" id="ffnewlocation" class="input-text" autocomplete="off" /></td>'+
	'</tr>'+
	'</table>'+
	'</form>';
	$('#common-dialog-inner').html(html);
	$('#ffpath').val(basename(filepath));
	$('#ffcurrentlocation').val(dirname(filepath));
	$('#ffnewlocation').focus();
	$('#ffnewlocation').val(dirname(filepath));
}
function uploadFile()
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Upload File');
	$('#common-dialog').dialog({
		modal:true,
		width:600,
		height:400,
		buttons:
		{
			'Close':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var dl = $('#address').val();
	var html = ''+
	'<div id="imageuploader">'+
	'<form method="post" enctype="multipart/form-data" action="tool-upload-file.php?iframe=1" target="formdumper">'+
	'<input type="hidden" name="targetdir" id="targetdir" value="">'+
	'File <input type="file" name="file" id="images" />'+
	'<input type="submit" class="upload-button" value="Upload Files" style="display:none" />'+
	'</form><div id="response"></div><ul id="image-list"></ul></div>'+
	'<iframe style="display:none; width:0px; height:0px;" id="formdumper" name="formdumper"></iframe>'+
	'</div>';

	$('#common-dialog-inner').html(html);
	$('#targetdir').val(dl);
	$.ajax({type: "GET", url: "script/upload.js", dataType: "script"});
}
function saveFile(filepath, filecontent){
	$.post('tool-edit-file.php?option=savefile', {'filepath':filepath, 'filecontent':filecontent}, function(answer){
	if(answer=='READONLY')
	{
		jqAlert('The operation was disabled on read only mode.', 'Read Only');
	}
	else
	{
		openDir();
	}
	});
}
function editFile(filepath)
{
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Edit Text File');
	$('#common-dialog').dialog({
		modal:true,
		width:600,
		height:400,
		buttons:
		{
			'Save':function(){
				saveFile($('#filepath').val(), $('#filecontent').val());
			},
			'Save and Close':function(){
				saveFile($('#filepath').val(), $('#filecontent').val());
				$(this).dialog('destroy');
			},
			'Close without Save':function(){
				$(this).dialog('destroy');
			}
		}
	});
	$.get('tool-edit-file.php', {'option':'openfile','filepath':filepath}, function(answer){
		$('#common-dialog-inner').html(answer);
	});
}
function deleteFile(filepath)
{
	var dl = dirname(filepath);
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Delete File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:160,
		buttons:
		{
			'OK':function(){
				var args = '';
				args = 'file[]='+filepath;
				$.post('tool-file-operation.php?option=deletefile', {'postdata':args}, function(answer){
				if(answer=='SUCCESS')
				{
					openDir(dl);
					$('#common-dialog').dialog('destroy');
				}
				else if(answer=='READONLY')
				{
					jqAlert('The operation was disabled on read only mode.', 'Read Only');
				}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<div>Are you sure to delete this file:<br />'+filepath+'</div>';
	$('#common-dialog-inner').html(html);
}
function deleteDirectory(filepath)
{
	var dl = $('#address').val();
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Delete Directory');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:160,
		buttons:
		{
			'OK':function(){
				var args = '';
				args = 'file[]='+filepath;
				$.post('tool-file-operation.php?option=deletefile', {'postdata':args}, function(answer){
				if(answer=='SUCCESS')
				{
					openDir(dl);
					$('#common-dialog').dialog('destroy');
				}
				else if(answer=='READONLY')
				{
					jqAlert('The operation was disabled on read only mode.', 'Read Only');
				}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});
	var html = ''+
	'<div>Are you sure to delete this directory including its files:<br />'+filepath+'</div>';
	$('#common-dialog-inner').html(html);
}
function deleteSelectedFile(){
	var dl = $('#address').val();
	var args = '';
	var file2del = '';
	var chk = 0;
	var html = '';
	$('.fileid:checked').each(function(index){
		file2del += '<div>'+$(this).val()+'</div>';
		args += '&file[]='+encodeURIComponent($(this).val());
		chk++;
	});
	if(chk){
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Delete File');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:240,
		buttons:
		{
			'OK':function(){
				$.post('tool-file-operation.php?option=deletefile', {'postdata':args}, function(answer){
				if(answer=='SUCCESS')
				{
					openDir(dl);
					$('#common-dialog').dialog('destroy');
				}
				else if(answer=='READONLY')
				{
					jqAlert('The operation was disabled on read only mode.', 'Read Only');
				}
				});
			},
			'Cancel':function(){
				$(this).dialog('destroy');
			}
		}
	});	
	html = '<div>Are you sure to delete file/s:</div><div class="seleted-file-list">'+file2del+'</div></div>';
	$('#common-dialog-inner').html(html);
	}
	else
	{
		jqAlert('No file selected.', 'Invalid Operation');
	}
}

function selectAll(sel){
	if(sel){
	$('.fileid').attr('checked', 'checked');
	}
	else{
	$('.fileid').removeAttr('checked');
	}
}
var togglethumb = false;
function thumbnail(){
	var curdir = $('#address').val();
	togglethumb = !togglethumb;
	if(togglethumb)
	{
		$('#tb-thumbnail').addClass('tb-selected');
	}
	else
	{
		$('#tb-thumbnail').removeClass('tb-selected');
	}
	// keep selected files
	var selectedfile = new Array();
	$('.fileid:checked').each(function(index){
		selectedfile[selectedfile.length] = $(this).val();
	});
	openDir(curdir, selectedfile);
}

function refreshList(){
openDir();
}
var clipboardfile = {'operation':'', 'content':[]};

function copySelectedFile(){
	this.operation = 'copy';
	this.content = new Array();
	var ff = this;
	var chk = 0;
	$('.fileid:checked').each(function(index){
		ff.content[ff.content.length] = $(this).val();
		chk++;
	});
	clipboardfile = ff;
	if(chk == 0)
	{
		jqAlert('No file selected.', 'Invalid Operation');
	}
	else
	{
		$('#tb-clipboard').removeClass('tb-hide');
		$('#tb-clipboard-empty').removeClass('tb-hide');
	}
}

function cutSelectedFile(){
	this.operation = 'cut';
	this.content = new Array();
	var ff = this;
	var chk = 0;
	$('.fileid:checked').each(function(index){
		ff.content[ff.content.length] = $(this).val();
		chk++;
	});
	clipboardfile = ff;
	if(chk == 0)
	{
		jqAlert('No file selected.', 'Invalid Operation');
	}
	else
	{
		$('#tb-clipboard').removeClass('tb-hide');
		$('#tb-clipboard-empty').removeClass('tb-hide');
	}
}
function cutFile(filepath){
	this.operation = 'cut';
	this.content = new Array();
	var ff = this;
	ff.content[ff.content.length] = filepath;
	clipboardfile = ff;
	$('#tb-clipboard').removeClass('tb-hide');
	$('#tb-clipboard-empty').removeClass('tb-hide');
}
function copyFile(filepath){
	this.operation = 'copy';
	this.content = new Array();
	var ff = this;
	ff.content[ff.content.length] = filepath;
	clipboardfile = ff;
	$('#tb-clipboard').removeClass('tb-hide');
	$('#tb-clipboard-empty').removeClass('tb-hide');
}

function pasteFile(){
var i = 0;
var dl = $('#address').val();
var pd = dl;
if(clipboardfile.content.length)
{
	var args = 'targetdir='+encodeURIComponent(dl);
	for(i in clipboardfile.content)
	{
		args+='&file[]='+encodeURIComponent(clipboardfile.content[i]);
	}
	var q = '?option=copyfile';
	if(clipboardfile.operation=='cut')
	{
		q += '&deletesource=1';
	}
	$.post('tool-file-operation.php'+q, {'postdata':args}, function(answer){
		if(answer=='SUCCESS' || answer=='EXIST')
		{
			openDir(dl);
		}
		else if(answer=='READONLY')
		{
			jqAlert('The operation was disabled on read only mode.', 'Read Only');
		}
	});
}
else
{
	jqAlert('The clipboard is empty.', 'Invalid Operation');
}
}

function emptyClipboard(){
	clipboardfile.content = new Array();
	clipboardfile.operation = '';
	$('#tb-clipboard').addClass('tb-hide');
	$('#tb-clipboard-empty').addClass('tb-hide');
}
function showClipboard(){
	$('#common-dialog').dialog('destroy');
	$('#common-dialog-inner').html('');
	$('#common-dialog').attr('title', 'Clipboard Content');
	$('#common-dialog').dialog({
		modal:true,
		width:400,
		height:220,
		buttons:
		{
			'Close':function(){
				$(this).dialog('destroy');
			}
		}
	});	
	html = '<div>File Operation: &quot;'+clipboardfile.operation+'&quot;; '+
	'Number of File: '+clipboardfile.content.length+'</div>'+
	'<div class="seleted-file-list">'+clipboardfile.content.join('<br />')+'</div>'+
	'';
	$('#common-dialog-inner').html(html);
}
function showChangePermissionDialog(filepath){
	$('#common-dialog').dialog('destroy');
	$('#common-dialog').attr('title', 'Change Permission');
	$('#common-dialog').dialog({
		modal:true,
		width:width,
		height:height,
		buttons:
		{
			'Change':function(){
				$.post('tool-file-operation.php', {'option':'change-perms', 'data':data}, function(answer){
				$('#common-dialog').dialog('destroy');
				openDir();
				});
			},
			'Close':function(){
				$(this).dialog('destroy');
			}
		}
	});	
}
function editImage(fp){
// calculate window size
var wwidth = $(window).width();
var wheight = $(window).height();
// create layer
var html = '<div id="image-editor-layer"></div>';
$('#all').append(html);
$('#image-editor-layer').css({'width':0+'px', 'height':0+'px'});
$.get('tool-image-editor-form.php', {'filepath':fp}, function(answer){
$('#image-editor-layer').html(answer);
var eh = wheight-73;
$('.image-editor-sidebar-inner, .image-editor-mainbar-inner').css('height', eh+'px');
var options = { to: { width: wwidth, height: wheight } };
$('#image-editor-layer').show('size',options, 500, callbackShowImageEditor );
initImageEditorForm();
});

}

function initImageEditorForm(){
	setSizeImageEditor();
	filepath = $('#curfilepath').val();
	fileurl = $('#curfileurl').val();
	var curw = parseInt($('#curwidth').val());
	var curh = parseInt($('#curheight').val());
	imgwidth = curw;
	imgheight = curh;
	angle = 0;
	fliph = 0;
	flipv = 0;
	$('#newwidth').live('change', function(){
		if($('#aspecratio:checked').val())
		{
		var ratio = 1;
		if(angle%180==0)
		{
			ratio = curh/curw;
		}
		else
		{
			ratio = curw/curh;
		}
		var nw = parseInt($(this).val());
		var h2 = parseInt((ratio)*nw);
		$('#newheight').val(h2);
		}
		$('#image2edit').css({'width':$('#newwidth').val()+'px','height':$('#newheight').val()+'px'});
		imgwidth = $('#newwidth').val();
		imgheight = $('#newheight').val();
		previewImageEdit();
	});
	$('#newheight').live('change', function(){
		if($('#aspecratio:checked').val())
		{
		var ratio = 1;
		if(angle%180==0)
		{
			ratio = curw/curh;
		}
		else
		{
			ratio = curh/curw;
		}
		var nh = parseInt($(this).val());
		var w2 = parseInt((ratio)*nh);
		$('#newwidth').val(w2);
		}
		$('#image2edit').css({'width':$('#newwidth').val()+'px','height':$('#newheight').val()+'px'});
		imgwidth = $('#newwidth').val();
		imgheight = $('#newheight').val();
		previewImageEdit();
	});
	$('#cropimage').live('click', function(){
		crop = $(this).attr('checked')?1:0;
		previewImageEdit();
	});

	$(window).resize(function(){
		setSizeImageEditor();
	});
}
function setSizeImageEditor(){
	var wh = parseInt($(window).height());
	var ww = parseInt($(window).width());
	var eh = wh-73;
	var ew = ww-200;
	$('.image-editor-sidebar-inner, .image-editor-mainbar-inner').css('height', eh+'px');
	$('#image-editor-layer').css('height', wh+'px');	
	$('#curfilepath').css('width', ew+'px');
}
function callbackShowImageEditor(){
	$('#wrapper').css('display', 'none');
	$('#image-editor-layer').css('position', 'static');
	$('#image-editor-layer').css('width', '100%');
}
function callbackDestroyImageEditor(){
	$('#image-editor-layer').remove();
}

function destroyImageEditor(){
	$('#wrapper').css('display', 'block');
	$('#image-editor-layer').css('top', 0);
	$('#image-editor-layer').css('left', 0);
	$('#image-editor-layer').css('position', 'absolute');
	var options = {to:{width:0, height:0}};
	$('#image-editor-layer').hide('size', options, 500, function(){
	$('#image-editor-layer').remove();
	});
}
function previewImageEdit(){
	var rnd = (Math.random()*1000);
	var html = '<img src="tool-image-editor-thumbnail.php?filepath='+encodeURIComponent(filepath)+
	'&flipv='+flipv+'&fliph='+fliph+'&angle='+angle+'&width='+imgwidth+'&height='+imgheight+'&crop='+crop+'&rand='+rnd+'" >';
	$('#image-content').html(html);
}
function saveImage(){
	if(confirm('Are you sure to save this state and replace current file?'))
	{
	filepath = $('#curfilepath').val();
	var args = 'option=save2file&filepath='+encodeURIComponent(filepath)+
	'&flipv='+flipv+'&fliph='+fliph+'&angle='+angle+'&width='+imgwidth+'&height='+imgheight+'&crop='+crop;
	$.post('tool-image-editor-thumbnail.php', {'postdata':args}, function(answer){
	if(answer=='SUCCESS')
	{
	$.get('tool-image-editor-form.php', {'filepath':filepath}, function(answer){
	$('#image-editor-layer').html(answer);
	initImageEditorForm();
	});
	}
	else if(answer=='READONLY')
	{
		jqAlert('The operation was disabled on read only mode.', 'Read Only');
	}
	});
	}
}
function rotateCW(){
	angle-=90;
	while(angle<0) angle+=360;
	angle = angle % 360;
	imgwidth = $('#newwidth').val();
	imgheight = $('#newheight').val();
	var tmp = imgwidth;
	imgwidth = imgheight;
	imgheight = tmp
	$('#newwidth').val(imgwidth);
	$('#newheight').val(imgheight);
	previewImageEdit();
}
function rotateCCW(){
	angle+=90;
	while(angle>360) angle-=360;
	angle = angle % 360;
	imgwidth = $('#newwidth').val();
	imgheight = $('#newheight').val();
	var tmp = imgwidth;
	imgwidth = imgheight;
	imgheight = tmp
	$('#newwidth').val(imgwidth);
	$('#newheight').val(imgheight);
	previewImageEdit();
}
function flipV(){
	flipv++;
	flipv = flipv % 2;
	previewImageEdit();
}

function flipH(){
	fliph++;
	fliph = fliph % 2;
	previewImageEdit();
}
function resizeImage(){
	resize++;
	resize = resize % 2;
	if(resize){
		$('.image-tool-resize-dimension').slideDown(400);		
	}
	else
	{
		$('.image-tool-resize-dimension').slideUp(400);			
	}
}
function about(){
var html = ''+
'<table width="100%" border="0" cellpadding="0" cellspacing="0" class="dialog-table">'+
'<tr><td width="40%">Module Name</td><td>Kams File Manager</td></tr>'+
'<tr><td>Version</td><td>2.0</td></tr>'+
'<tr><td>Developer</td><td><a href="http://www.kamshory.com" target="_blank">Kamshory Developer</a></td></tr>'+
'<tr><td>Creation Date</td><td>2012-10-20</td></tr>'+
'<tr><td>License</td><td>GNU Public License</td></tr>'+
'<tr><td>Price</td><td>0 USD</td></tr>'+
'<tr><td>Sponsor</td><td><a href="http://www.planetbiru.com" target="_blank">Planet Biru Social Network</a></td></tr>'+
'</table>';
overlayDialog(html, 320, 150);
}

function preventSelect(url){
	skipondrop = true;
}

function initDropable(){
$('.file-list .row-data-dir').draggable({drag: function() {
	preventSelect($(this).attr('data-file-url'));
	$(this).css({'z-index':400,'opacity':0.8});
}});
$('.file-list .row-data-file').draggable({drag: function() {
	preventSelect($(this).attr('data-file-url'));
	$(this).css({'z-index':400,'opacity':0.8});
}});
$('.file-list .row-data-dir').droppable(
{
	activeClass:"directory-drop-active",
	hoverClass:"directory-drop-hover",
	drop: function(event, ui) 
	{
		var curlocation = ui.draggable.attr('data-file-location')+'/'+ui.draggable.attr('data-file-name');
		var targetdir = $(this).attr('data-file-location')+'/'+$(this).attr('data-file-name');
		var args = 'targetdir='+encodeURIComponent(targetdir);
		args+='&file[]='+encodeURIComponent(curlocation);
		var q = '?option=copyfile&deletesource=1';
		$.post('tool-file-operation.php'+q, {'postdata':args}, function(answer){
			if(answer=='SUCCESS' || answer=='EXIST')
			{
				openDir();
			}
			else if(answer=='READONLY')
			{
				jqAlert('The operation was disabled on read only mode.', 'Read Only');
			}
		});
		skipondrop = true;
		ui.draggable.hide('scale', {percent:0}, 300, function(){ui.draggable.css('display', 'none');openDir();});
		return false;
	}
});
}
function loadAnimationStart()
{
	$('#anim-loader').addClass('anim-active');
}
function loadAnimationStop()
{
	$('#anim-loader').removeClass('anim-active');
}

function openDir(filepath, selfile)
{
if(!skipondrop)
{
	loadAnimationStart();
	var ret = true;
	if(!filepath)
	{
		filepath = $('#address').val();
		ret = false;
	}
	else
	{
		filepath = filepath.trim('/');
	}
	$('#address').val(filepath);
	var arg = {};
	if(togglethumb)
	{
		arg = {'dir':filepath, 'thumbnail':1};
	}
	else
	{
		arg = {'dir':filepath};
	}
	$.get('tool-load-file.php', arg, function(answer){
	$('#file-container').html(answer);
	// restore selected file
	try{
	if(selfile.length){
		var fn = '';
		$('.fileid').each(function(index){
			fn = $(this).val();
			if(inArray(fn, selfile))
			{
				$(this).attr('checked', 'checked');
			}
		});
	}
	}
	catch(e){}
	initContextMenuFile();
	initContextMenuDir();
	setCheckRelation();
	initDropable();
	loadAnimationStop();
	});	
	var pth = '';
	$.get('tool-load-dir.php', {'seldir':filepath}, function(answer){
		$('.dir-control').each(function(index){
		pth = $(this).attr('data-file-location')+'/'+$(this).attr('data-file-name');
		if(pth[pth.length]=='/') pth = pth.substr(0, pth.length-1);
		if(pth[0]=='/') pth = pth.substr(1);
		if(filepath==pth)
		{
			$(this).children('ul').remove();
			$(this).append(answer);
		}
		});
	});
	return ret;
}
skipondrop = false;
$('.row-data-dir').css({'left':'0px','top':'0px','z-index':0,'opacity':1});
$('.row-data-file').css({'left':'0px','top':'0px','z-index':0,'opacity':1});
}

function selectFile(url){
if(!skipondrop)
{
	selectFileIndex(url);
}
skipondrop = false;
$('.row-data-dir').css({'left':'0px','top':'0px','z-index':0,'opacity':1});
$('.row-data-file').css({'left':'0px','top':'0px','z-index':0,'opacity':1});
}