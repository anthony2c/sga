<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/session/sessionmanager.php");
	
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
						if(isset($_GET['courseid']) and isset($_GET['contextid']) and isset($_GET['groupname']) and isset($_GET['careerid']) and isset($_GET['period']))
						{
							require_once($_SERVER["DOCUMENT_ROOT"] . "/moodle/moodlelib.php");
							require_once($_SERVER["DOCUMENT_ROOT"] . "/sga/sgalib.php");
	
							$period = $_GET['period'];							
							$userid = $_GLOBALS['sesion']->userid;
							$courseid = $_GET['courseid'];
							$contextid = $_GET['contextid'];
							$groupname = $_GET['groupname'];
							$careerid = $_GET['careerid'];
							
							try
							{
								$moodle = new Moodle();
			
								$alumnos = $moodle->ObtenerAlumnosPorCursoGrupo($courseid, $contextid, $userid, $groupname);

								if($alumnos !== false)
								{
				?>
									<form class="listaAlumnos" action="saveassists.php" enctype="application/x-www-form-urlencoded" method="post">
										Fecha<input type="date" placeholder="Selecciona la fecha" title="Selecciona la fecha" name="fechaPaseLista"/>
										<input type="hidden" name="periodo" value="<?php echo $period; ?>" />
										<input type="hidden" name="nu_curso" value="<?php echo $courseid; ?>" />
										<input type="hidden" name="nu_contexto" value="<?php echo $contextid; ?>" />
										<input type="hidden" name="nombregrupo" value="<?php echo $groupname; ?>" />
										<input type="hidden" name="nu_carrera" value="<?php echo $careerid; ?>" />
										<table>
											<tr>
												<th>Alumno</th>
												<th>Asistencia</th>
											</tr>
						<?php
											$i = 1;
											while($alumnos->NextByName())
											{
						?>					
												<tr>
													<td><?php echo $i++; ?>
															<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/student.php?contextid=<?php echo $contextid; ?>&courseid=<?php echo $courseid; ?>&student=<?php echo $alumnos->student; ?>&groupname=<?php echo $groupname; ?>&careerid=<?php echo $careerid; ?>&period=<?php echo $period; ?>"><?php echo htmlentities($alumnos->fullname); ?></a>
													</td>
													<td title="<?php echo htmlentities($alumnos->fullname); ?>" style="text-align: center;" >
														<input type="hidden" name="alumno<?php echo $alumnos->student; ?>" value="<?php echo $alumnos->student; ?>" />
														<input type="checkbox" name="asistio<?php echo $alumnos->student; ?>" />
													</td>
												</tr>
						<?php
											}
						?>
										</table>
										<div class="contenedorGuardar">
											<input type="submit" class="submit button" name="submit" value="Guardar" />
											<input type="reset" class="reset button" name="reset" value="Cancelar" />											
										</div>
									</form>
				<?php
								}
							}
							catch(Exception $ex)
							{
								$message = $ex->getMessage();
								$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
								echo "$message";
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