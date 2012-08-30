<?php
require_once ($_SERVER["DOCUMENT_ROOT"] . "/session/sessionmanager.php");

if ($_GLOBALS['sesion'] -> expireSession() == true)
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
		<title><?php echo $layout -> getSiteName();?></title>
		<meta name="description" content="Lista de grupos por docente" />
		<meta name="author" content="Francisco Salvador Ballina Sánchez" />
		<link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"];?>/styles/styles.css" media="screen" />
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
						require_once($_SERVER["DOCUMENT_ROOT"] . "/moodle/moodlelib.php");
						require_once($_SERVER["DOCUMENT_ROOT"] . "/sga/sgalib.php");
						
						$sga = new SGA();


						$userid = $_GLOBALS['sesion']->userid;
						$courseid = $_GET['courseid'];
						$contextid = $_GET['contextid'];
						$careerid = $_GET['careerid'];
						$period = isset($_GET['period']) ? $_GET['period']: $sga->ObtenerPeriodoActual();							
									
						try
						{
							$moodle = new Moodle();
						?>
							<h1>Curso: <?php echo $moodle->NombreMateria($courseid, false); ?></h1>	
						<?php
													
							$resultado = $moodle->ObtenerGruposDeCursoDocente($courseid, $contextid, $userid);
						?>
							<div class="Cursos">
						<?php
							while($resultado !== false && $resultado->NextByName())
							{
							?>
								<div class="opcionesCursos">
									<h3>Grupo: <?php echo htmlentities($resultado->groupname);?> </h3> 
									<ul>
										<div class="marcoNavegacion">
											<li>
												<?php echo $layout->generarLiga("Alumnos", "group/view.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
											</li>
											<li>
												<?php echo $layout->generarLiga("Planeci&oacute;n e Instrumentaci&oacute;n", "planeations/index.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
											</li>
											<li>
												<?php echo $layout->generarLiga("Asistencias", "group/assists.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
											</li>
											<li>
												<?php echo $layout->generarLiga("Calificaciones", "grade/view.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
											</li>
											<li>
												<?php echo $layout->generarLiga("Incidencias", "reports/group.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
											</li>
											
										</div>
									</ul>
								</div>
							<?php
							}
						?>
							</div>
						<?php
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
						$layout->RedireccionarSGA("/login/index.php?action=login");
					}
					
					echo $layout->generarBotonRegresar("Regresar...");
				?>
			</div>
		</div>
		<footer>
			<p>
				&copy; Copyright  by <?php echo $layout -> getPowerBy();
				unset($layout);
				?>
			</p>
		</footer>
	</body>
</html>