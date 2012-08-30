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
						include_once ($_SERVER["DOCUMENT_ROOT"] . "/layout/menu.php");
						getMenu($_GLOBALS['sesion']->userid, $_GLOBALS['sesion']->role);

						include_once($_SERVER["DOCUMENT_ROOT"] . "/connection/connection.php");
						include_once($_SERVER["DOCUMENT_ROOT"] . "/configuration/configuration.php");

						$config_tutorias = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/sgc.conf");
					
						$userid = $_GLOBALS['sesion']->userid;
						$period = isset($_GET['period']) ? $_GET['period']: $config_tutorias->currentperiod;							
						$config = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/config/moodle.conf");
						
						echo "Periodo: $period";
						
						$sql = "select mdl_role_assignments.contextid as contextid, mdl_course.id as courseid, mdl_course.fullname as course
								from mdl_user, mdl_enrol, mdl_user_enrolments , mdl_course,
									mdl_role, mdl_role_assignments, mdl_context
								where mdl_role.id = mdl_role_assignments.roleid
									and mdl_role_assignments.userid = mdl_user.id
									and mdl_role_assignments.contextid = mdl_context.id
									and mdl_context.instanceid = mdl_course.id
									and mdl_user.id = mdl_user_enrolments.userid 
									and mdl_user_enrolments.enrolid = mdl_enrol.id 
									and mdl_enrol.courseid = mdl_course.id 
									and mdl_role.shortname = 'editingteacher'
									and mdl_user.id = $userid
								group by  mdl_role_assignments.contextid, mdl_course.id, mdl_course.fullname";
												
						$con = new Conexion($config->hostname, $config->database, $config->username, $config->password);
						$con_tutorias = new Conexion($config_tutorias->hostname, $config_tutorias->database, $config_tutorias->username, $config_tutorias->password);
									
						try
						{
							$con->Open();
							$query = new Command($con);
							$query->setCommand($sql);
							$count = $query->ExecuteQuery();
							$reader = new Reader($query->getResult());
														
							if($count > 0)
							{
								$con_tutorias->Open();
							?>
								<table>
									<tr>
										<td>
							<?php
																
								while($reader->NextByName())
								{
									$sql_careers = "select id as careerid, name as career
													from mdl_course_categories
													where id in (
														select case parent 
															when 0 then mdl_course_categories.id 
															else parent end 
														from mdl_course_categories join mdl_course 
															on (mdl_course_categories.id = mdl_course.category)
														where mdl_course.id = $reader->courseid)";

									$query_careers = new Command($con);
									$query_careers->setCommand($sql_careers);
									$count_careers = $query_careers->ExecuteQuery();
									$reader_careers = new Reader($query_careers->getResult());
									$careerid = 0;
									if($count_careers > 0)
									{
										$reader_careers->NextByName();
										$careerid = $reader_careers->careerid;
					?>
										<ul>
											<li><h3><?php echo htmlentities($reader_careers->career); ?></h3></li>
												<ul>
													<li><h5><?php echo htmlentities($reader->course); ?></h5></li>
														<ul>
					<?php
										$sql_groups = "select mdl_groups.name as groupname, mdl_groups.description
											from mdl_enrol, mdl_user_enrolments , mdl_role, 
												mdl_role_assignments, mdl_context, mdl_groups
											where mdl_role.id = mdl_role_assignments.roleid
												and mdl_role_assignments.userid = mdl_user_enrolments.userid
												and mdl_role_assignments.contextid = mdl_context.id
												and mdl_context.instanceid = mdl_enrol.courseid 
												and mdl_user_enrolments.enrolid = mdl_enrol.id 
												and mdl_role.shortname = 'editingteacher'
												and mdl_groups.courseid = mdl_enrol.courseid
												and mdl_enrol.courseid = $reader->courseid
												and mdl_user_enrolments.userid = $userid
												and mdl_context.id = $reader->contextid";
	
										$query_groups = new Command($con);
										$query_groups->setCommand($sql_groups);
										$count_groups = $query_groups->ExecuteQuery();
										$reader_groups = new Reader($query_groups->getResult());
										if($count_groups > 0)
										{
											while($reader_groups->NextByName())
											{
						?>
												<li>
													Grupo: <?php echo htmlentities($reader_groups->groupname); ?>
													<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/group.php?contextid=<?php echo $reader->contextid; ?>&courseid=<?php echo $reader->courseid; ?>&groupname=<?php echo $reader_groups->groupname; ?>&careerid=<?php echo $careerid; ?>&period=<?php echo $period; ?>" >
														Capturar nueva semana
													</a>
												</li>
						<?php
												$sql_week = "select nu_semana 
															from informes_docentes
															where periodo = '$config_tutorias->currentperiod'
																and nu_carrera = $reader_careers->careerid
																and nu_docente = $userid
																and nu_materia = $reader->courseid
																and nu_contexto = $reader->contextid
																and nombregrupo = '$reader_groups->groupname'
															group by nu_semana";
												
												$query_week = new Command($con_tutorias);
												$query_week->setCommand($sql_week);
												$count_week = $query_week->ExecuteQuery();
												$reader_week = new Reader($query_week->getResult());
												
												if($count_week > 0)
												{
								?>
													<ul>
														<li><span>Semanas Capturadas</span></li>
															<ul>					
								<?php
													while($reader_week->NextByName())
													{
								?>
														<li> <?php echo "Semana $reader_week->nu_semana"; ?>
															<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/editweek.php?contextid=<?php echo $reader->contextid; ?>&courseid=<?php echo $reader->courseid; ?>&groupname=<?php echo $reader_groups->groupname; ?>&careerid=<?php echo $careerid; ?>&week=<?php echo $reader_week->nu_semana; ?>&period=<?php echo $period; ?>" >
																Editar
															</a>
														</li>
								<?php
														
													}
								?>
													</ul>
												</ul>
								<?php
												}
												else
													echo "<ul><li><span style='color:red'>Sin semanas capturadas</span></li></ul>";
											}
								?>
										</ul>
								<?php
										}
										else
											echo "<ul><li><span style='color:red'><big>Sin grupos. Hay que crearlos en <a href='http://www.moodle.itsescarcega.edu.mx/group/index.php?id=$reader->courseid'>Moodle</a></big></span></li></ul>";
								?>
										</ul>
									</ul>
								<?php
									}
								}
							?>
									</td>
								</tr>
							</table>
							<?php
								
							}
							$con->Close();
						}
						catch(Exception $ex)
						{
							$con->Close();
							$message = $ex->getMessage();
							$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
							echo "$message";
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