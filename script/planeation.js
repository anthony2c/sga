/**
 * @author Francisco Salvador Ballina Sánchez
 */

function VerDetalleActividadAprendizaje()
{
	var seleccion = document.getElementById("actividadesAprendizaje").selectedIndex;
	var texto = document.getElementById("actividadesAprendizaje").options[seleccion].text;
	
	alert(texto);
}

function VerDetalleActividadEnsenanza()
{
	var seleccion = document.getElementById("actividadesEnsenanza").selectedIndex;
	var texto = document.getElementById("actividadesEnsenanza").options[seleccion].text;
	
	alert(texto);
}
  