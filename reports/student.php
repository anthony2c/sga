<?php
	include_once($_SERVER["DOCUMENT_ROOT"] . "/lib/session/sessionmanager.php");
	
	if($_GLOBALS['sesion']->expireSession() == true)
	{
		echo "session destruida<br>";
	}
	require_once ($_SERVER["DOCUMENT_ROOT"] . "/layout/layout.php");
	$layout = new Layout();
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title><?php echo $layout->getSiteName(); ?></title>
		<meta name="description" content="Lista de grupos por docente" />
		<meta name="author" content="Francisco Salvador Ballina Sánchez" />
		<link rel="stylesheet" href="<?php echo $layout->ObtenerHojaDeEstilo(); ?>" media="screen" />
	</head>
	<body>
	<?php		
		$layout->getHeader($_GLOBALS['sesion']->userid, $_GLOBALS['sesion']->role, $_GLOBALS['sesion']->roleTutor, $_GLOBALS['sesion']->roleRootSGC);
	?>
		<div class="contenedorPrincipal">
			<div class="infocontainer">
			<?php
					if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid))
					{
						if(isset($_GET['courseid']) and isset($_GET['student']) 
							and isset($_GET['contextid']) and isset($_GET['group']) 
							and isset($_GET['period']))
						{
							$nu_periodo = $_POST['period'];
							$nu_docente = $_GLOBALS['sesion']->userid;
							$nu_curso = $_POST['courseid'];
							$nu_contexto = $_POST['contextid'];
							$nu_grupo = $_POST['group'];
							$nu_carrera = $_POST['careerid'];
							$nu_alumno = $_POST['student'];
			?>
							<h1>Detalles de alumno</h1>
							<form action="save.php" method="post">
								<input type="hidden" name="nu_periodo" value="<?php echo $nu_periodo; ?>" />
								<input type="hidden" name="nu_docente" value="<?php echo $nu_docente; ?>" />
								<input type="hidden" name="nu_curso" value="<?php echo $nu_curso; ?>" />
								<input type="hidden" name="nu_contexto" value="<?php echo $nu_contexto; ?>" />
								<input type="hidden" name="nu_grupo" value="<?php echo $nu_grupo; ?>" />
								<input type="hidden" name="nu_carrera" value="<?php echo $nu_carrera; ?>" />
								<input type="hidden" name="nu_alumno" value="<?php echo $nu_alumno; ?>" />
								<table>
									<tr>
										<td><p>Reprobaci&oacute;n (Bajo rendimiento): <input type="checkbox" class="checkbox" name="reprobacion<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
									<tr>
										<td><p>Inasistencia: <input type="checkbox" class="checkbox" name="inasistencia<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
									<tr>
										<td><p>Indisciplina: <input type="checkbox" class="checkbox" name="indisciplina<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
									<tr>
										<td><p>No entrego trabajos/Practicas: <input type="checkbox" class="checkbox" name="notrabajos<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
									<tr>
										<td><p>Requiere apoyo psicol&oacute;gico: <input type="checkbox" class="checkbox" name="apoyopsico<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
									<tr>
										<td><p>Requiere apoyo econ&oacute;mico (Beca): <input type="checkbox" class="checkbox" name="apoyoecono<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
									<tr>
										<td><p>Otro: <input type="checkbox" class="checkbox" name="otro" /> Anotar: <input type="text" class="text" name="razones<?php echo $nu_alumno; ?>" /></p></td>
									</tr>
								</table>
								<div class="contenedorGuardar">
									<input type="submit" class="button" name="submit" value="Guardar" />
									<input type="reset" class="reset button" name="reset" value="Cancelar" />
								</div>
							</form>
			<?php
						}
					}
					else
					{
						$layout->RedireccionarSGA("/");
					}

					echo $layout->generarBotonRegresar("Regresar...");
			?>
			</div>
		</div>
		<footer>
			<p>
				&copy; Copyright  by <?php echo $layout->getPowerBy(); 		unset($layout); ?>
			</p>
		</footer>
	</body>
</html>