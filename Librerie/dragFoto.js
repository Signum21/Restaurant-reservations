var cambio = false;
var valPrima;
var ci = false;

$(document).ready(function()
{
	"use strict";
	var fileListEmpty = document.getElementById('lab4').files;
	
	for(var a = 1; a<=4; a++)
	{
		var dropzone = document.getElementById('dropzone'+a);
		var lab = document.getElementById('lab'+a);
		var sign = document.getElementById('sign'+a);
		
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
				var subId = this.id.substring(3, 4);
				$('#dropzone'+subId).attr('class','dropzone');
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
			if(ci === true)
			{
				e.preventDefault();
				ci = false;
			}
			else
			{				
				valPrima = this.files;
			}
		};
		
		sign.onclick = function()
		{
			ci = true;
			var subIdString = this.id.substring(4, 5);
			var subId = parseInt(subIdString);			
			
			for(var a = subId; a <= 4; a++)
			{
				if(a !== 4)
				{
					if($('#sign'+(1+a)).css('display') === 'block')
					{
						var img = $('#dropzone'+(1+a)).css('backgroundImage');
						$('#dropzone'+a).css('backgroundImage',img);
					
						var file = document.getElementById('lab'+(1+a)).files;
						cambio = true;
						document.getElementById('lab'+a).files = file;
						cambio = false;
					}
					else
					{
						$('#sign'+a).css('display','none');
						$('#dropzone'+a).attr('class','dropzone');
						$('#dropzone'+a).css('backgroundImage','url()');
						cambio = true;
						document.getElementById('lab'+a).files = fileListEmpty;
						cambio = false;
						break;
					}
				}
				else
				{
					$('#sign4').css('display','none');
					$('#dropzone4').attr('class','dropzone');
					$('#dropzone4').css('backgroundImage','url()');
					cambio = true;
					document.getElementById('lab4').files = fileListEmpty;
					cambio = false;
				}
			}
		};
		
		sign.onmouseover = function()
		{
			this.style.border = '2px solid grey';
		};
		
		sign.onmouseleave = function()
		{
			this.style.border = '0px solid grey';
		};
	}
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
				$('#checkType').html("<img src='Immagini/warning piccolo.png' style='vertical-align:top'> Puoi inserire solo immagini");
			}
			else
			{
				var labDrag = $('.dropzone');
				var inputDrag = $('.inputfile');
				
				for(var b = 0; b<labDrag.length; b++)
				{
					if(labDrag[b].className === 'dropzone')
					{
						labDrag[b].style.backgroundImage = 'url(data:image;base64,'+response+')';
						labDrag[b].className = 'dropzone full';
						
						var c = b + 1;
						$('#sign'+c).css('display','block');						
												
						cambio = true;
						inputDrag[b].files = foto;
						cambio = false;
						
						break;
					}
				}						
			}
		}
	});
}