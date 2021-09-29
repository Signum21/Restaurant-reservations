var cambio = false;
var valPrima;
var click = false;

$(document).ready(function()
{
	"use strict";
	var fileListEmpty = document.getElementById('lab1').files;
	
	var dropzone = document.getElementById('dropzone1');
	var lab = document.getElementById('lab1');
	var sign = document.getElementById('sign1');
	
	dropzone.ondragover = function()
	{
		event.dataTransfer.dropEffect = 'copy';
		
		if(this.className !== 'dropzone full')
		{
			this.className = 'dropzone dragover';
		}
		return false;
	};

	dropzone.ondragleave = function()
	{
		if(this.className !== 'dropzone full')
		{
			this.className = 'dropzone';
		}
		return false;
	};

	dropzone.ondrop = function(e)
	{
		e.preventDefault();
		
		this.className = 'dropzone';
		
		var fotoDrag = e.dataTransfer.files;			
		mostraDrag(fotoDrag);
	};
		
	lab.onchange = function()
	{
		if(cambio === false)
		{
			$('#dropzone1').attr('class','dropzone');
			var valore;
			
			if(this.files.length === fileListEmpty.length)
			{
				valore = valPrima;
			}
			else
			{
				valore = this.files;
				cambio = true;
				this.files = fileListEmpty;
				cambio = false;					
			}				
			mostraDrag(valore);
		}		
	};
	
	lab.onclick = function(e)
	{
		if(click === true)
		{
			e.preventDefault();
			click = false;
		}
		else
		{				
			valPrima = this.files;
		}
	};
	
	sign.onclick = function()
	{
		click = true;		
		
		$('#sign1').css('display','none');
		$('#dropzone1').attr('class','dropzone');
		$('#dropzone1').css('backgroundImage','url()');
		cambio = true;
		document.getElementById('lab1').files = fileListEmpty;
		cambio = false;
	};
	
	sign.onmouseover = function()
	{
		this.style.border = '2px solid grey';
	};
	
	sign.onmouseleave = function()
	{
		this.style.border = '0px solid grey';
	};
});

function mostraDrag(foto)
{
	"use strict";
	var formData = new FormData();
	formData.append('file[]', foto[0]);
	
	$.ajax
	({
		url: 'esitoDragFoto.php', method: 'POST', data: formData, processData: false, contentType: false, cache: false, success:
		
		function(response)
		{
			if(response === 'errorType')
			{
				$('#redFoto').css('background-color','red');
			}
			else
			{				
				$('#dropzone1').css('background-image','url(data:image;base64,'+response+')');
				$('#dropzone1').attr('class','dropzone full');
				
				$('#sign1').css('display','block');						
				
				$('#redFoto').css('background-color','white');
				
				cambio = true;
				var inputDrag = document.getElementById('lab1');
				inputDrag.files = foto;
				cambio = false;						
			}
		}
	});
}