function navShow(_class){
	let navClass = document.getElementsByClassName(_class);
	
	if(navClass[0].style.visibility !== 'hidden'){
		changeElementsState(navClass, 'hidden', 'none', _class, '+');
	}
	else{
		changeElementsState(navClass, 'visible', 'inline', _class, '-');
	}
}

function changeElementsState(navClass, _visibility, _display, _class, sign) {
	for(let c = 0; c < navClass.length; c += 2){
		navClass[c].style.visibility = _visibility;
		navClass[c+1].style.display = _display;
	}
	$('#'+_class).html(sign);
}

function filtro(_tipo){
	let tipo = document.getElementById(_tipo);
	let tipoArr = document.getElementsByClassName(_tipo);
	
	for(let a = 0; a < tipoArr.length; a++){
		tipoArr[a].style.display = (tipo.checked === false) ? 'none' : '';
	}
}