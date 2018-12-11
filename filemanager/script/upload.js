(function(){
var input = document.getElementById("images"),
	formdata = false;
function showUploadedItem(source){
	var list = document.getElementById("image-list"),
	li   = document.createElement("li"),
	img  = document.createElement("img");
	img.src = source;
	li.appendChild(img);
	list.appendChild(li);
}   
if(window.FormData){
	formdata = new FormData();
}
else
{
	$(".upload-button").css('display','inline');
}
input.addEventListener("change",function(evt){
	if(window.FormData)
	{
	document.getElementById("response").innerHTML = "Uploading . . ."
	}
	var i = 0,len = this.files.length,img,reader,file;
	for(;i<len;i++)
	{
		file = this.files[i];
		if(!!file.type.match(/image.*/)) 
		{
			if(window.FileReader){
				reader = new FileReader();
				reader.onloadend = function(e){
					showUploadedItem(e.target.result,file.fileName);
				};
				reader.readAsDataURL(file);
			}
			if(formdata){
				formdata.append("images[]",file);
			}
		}
		else
		{
			formdata.append("images[]",file);
		}
	}
	if(formdata){
		var dl = $('#address').val();
		$.ajax({
			url:"tool-upload-file.php?targetdir="+encodeURIComponent(dl),
			type:"POST",
			data:formdata,
			processData:false,
			contentType:false,
			success:function(answer){
			if(answer=='SUCCESS'){
				document.getElementById("response").innerHTML = 'File has been uploaded.'; 
				openDir();
			}
			else if(answer=='READONLY')
			{
				openDir();
				document.getElementById("response").innerHTML = '&nbsp;'; 
				alert('This operation is disabled on read only mode.');
				formdata = new FormData();
			}
			else if(answer=='DENIED')
			{
				openDir();
				document.getElementById("response").innerHTML = '&nbsp;'; 
				alert('Uploading file is forbidden.');
				formdata = new FormData();
			}
			else if(answer=='FORBIDDEN')
			{
				openDir();
				document.getElementById("response").innerHTML = '&nbsp;'; 
				alert('Uploading this type of file is forbidden.');
				formdata = new FormData();
			}
			}
		});
	}
},false);
}());
