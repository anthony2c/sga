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
		<meta name="description" content="Planeación e Instrumentación Didáctica del Curso" />
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
					require_once($_SERVER["DOCUMENT_ROOT"] . "/moodle/moodlelib.php");
					require_once($_SERVER["DOCUMENT_ROOT"] . "/sga/sgalib.php");
					
					$sga = new SGA();
					
					$userid = $_GLOBALS['sesion']->userid;
					$courseid = $_GET['courseid'];
					$contextid = $_GET['contextid'];
					$careerid = $_GET['careerid'];
					$period = isset($_GET['period']) ? $_GET['period']: $sga->ObtenerPeriodoActual();							
										
					$moodle = new Moodle();
					$cursos = $moodle->ObtenerCursosDeDocente($userid);
					
					while($cursos->NextByName())
					{
						echo $moodle->NombreMateria($cursos->courseid, false); 
					?>
						<ul>
							<li>
								<?php echo $layout->generarLiga("Reporte Mensual por Curso", "tutors/monthlyreportbycourse.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
							</li>
							<li>
								<?php echo $layout->generarLiga("Reporte Mensual por Semana", "tutors/monthlyreportbyweek.php", "contextid=$contextid&courseid=$courseid&groupname=$resultado->groupname&period=$period&careerid=$careerid"); ?>
							</li>
						</ul>
					<?php
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