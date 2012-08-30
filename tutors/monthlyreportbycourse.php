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
	
							$config_tutorias = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/sgc.conf");
							$config_moodle = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/moodle.conf");
						
							$userid = $_GLOBALS['sesion']->userid;
							$period = isset($_GET['period']) ? $_GET['period']: $config_tutorias->currentperiod;
							$careerid = 3;
														
							echo "Periodo: $period";
							
							$sql_alumnos = "select periodo, nu_carrera, nu_alumno, count(nu_semana) as num_semana
										from informes_docentes
										where periodo = '$period'
											and nu_carrera = $careerid
										group by periodo, nu_carrera, nu_alumno";
													
							$con_tutorias = new Conexion($config_tutorias->hostname, $config_tutorias->database, $config_tutorias->username, $config_tutorias->password);
							$con_moodle = new Conexion($config_moodle->hostname, $config_moodle->database, $config_moodle->username, $config_moodle->password);
										
							try
							{
								$con_tutorias->Open();
								$con_moodle->Open();
								$query = new Command($con_tutorias);
								$query->setCommand($sql_alumnos);
								$count_alumnos = $query->ExecuteQuery();
								$reader = new Reader($query->getResult());
								
								$cuenta_alumnos = 0;
															
								if($count_alumnos > 0)
								{
									echo "<table>";
									while($reader->NextByName())
									{
										$color = $cuenta_alumnos % 2 == 0 ? $config_tutorias->color_alumno_par: $config_tutorias->color_alumno_impar; 
										$sql_semanas = "select nu_semana
														from informes_docentes
														where periodo = '$reader->periodo'
															and nu_carrera = $reader->nu_carrera
															and nu_alumno = $reader->nu_alumno												
														group by nu_semana";
																	
										$query_semanas = new Command($con_tutorias);
										$query_semanas->setCommand($sql_semanas);
										$count_semanas = $query_semanas->ExecuteQuery();
										$reader_semanas = new Reader($query_semanas->getResult());
										
										if($count_semanas > 0)
										{
											$cuenta_semanas = 0;
											echo "<tr>";
											
											$sql_alumno = 	"select upper(concat(firstname, ' ', lastname)) as studentname
															from mdl_user
															where id = $reader->nu_alumno";
															
											$query_alumno = new Command($con_moodle);
											$query_alumno->setCommand($sql_alumno);
											$count_alumno = $query_alumno->ExecuteQuery();
											$reader_alumno = new Reader($query_alumno->getResult());
											$reader_alumno->NextByName();

											echo "<td rowspan='$reader->num_semana' colspan='1'><h2>" . htmlentities($reader_alumno->studentname) . "</h2></td>\n";
											while($reader_semanas->NextByName())
											{
												$sql_materias = "select nu_materia, nu_contexto, nu_docente, nombregrupo,
																	reprobacion, inasistencia, indisciplina, no_entrega_trabajo, 
																	apoyo_psicologico, apoyo_economico, observaciones 
																from informes_docentes
																where periodo = '$reader->periodo'
																	and nu_carrera = $reader->nu_carrera
																	and nu_alumno = $reader->nu_alumno
																	and nu_semana = $reader_semanas->nu_semana";
												$query_materias = new Command($con_tutorias);
												$query_materias->setCommand($sql_materias);
												$count_materias = $query_materias->ExecuteQuery();
												$reader_materias = new Reader($query_materias->getResult());
												if($count_materias > 0)
												{
													$reader_materias->NextByName();
													$color = $cuenta_semanas % 2 == 0 ? $config_tutorias->color_semana_par: $config_tutorias->color_semana_impar; 

													$sql_materia = 	"select upper(fullname) as coursename
																	from mdl_course
																	where id = $reader_materias->nu_materia";
																	
													$query_materia = new Command($con_moodle);
													$query_materia->setCommand($sql_materia);
													$count_materia = $query_materia->ExecuteQuery();
													$reader_materia = new Reader($query_materia->getResult());
													$reader_materia->NextByName();
													echo "<td rowspan='$count_materias' colspan='1' style='width: 10%; background-color: $color;'>Semana " . htmlentities($reader_semanas->nu_semana) . "</td>\n";
													echo "<td valign='middle' style='width: 20%; background-color: $color;'>" . htmlentities($reader_materia->coursename) . "</td>\n";
													echo "<td valign='middle' style='width: 10%; background-color: $color;'>Grupo: " . htmlentities($reader_materias->nombregrupo) . "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$check = $reader_materias->reprobacion == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$check = $reader_materias->indisciplina == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$check = $reader_materias->inasistencia == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$check = $reader_materias->no_entrega_trabajo == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$check = $reader_materias->apoyo_psicologico == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$check = $reader_materias->apoyo_economico == 1 ? "checked": "";
													echo "<input type='checkbox' class='checkbox' $check/>"; 
													echo "</td>\n";
													echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
													$observa = strlen($reader_materias->observaciones) > 0 ? "value='$reader_materias->observaciones'": "";
													echo "<input type='text' class='text' $observa />"; 
													echo "</td>\n";
													
													echo "</tr>";
													$cuenta_materias = 0;
													while($reader_materias->NextByName())
													{
														$color = $cuenta_materias % 2 == 0 ? $config_tutorias->color_materia_par: $config_tutorias->color_materia_impar; 
														$sql_materia = 	"select upper(fullname) as coursename
																		from mdl_course
																		where id = $reader_materias->nu_materia";
																		
														$query_materia = new Command($con_moodle);
														$query_materia->setCommand($sql_materia);
														$count_materia = $query_materia->ExecuteQuery();
														$reader_materia = new Reader($query_materia->getResult());
														$reader_materia->NextByName();
														echo "<tr>";
//														echo "<td rowspan='$count_materias' colspan='1' style='width: 10%; background-color: $color;'>Semana " . htmlentities($reader_semanas->nu_semana) . "</td>\n";
														echo "<td valign='middle' style='width: 20%; background-color: $color;'>" . htmlentities($reader_materia->coursename) . "</td>\n";
														echo "<td valign='middle' style='width: 10%; background-color: $color;'>Grupo: " . htmlentities($reader_materias->nombregrupo) . "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$check = $reader_materias->reprobacion == 1 ? "checked": "";
														echo "<input type='checkbox' class='checkbox' $check/>"; 
														echo "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$check = $reader_materias->indisciplina == 1 ? "checked": "";
														echo "<input type='checkbox' class='checkbox' $check/>"; 
														echo "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$check = $reader_materias->inasistencia == 1 ? "checked": "";
														echo "<input type='checkbox' class='checkbox' $check/>"; 
														echo "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$check = $reader_materias->no_entrega_trabajo == 1 ? "checked": "";
														echo "<input type='checkbox' class='checkbox' $check/>"; 
														echo "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$check = $reader_materias->apoyo_psicologico == 1 ? "checked": "";
														echo "<input type='checkbox' class='checkbox' $check/>"; 
														echo "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$check = $reader_materias->apoyo_economico == 1 ? "checked": "";
														echo "<input type='checkbox' class='checkbox' $check/>"; 
														echo "</td>\n";
														echo "<td valign='middle' style='width: 5%; background-color: $color;'>\n";
														$observa = strlen($reader_materias->observaciones) > 0 ? "value='$reader_materias->observaciones'": "";
														echo "<input type='text' class='text' $observa />"; 
														echo "</td>\n";
														echo "</tr>";
														$cuenta_materias++;
													}
												}
												else
												{
													echo "</tr>";
													
												}
												$cuenta_semanas++;
											}
										}
										$cuenta_alumnos++;
									}
									//$con_tutorias->Close();
									echo "</table>";
								}
								$con_tutorias->Close();
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
							<p><a href= "http://<?php echo $_SERVER['SERVER_NAME']; ?>">Regresar</a></p>
					<?php
						}
					}
					else
					{
						$layout->RedireccionarSGA("/");
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