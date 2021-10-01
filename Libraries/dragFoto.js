var cambio = false;
var valPrima;
var ci = false;

$(document).ready(function(){
	let fileListEmpty = document.getElementById('lab4').files;
	
	for(let a = 1; a<=4; a++){
		let dropzone = document.getElementById('dropzone'+a);
		let lab = document.getElementById('lab'+a);
		let xSign = document.getElementById('sign'+a);
		
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
				let subId = this.id.substring(3, 4);
				$('#dropzone'+subId).attr('class','dropzone');
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
			if(ci === true){
				e.preventDefault();
				ci = false;
			}
			else{				
				valPrima = this.files;
			}
		};
		
		xSign.onclick = function(){
			ci = true;
			let subIdString = this.id.substring(4, 5);
			let subId = parseInt(subIdString);			
			
			for(let a = subId; a <= 4; a++){
				if(a !== 4){
					if($('#sign'+(1+a)).css('display') === 'block'){
						let img = $('#dropzone'+(1+a)).css('backgroundImage');
						$('#dropzone'+a).css('backgroundImage',img);
					
						let file = document.getElementById('lab'+(1+a)).files;
						cambio = true;
						document.getElementById('lab'+a).files = file;
						cambio = false;
					}
					else{
						$('#sign'+a).css('display','none');
						$('#dropzone'+a).attr('class','dropzone');
						$('#dropzone'+a).css('backgroundImage','url()');
						cambio = true;
						document.getElementById('lab'+a).files = fileListEmpty;
						cambio = false;
						break;
					}
				}
				else{
					$('#sign4').css('display','none');
					$('#dropzone4').attr('class','dropzone');
					$('#dropzone4').css('backgroundImage','url()');
					cambio = true;
					document.getElementById('lab4').files = fileListEmpty;
					cambio = false;
				}
			}
		};
		
		xSign.onmouseover = function(){
			this.style.border = '2px solid grey';
		};
		
		xSign.onmouseleave = function(){
			this.style.border = '0px solid grey';
		};
	}
});

function mostraDrag(foto){
	let formData = new FormData();
	formData.append('file[]', foto[0]);
	
	$.ajax({
		url: 'esitoDragFoto.php', method: 'POST', data: formData, processData: false, contentType: false, cache: false, success:
		
		function(response){
			let labDrag = $('.dropzone');
			let inputDrag = $('.inputfile');

			if(response === 'errorType'){
				$('#checkType').html("<img src='Images/warning piccolo.png' style='vertical-align:top'> Puoi inserire solo immagini");

				for(let b = 0; b < labDrag.length; b++){
					if(inputDrag[b].files.length > 0){
						labDrag[b].className = 'dropzone full';
					}
				}
			}
			else{				
				for(let b = 0; b < labDrag.length; b++){
					if(labDrag[b].className === 'dropzone'){
						labDrag[b].style.backgroundImage = 'url(data:image;base64,'+response+')';
						labDrag[b].className = 'dropzone full';
						
						let c = b + 1;
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