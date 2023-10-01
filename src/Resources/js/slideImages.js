var arrayFoto = new Array(4);
var pos = 0;

function valori(...pars){
	arrayFoto = pars;
}

function cambiaFoto(posizione){
	if (posizione === "avanti" && arrayFoto[0] !== ''){
		pos = ++pos % 4;

		if(arrayFoto[pos] === ''){
			pos = 0;
		}
	}
	else if (posizione === "indietro" && arrayFoto[0] !== ''){
		pos = (--pos >= 0) ? pos % 4 : 3;

		while (arrayFoto[pos] === ''){
			pos--;
		}
	}
	$('#slide').html("<img style='height: 360px; width: 540px; background-size: cover; padding: 5px;' src='data:image;base64,"+arrayFoto[pos]+"'></img>");
}