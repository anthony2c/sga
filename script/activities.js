function AgregarFecha()
{
	var table = document.getElementById("TablaPrincipal");
	var posicion = table.rows.length;
	var row = table.insertRow(posicion);
	
	var cell1 = row.insertCell(0);
	var cell2 = row.insertCell(1);

	var fecha = document.createElement("input");
	fecha.setAttribute("type", "date");
	fecha.setAttribute("name", "fecha" + posicion);
	fecha.setAttribute("required", "required");
	agregarActividad = document.createElement("input");
	agregarActividad.setAttribute("type", "button");
	agregarActividad.setAttribute("name", "button" + posicion);
	agregarActividad.setAttribute("value", "+");
	agregarActividad.setAttribute("onclick", "AgregarActividad(this)");

	var tableAnidada = document.createElement("table");
	tableAnidada.style.width = "100%";
	tableAnidada.setAttribute("id", "tabla" + posicion)
	var fila = tableAnidada.insertRow(0);
	var celda = fila.insertCell(0);

	var aprendizaje = document.createElement("textarea");

	aprendizaje.setAttribute("class", "actividades");
	
	aprendizaje.setAttribute("name", "aprendizaje" + posicion + "_0");
	var ensenanza = document.createElement("textarea");
	ensenanza.setAttribute("class", "actividades");
	ensenanza.setAttribute("name", "ensenanza" + posicion + "_0");
	var eliminarActividad = document.createElement("input");
	eliminarActividad.setAttribute("type", "button");
	eliminarActividad.setAttribute("value", "-");
	eliminarActividad.setAttribute("name", "eliminarActividad" + posicion + "_0");
	eliminarActividad.setAttribute("onclick", "QuitarActividad(this)");

	celda.appendChild(aprendizaje);
	celda.appendChild(ensenanza);
	celda.appendChild(eliminarActividad);

	cell1.appendChild(fecha);
	cell1.appendChild(agregarActividad);

	cell2.appendChild(tableAnidada);
}

function AgregarActividad(origen)
{
	var nombre = origen.getAttribute("name");
	var posicion = nombre.substring(new String("button").length);
	var nombreTabla = "tabla" + posicion;

	var tabla = document.getElementById(nombreTabla);
	var numero = tabla.rows.length;
	var fila = tabla.insertRow(numero);
	var celda = fila.insertCell(0);

	var aprendizaje = document.createElement("textarea");
	aprendizaje.setAttribute("class", "actividades");
	aprendizaje.setAttribute("name", "aprendizaje" + posicion + "_" + numero);
	var ensenanza = document.createElement("textarea");
	ensenanza.setAttribute("class", "actividades");
	ensenanza.setAttribute("name", "ensenanza" + posicion + "_" + numero);
	var eliminarActividad = document.createElement("input");
	eliminarActividad.setAttribute("type", "button");
	eliminarActividad.setAttribute("value", "-");
	
	eliminarActividad.setAttribute("name", "eliminarActividad" + posicion + "_" + numero);
	eliminarActividad.setAttribute("onclick", "QuitarActividad(this)");

	celda.appendChild(aprendizaje);
	celda.appendChild(ensenanza);
	celda.appendChild(eliminarActividad);
}

function QuitarActividad(origen)
{
	var nombre = origen.getAttribute("name");
	var posicion = nombre.substring(new String("eliminarActividad").length, nombre.indexOf('_'));
	var nombreTabla = "tabla" + posicion;

	var tabla = document.getElementById(nombreTabla);
	var numero = nombre.substring(nombre.indexOf('_') + 1);

	if(numero > 0)
	{
		if(parseInt(numero) + 1 == tabla.rows.length)
			tabla.deleteRow(numero);
		else
			alert("No es posible borrar un actividad cuando existen otras delante de ella. Borre antes las actividades que le suceden")
	}
	else
	{
		if(tabla.rows.length == 1)
		{
			var table = document.getElementById("TablaPrincipal");
			var position = 0;
			position = parseInt(posicion) + 1;
			if(table.rows.length == position)
				table.deleteRow(posicion);
			else
				alert("No es posible borrar un actividad cuando existen otras delante de ella. Borre antes las actividades que le suceden")
		}
		else
			alert("No es posible borrar un actividad cuando existen otras delante de ella. Borre antes las actividades que le suceden")
	}
}

function CrearStringQuery()
{
	var cadena = "";
	var tablaPrincipal = document.getElementById("TablaPrincipal");
	for(var i = 1; i < tablaPrincipal.rows.length; i++)
	{
		if(cadena.length > 0)
			cadena = cadena + "&";
		var celda1 = tablaPrincipal.rows[i].cells[0];
		var fecha = celda1.firstChild;
		cadena = cadena + fecha.getAttribute("name") + "=" + encodeURIComponent(fecha.value);
		
		var tablaAnidada = tablaPrincipal.rows[i].cells[1].firstChild;
		
		for(var j = 0; j < tablaAnidada.rows.length; j++)
		{
			var celdaActividades = tablaAnidada.rows[j].cells[0];
			var aprendizaje = celdaActividades.childNodes[0];
			cadena = cadena + "&" + aprendizaje.getAttribute("name") + "=" + encodeURIComponent(aprendizaje.value);

			var ensenanza = celdaActividades.childNodes[1];
			cadena = cadena + "&" + ensenanza.getAttribute("name") + "=" + encodeURIComponent(ensenanza.value);
		}
	}
	
	return cadena;
}

var peticion = new XMLHttpRequest();
var READY_STATE_COMPLETE = 4;

function EnviarFormulario(url)
{	
	if(peticion)
	{
		peticion.onreadystatechange = ProcesaPeticion;
		peticion.open("POST", url, true);
		peticion.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		
		var cadena = CrearStringQuery();
		peticion.send(cadena);
		
		document.getElementById("formActividades").submit();
 {
 
 }
	}
}

function ProcesaPeticion () 
{
	if(peticion)
	{
		if(peticion.readystate = READY_STATE_COMPLETE)
		{
			if(peticion.status = 200)
			{
				window.location = "ver.php";
			}
		}
	}
}
