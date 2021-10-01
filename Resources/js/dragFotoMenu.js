var cambio = false;
var valPrima;
var click = false;

$(document).ready(function(){
	let fileListEmpty = document.getElementById('lab1').files;
	
	let dropzone = document.getElementById('dropzone1');
	let lab = document.getElementById('lab1');
	let xSign = document.getElementById('sign1');
	
	dropzone.ondragover = function(){
		DataTransfer.dropEffect = 'copy';
		
		if(this.className !== 'dropzone full'){
			this.className = 'dropzone dragover';
		}
		return false;
	};

	dropzone.ondragleave = function(){
		if(this.className !== 'dropzone full'){
			this.className = 'dropzone';
		}
		return false;
	};

	dropzone.ondrop = function(e){
		e.preventDefault();
		
		this.className = 'dropzone';		
		let fotoDrag = e.dataTransfer.files;			
		mostraDrag(fotoDrag);
	};
		
	lab.onchange = function(){
		if(cambio === false){
			$('#dropzone1').attr('class','dropzone');
			let valore;
			
			if(this.files.length === fileListEmpty.length){
				valore = valPrima;
			}
			else{
				valore = this.files;
				cambio = true;
				this.files = fileListEmpty;
				cambio = false;					
			}				
			mostraDrag(valore);
		}		
	};
	
	lab.onclick = function(e){
		if(click === true){
			e.preventDefault();
			click = false;
		}
		else{				
			valPrima = this.files;
		}
	};
	
	xSign.onclick = function(){
		click = true;		
		
		$('#sign1').css('display','none');
		$('#dropzone1').attr('class','dropzone');
		$('#dropzone1').css('backgroundImage','url()');
		cambio = true;
		document.getElementById('lab1').files = fileListEmpty;
		cambio = false;
	};
	
	xSign.onmouseover = function(){
		this.style.border = '2px solid grey';
	};
	
	xSign.onmouseleave = function(){
		this.style.border = '0px solid grey';
	};
});

function mostraDrag(foto){
	let formData = new FormData();
	formData.append('file[]', foto[0]);
	
	$.ajax({
		url: 'Resources/php/esitoDragFoto.php', method: 'POST', data: formData, processData: false, contentType: false, cache: false, success:
		
		function(response){
			let inputDrag = document.getElementById('lab1');

			if(response === 'errorType'){
				$('#redFoto').css('background-color','red');

				if(inputDrag.files.length > 0){
					$('#dropzone1').attr('class','dropzone full');
				}
			}
			else{				
				$('#dropzone1').css('background-image','url(data:image;base64,'+response+')');
				$('#dropzone1').attr('class','dropzone full');
				
				$('#sign1').css('display','block');						
				
				$('#redFoto').css('background-color','white');
				
				cambio = true;
				inputDrag.files = foto;
				cambio = false;						
			}
		}
	});
}