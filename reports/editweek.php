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
						if(isset($_GET['courseid']) and isset($_GET['contextid']) and isset($_GET['groupname']) and isset($_GET['careerid']) and isset($_GET['week']) and isset($_GET['period']))
						{
							include_once($_SERVER["DOCUMENT_ROOT"] . "/configuration/configuration.php");
							include_once($_SERVER["DOCUMENT_ROOT"] . "/connection/connection.php");
			
							$config_tutorias = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/sgc.conf");
							$con_tutorias = new Conexion($config_tutorias->hostname, $config_tutorias->database, $config_tutorias->username, $config_tutorias->password);

							$config_moodle = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/moodle.conf");
							$con_moodle = new Conexion($config_moodle->hostname, $config_moodle->database, $config_moodle->username, $config_moodle->password);
							
							$period = $_GET['period'];
							$userid = $_GLOBALS['sesion']->userid;
							$courseid = $_GET['courseid'];
							$contextid = $_GET['contextid'];
							$groupname = $_GET['groupname'];
							$careerid = $_GET['careerid'];
							$week = $_GET['week'];

							$sql_existe = "select * 
									from informes_docentes
									where periodo = '$period'
										and nu_carrera = $careerid
										and nu_docente = $userid
										and nu_materia = $courseid
										and nu_contexto = $contextid
										and nu_semana = $week
										and nombregrupo = '$groupname'";
							
							try
							{
	
								$con_tutorias->Open();
								$query_tutorias = new Command($con_tutorias);
								$query_tutorias->setCommand($sql_existe);
								$count_existe = $query_tutorias->ExecuteQuery();
								
								if($count_existe > 0)
								{
	
									$sql_moodle = "select mdl_user.id as student, upper(concat(lastname, ' ', firstname)) as fullname, mdl_groups.name as groupname
											from mdl_groups_members, mdl_groups, mdl_user, mdl_enrol, mdl_user_enrolments, 
												mdl_course, mdl_role_assignments, mdl_role
											where mdl_role_assignments.roleid = mdl_role.id
												and mdl_role_assignments.userid = mdl_user.id
												and mdl_user.id = mdl_user_enrolments.userid 
												and mdl_user_enrolments.enrolid = mdl_enrol.id 
												and mdl_enrol.courseid = mdl_course.id 
												and mdl_groups_members.groupid = mdl_groups.id 
												and mdl_groups_members.userid = mdl_user.id
												and mdl_role.shortname = 'student'
												and mdl_groups.name = '$groupname'
												and (mdl_course.id) in 
												(
													select mdl_enrol.courseid 
													from mdl_enrol, mdl_user_enrolments , mdl_role, 
														mdl_role_assignments, mdl_context
													where mdl_role.id = mdl_role_assignments.roleid
														and mdl_role_assignments.userid = mdl_user_enrolments.userid
														and mdl_role_assignments.contextid = mdl_context.id
														and mdl_context.instanceid = mdl_enrol.courseid 
														and mdl_user_enrolments.enrolid = mdl_enrol.id 
														and mdl_role.shortname = 'editingteacher'
														and mdl_enrol.courseid = $courseid
														and mdl_context.id = $contextid
														and mdl_user_enrolments.userid = $userid
												)
											group by lastname, firstname, mdl_groups.name, mdl_role.name
											order by lastname, firstname, mdl_groups.name";
									
										$con_moodle->Open();
										$query_moodle = new Command($con_moodle);
										$query_moodle->setCommand($sql_moodle);
										$count_moodle = $query_moodle->ExecuteQuery();
										$reader_moodle = new Reader($query_moodle->getResult());
						?>
										<form action="masssaved.php" method="post">
											<div class="contenedorGuardar">
												<select name="week">
													<?php
																echo "<option value='$week'>Semana $week</option>\n";
													?>
												</select>
												<input type="submit" class="submit button" name="sumbit" value="Guardar" />
												<input type="reset" class="reset button" name="reset" value="Limpiar" />
											</div>
											<input type="hidden" class="hidden" name="careerid" value="<?php echo $careerid; ?>" />
											<input type="hidden" class="hidden" name="courseid" value="<?php echo $courseid; ?>" />
											<input type="hidden" class="hidden" name="contextid" value="<?php echo $contextid; ?>" />
											<input type="hidden" class="hidden" name="groupname" value="<?php echo $groupname; ?>" />
											<input type="hidden" class="hidden" name="period" value="<?php echo $period; ?>" />
											<input type="hidden" class="hidden" name="mode" value="edit" />
					<?php		
									if($count_moodle > 0)
									{
					?>
										<table>
											<tr>
												<th>Alumno</th>
												<th><div class="textoVertical">Reprobado</div></th>
												<th><div class="textoVertical">Inasistencia<div/></th>
												<th><div class="textoVertical">Indisciplina<div/></th>
												<th><div class="textoVertical">No entrega tareas<div/></th>
												<th><div class="textoVertical">Requiere apoyo psicologico<div/></th>
												<th><div class="textoVertical">Requiere apoyo economico<div/></th>
												<th>Otras observaciones</th>											
											</tr>
					<?php
										while($reader_moodle->NextByName())
										{
											$sql_row = "select reprobacion, inasistencia, indisciplina, 
															no_entrega_trabajo, apoyo_psicologico, 
															apoyo_economico, observaciones 
														from informes_docentes
														where periodo = '$period'
															and nu_carrera = $careerid
															and nu_docente = $userid
															and nu_materia = $courseid
															and nu_contexto = $contextid
															and nombregrupo = '$groupname'
															and nu_semana = $week
															and nu_alumno = $reader_moodle->student";
															
											$query_row = new Command($con_tutorias);
											$query_row->setCommand($sql_row);
											$count_row = $query_row->ExecuteQuery();
											$reader_row = new Reader($query_row->getResult());
											$reader_row->NextByName();
											$color = '#e3e6e8';
											
											switch($reader_row->reprobacion + $reader_row->inasistencia + $reader_row->indisciplina + $reader_row->no_entrega_trabajo + $reader_row->apoyo_psicologico + $reader_row->apoyo_economico)
											{
												case 1:
													$color = '#9999ff';
													break;
												case 2:
													$color = '#99ff99';
													break;
												case 3:
													$color = '#ff99ff';
													break;
												case 4:
													$color = '#ffff33';
													break;
												case 5:
													$color = '#ff6600';
													break;
												case 6:
													$color = '#ff0000';
													break;
											}
					?>					
											<tr>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/student.php?contextid=<?php echo $contextid; ?>&courseid=<?php echo $courseid; ?>&period=<?php echo $period; ?>&student=<?php echo $reader_moodle->student; ?>"><?php echo htmlentities($reader_moodle->fullname); ?></a>
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="checkbox" class="checkbox" title="Reprobado" name="<?php echo "reprobacion" . $reader_moodle->student; ?>" <?php echo $reader_row->reprobacion == 1 ? 'checked': ''; ?> />
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="checkbox" class="checkbox" title="Inasistencia" name="<?php echo "inasistencia" . $reader_moodle->student; ?>" <?php echo $reader_row->inasistencia == 1 ? 'checked': ''; ?> />
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="checkbox" class="checkbox" title="Indisciplina" name="<?php echo "indisciplina" . $reader_moodle->student; ?>" <?php echo $reader_row->indisciplina == 1 ? 'checked': ''; ?> />
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="checkbox" class="checkbox" title="No entrego tareas" name="<?php echo "notrabajos" . $reader_moodle->student; ?>" <?php echo $reader_row->no_entrega_trabajo == 1 ? 'checked': ''; ?> />
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="checkbox" class="checkbox" title="Requiere apoyo psicológico" name="<?php echo "apoyopsico" . $reader_moodle->student; ?>" <?php echo $reader_row->apoyo_psicologico == 1 ? 'checked': ''; ?> />
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="checkbox" class="checkbox" title="Requiere apoyo económico" name="<?php echo "apoyoecono" . $reader_moodle->student; ?>" <?php echo $reader_row->apoyo_economico == 1 ? 'checked': ''; ?> />
												</td>
												<td style="width: 100%; background-color: <?php echo $color; ?>;">
													<input type="text" class="text" style="width: 250px;" name="<?php echo "razones" . $reader_moodle->student; ?>" <?php echo strlen($reader_row->observaciones) > 0 ? "value='" . htmlentities($reader_row->observaciones) . "'": ""; ?> />
												</td>
											</tr>
					<?php
										}
					?>
										</table>
										<div class="contenedorGuardar">
											<input type="submit" class="submit button" name="sumbit" value="Guardar" />
											<input type="reset" class="reset button" name="reset" value="Cancelar" />
										</div>
					<?php
									}
					?>
										</form>
					<?php
								}
							}
							catch(Exception $ex)
							{
								$con_moodle->Close();
								$message = $ex->getMessage();
								$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
								echo "$message";
							}
						}
						else
						{
							echo "No hay datos para mostrar";
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