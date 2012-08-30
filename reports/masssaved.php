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
						if(isset($_POST['courseid']) and isset($_POST['contextid']) and isset($_POST['groupname']) and isset($_POST['careerid']) and isset($_POST['period']))
						{
							include_once($_SERVER["DOCUMENT_ROOT"] . "/connection/connection.php");
							include_once($_SERVER["DOCUMENT_ROOT"] . "/configuration/configuration.php");
						
							$config_moodle = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/moodle.conf");
							$config_tutorias = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/sgc.conf");
							
							$periodo = $_POST['period'];
							$nu_docente = $_GLOBALS['sesion']->userid;
							$nu_materia = $_POST['courseid'];
							$nu_contexto = $_POST['contextid'];
							$nombregrupo = $_POST['groupname'];
							$nu_semana = $_POST['week'];
							$nu_carrera = $_POST['careerid'];
							$mode = isset($_POST['mode']) ? $_POST['mode']: 'insert';


							$sql = "select mdl_user.id as student
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
										and mdl_groups.name = '$nombregrupo'
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
												and mdl_enrol.courseid = $nu_materia
												and mdl_context.id = $nu_contexto
												and mdl_user_enrolments.userid = $nu_docente
										)
									group by firstname, lastname, mdl_groups.name, mdl_role.name";
													
							$con = new Conexion($config_moodle->hostname, $config_moodle->database, $config_moodle->username, $config_moodle->password);
							$con_tutorias = new Conexion($config_tutorias->hostname, $config_tutorias->database, $config_tutorias->username, $config_tutorias->password);
										
							try
							{
								$con->Open();
								$con_tutorias->Open();
								$query = new Command($con);
								$query->setCommand($sql);
								$count = $query->ExecuteQuery();
								$reader = new Reader($query->getResult());

								if($count > 0)
								{
									while($reader->NextByName())
									{
										$nu_alumno = $reader->student;
										$reprobacion = isset($_POST["reprobacion$reader->student"]) ? 1: 0;
										$indisciplina = isset($_POST["indisciplina$reader->student"]) ? 1: 0; 
										$inasistencia = isset($_POST["inasistencia$reader->student"]) ? 1: 0;
										$no_entrega_trabajo = isset($_POST["notrabajos$reader->student"]) ? 1: 0;
										$apoyo_psicologico = isset($_POST["apoyopsico$reader->student"]) ? 1: 0;
										$apoyo_economico = isset($_POST["apoyoecono$reader->student"]) ? 1: 0;
										$observaciones = isset($_POST["razones$reader->student"]) ? $_POST["razones$reader->student"]: null;
										$sql_inserta = "";
										if($mode == 'edit')
										{
											$sql_inserta = "update informes_docentes
															set reprobacion = $reprobacion, indisciplina = $indisciplina, 
																inasistencia = $inasistencia, no_entrega_trabajo = $no_entrega_trabajo, 
																apoyo_psicologico = $apoyo_psicologico, apoyo_economico = $apoyo_economico,
																observaciones = '$observaciones'
															where periodo = '$periodo' and nu_carrera = $nu_carrera
																and nu_semana = $nu_semana and nu_docente = $nu_docente
																and nu_materia = $nu_materia and nu_contexto = $nu_contexto
																and nombregrupo = '$nombregrupo' and nu_alumno = $nu_alumno";											
										}
										else
										{
											$sql_inserta = "insert into informes_docentes(periodo, nu_carrera, nu_semana, nu_docente, nu_materia,
																nu_contexto, nombregrupo, nu_alumno, reprobacion, inasistencia, indisciplina, 
																no_entrega_trabajo, apoyo_psicologico, apoyo_economico, observaciones)
															values ('$periodo', $nu_carrera, $nu_semana, $nu_docente, $nu_materia, 
																$nu_contexto, '$nombregrupo', $nu_alumno, $reprobacion, $inasistencia, $indisciplina,  
																$no_entrega_trabajo, $apoyo_psicologico, $apoyo_economico, '$observaciones');";
										}
										$insert = new Command($con_tutorias);
										$insert->setCommand($sql_inserta);
										$afectados = $insert->ExecuteNoQuery();
									}
									echo "<p><h2><Registros guardados correctamentamente</h2></p>";
								?>
									<script type="text/javascript">
										var pagina="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/listcourse.php?period=<?php echo $periodo; ?>"
										function redireccionar() 
										{
											location.href=pagina
										} 
										setTimeout ("redireccionar()", 1500);
									</script>
								<?php
								}
							}
							catch(Exception $ex)
							{
								$con->Close();
								$message = $ex->getMessage();
								$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
								echo "$message";
							}
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