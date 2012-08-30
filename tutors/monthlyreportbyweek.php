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
		<meta name="description" content="Inicio para el Sistema de Gestión del Curso" />
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
					if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid) and isset($_GLOBALS['sesion']->role))
					{
						if($_GLOBALS['sesion']->roleTutor == 'tutor')
						{
							include_once($_SERVER["DOCUMENT_ROOT"] . "/connection/connection.php");
							include_once($_SERVER["DOCUMENT_ROOT"] . "/configuration/configuration.php");
							include_once($_SERVER["DOCUMENT_ROOT"] . "/moodle/moodlelib.php");
	
							$config_tutorias = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/sgc.conf");
							$moodle = new Moodle();
						
							$userid = $_GLOBALS['sesion']->userid;
							$period = isset($_GET['period']) ? $_GET['period']: $config_tutorias->currentperiod;
							$careerid = 3;
														
							echo "Periodo: $period";
							
							$con_tutorias = new Conexion($config_tutorias->hostname, $config_tutorias->database, $config_tutorias->username, $config_tutorias->password);
									
							try
							{
								$con_tutorias->Open();
							?>
								<div class="listaAlumnos">
									<table>
										<tbody>
							<?
								echo "<th style='width: 10%; background-color: $config_tutorias->color_encabezado;'>Alumno</th>\n";
								for($i = 1; $i < 17; $i++)
								{
									echo "<th rowspan='1' colspan='9' style='width: 15%;'>Semana $i</th>\n";												
								}
								echo "</tr>\n";
								$sql_alumnos = "select periodo, nu_carrera, nu_alumno, count(*) as num_materias
												from (
													select periodo, nu_carrera, nu_alumno, nu_materia
													from informes_docentes
													group by periodo, nu_carrera, nu_alumno, nu_materia
												) as r
												group by periodo, nu_carrera, nu_alumno";
								
								$query_alumnos = new Command($con_tutorias);
								$query_alumnos->setCommand($sql_alumnos);
								$count_alumnos = $query_alumnos->ExecuteQuery();
								$reader_alumnos = new Reader($query_alumnos->getResult());
								
								if($count_alumnos > 0)
								{
									while($reader_alumnos->NextByName())
									{
										$sql_materias = "select periodo, nu_carrera, nu_alumno, nu_materia
														from informes_docentes
														where periodo = '$reader_alumnos->periodo'
															and nu_carrera = $reader_alumnos->nu_carrera
															and nu_alumno = $reader_alumnos->nu_alumno
														group by periodo, nu_carrera, nu_alumno, nu_materia";
														
										echo "<tr>\n";
										echo "<td rowspan='$reader_alumnos->num_materias' colspan='1'>" . $moodle->NombreUsuario($reader_alumnos->nu_alumno) . "</td>\n";
										
										$sql_materias = "select periodo, nu_carrera, nu_alumno, nu_materia, nu_contexto, nu_docente, nombregrupo
														from informes_docentes
														where periodo = '$reader_alumnos->periodo'
															and nu_carrera = $reader_alumnos->nu_carrera
															and nu_alumno = $reader_alumnos->nu_alumno
														group by periodo, nu_carrera, nu_alumno, nu_materia, nu_contexto, nu_docente, nombregrupo";
										
										$query_materias = new Command($con_tutorias);
										$query_materias->setCommand($sql_materias);
										$count_materias = $query_materias->ExecuteQuery();
										$reader_materias = new Reader($query_materias->getResult());
										
										
										while($reader_materias->NextByName())
										{
											$sql_evidencias = "select nu_semana, reprobacion, inasistencia, indisciplina, no_entrega_trabajo, 
																	apoyo_psicologico, apoyo_economico, observaciones
															from informes_docentes
															where periodo = '$reader_alumnos->periodo'
																and nu_carrera = $reader_alumnos->nu_carrera
																and nu_alumno = $reader_alumnos->nu_alumno
																and nu_materia = $reader_materias->nu_materia
																and nu_contexto = $reader_materias->nu_contexto
																and nombregrupo = '$reader_materias->nombregrupo'
															group by nu_semana";
											
											$query_evidencias = new Command($con_tutorias);
											$query_evidencias->setCommand($sql_evidencias);
											$count_evidencias = $query_evidencias->ExecuteQuery();
											$reader_evidencias = new Reader($query_evidencias->getResult());
											
											if($count_evidencias > 0)
											{
												if($reader_evidencias->nu_semana > 1)
													echo "<tr>\n";
												while($reader_evidencias->NextByName())
												{
													echo "<td valign='middle' style='width: 20%; background-color: $color;'>" . $moodle->NombreMateria($reader_materias->nu_materia) . "</td>\n";
													echo "<td valign='middle' style='width: 10%; background-color: $color;'>" . htmlentities($reader_materias->nombregrupo) . "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>REP\n";
													$check = $reader_evidencias->reprobacion == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' readonly='readonly' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>IND\n";
													$check = $reader_evidencias->indisciplina == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' readonly='readonly' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>INA\n";
													$check = $reader_evidencias->inasistencia == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' readonly='readonly' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>NOW\n";
													$check = $reader_evidencias->no_entrega_trabajo == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' readonly='readonly' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>APP\n";
													$check = $reader_evidencias->apoyo_psicologico == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' readonly='readonly' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>APE\n";
													$check = $reader_evidencias->apoyo_economico == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' readonly='readonly' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>OBS\n";
													$observa = strlen($reader_evidencias->observaciones) > 0 ? "value='$reader_evidencias->observaciones'": "";
													echo "<input type='text' class='text' readonly='readonly' $observa />"; 
													echo "</td>\n";
												}
												echo "</tr>\n";
											}
										}
										echo "</tr>\n";
									}
										
								}
							?>
										</tbody>
									</table>
								</div> 
							<?php
							}
							catch(Exception $ex)
							{
								$con_tutorias->Close();
								$message = $ex->getMessage();
								$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
								echo "$message";
							}
						}
						else
						{
					?>
							<span style='color:red'>Su rol de usuario no tiene acceso a este m&oacute;dulo</span>
							<p><a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>">Regresar</a></p>
					<?php
						}
					}
					else
					{
						$layout->RedireccionarSGA("/login/index.php?action=login");
					}
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