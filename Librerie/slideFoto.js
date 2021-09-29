var arrayFoto = new Array(4);
var pos = 0;

function valori(a,b,c,d)
{
	"use strict";
	
	arrayFoto[0] = a;
	arrayFoto[1] = b;
	arrayFoto[2] = c;
	arrayFoto[3] = d;
}

function cambiaFoto(posizione)
{
	"use strict";
	
	if (posizione === "avanti" && arrayFoto[0] !== '')
	{
		if(pos === 3)
		{
			pos = 0;
		}
		else 
		{ 
			pos++;
			
			while (arrayFoto[pos] === '')
			{
				if(pos === 3)
				{
					pos = 0;
				}
				else { pos++; }
			}
		}		
	}
	else if (posizione === "indietro" && arrayFoto[0] !== '')
	{
		if(pos === 0)
		{
			pos = 3;
			
			while (arrayFoto[pos] === '')
			{
				pos--;
			}
		}
		else { pos--; }
	}
	$('#slide').html("<img style='height: 360px; width: 540px; background-size: cover; padding: 5px;' src='data:image;base64,"+arrayFoto[pos]+"'></img>");
}