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
							
							try
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
										group by firstname, lastname, mdl_groups.name, mdl_role.name
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
														$sql_existe = "select nu_semana 
																from informes_docentes
																where periodo = '$period'
																	and nu_carrera = $careerid
																	and nu_docente = $userid
																	and nu_materia = $courseid
																	and nu_contexto = $contextid
																	and nombregrupo = '$groupname'
																group by nu_semana";
														$con_tutorias->Open();
														$query_tutorias = new Command($con_tutorias);
														$query_tutorias->setCommand($sql_existe);
														$count_existe = $query_tutorias->ExecuteQuery();
														$reader_tutorias = new Reader($query_tutorias->getResult());
														
														$lista = array();
														for($i = 1; $i <= $config_tutorias->weeks; $i++)
														{
															$lista[$i] = true;
														}															
														
														
														while($reader_tutorias->NextByName())
														{
															$lista[$reader_tutorias->nu_semana] = false;
														}

														for($i = 1; $i <= $config_tutorias->weeks; $i++)
														{
															if($lista[$i] == true)
																echo "<option value='$i'>Semana $i</option>\n";
														}															
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
				?>					
										<tr>
											<td>
												<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/student.php?contextid=<?php echo $contextid; ?>&courseid=<?php echo $courseid; ?>&student=<?php echo $reader_moodle->student; ?>&groupname=<?php echo $groupname; ?>&careerid=<?php echo $careerid; ?>&period=<?php echo $period; ?>"><?php echo htmlentities($reader_moodle->fullname); ?></a>
											</td>
											<td>
												<input type="checkbox" class="checkbox"  title="Reprobado" name="<?php echo "reprobacion" . $reader_moodle->student; ?>" />
											</td>
											<td>
												<input type="checkbox" class="checkbox"  title="Indisciplina" name="<?php echo "indisciplina" . $reader_moodle->student; ?>" />
											</td>
											<td>
												<input type="checkbox" class="checkbox"  title="Inasistencia" name="<?php echo "inasistencia" . $reader_moodle->student; ?>" />
											</td>
											<td>
												<input type="checkbox" class="checkbox"  title="No entrega trabajos" name="<?php echo "notrabajos" . $reader_moodle->student; ?>" />
											</td>
											<td>
												<input type="checkbox" class="checkbox"  title="Requiere apoyo psicológico" name="<?php echo "apoyopsico" . $reader_moodle->student; ?>" />
											</td>
											<td>
												<input type="checkbox" class="checkbox"  title="Requiere apoyo económico" name="<?php echo "apoyoecono" . $reader_moodle->student; ?>" />
											</td>
											<td>
												<input type="text" class="text" placeholder="Escribir las observaciones que tenga del alumno" name="<?php echo "razones" . $reader_moodle->student; ?>" />
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