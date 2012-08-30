<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/session/sessionmanager.php");
	
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
						if(isset($_GET['courseid']) and isset($_GET['contextid']) and isset($_GET['group']) and isset($_GET['careerid']) and isset($_GET['period']))
						{
							require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/moodle.php");

							$period = $_GET['period'];							
							$nu_docente = $_GLOBALS['sesion']->userid;
							$nu_curso = $_GET['courseid'];
							$nu_contexto = $_GET['contextid'];
							$grupo = $_GET['group'];
							$nu_carrera = $_GET['careerid'];
							
							$moodle = new Moodle();
							
							$alumnos = $moodle->obtenerAlumnosPorCursoGrupo($nu_curso, $nu_contexto, $nu_docente, $grupo);
							
							if($alumnos !== false)
							{
							?>
								<table>
									<tr>
										<th style="width: 10%;">Matr&iacute;cula</th>
										<th>Nombre del alumno</th>
									</tr>
							<?php
								$contador = 1;
								while($alumnos->NextByName())
								{
							?>
									<tr>
										<td><?php echo $alumnos->matricula; ?></td>
										<td>
									<?php 
											echo $layout->generarLiga(htmlentities($alumnos->apellidos . ' ' . $alumnos->nombre), "reports/student.php", "contextid=$nu_contexto&courseid=$nu_curso&student=$alumnos->idalumno&group=$grupo&period=$period");
									?>
										</td>
									</tr>
								<?php
								}
							?>
								</table>
							<?php
							}
						}
						else
						{
							echo "no hay datos para procesar";
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