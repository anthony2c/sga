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
						if(isset($_POST['nu_curso']) and isset($_POST['nu_contexto']) and isset($_POST['nombregrupo']) and isset($_POST['nu_carrera']) and isset($_POST['periodo']))
						{
							require_once($_SERVER["DOCUMENT_ROOT"] . "/moodle/moodlelib.php");
							require_once($_SERVER["DOCUMENT_ROOT"] . "/sga/sgalib.php");
	
							$periodo = $_POST['periodo'];							
							$userid = $_GLOBALS['sesion']->userid;
							$nu_curso = $_POST['nu_curso'];
							$nu_contexto = $_POST['nu_contexto'];
							$nombregrupo = $_POST['nombregrupo'];
							$nu_carrera = $_POST['nu_carrera'];
							$fecha = $_POST['fechaPaseLista'];
							
							try
							{
								$moodle = new Moodle();
								$sga = new SGA();
			
								$alumnos = $moodle->ObtenerAlumnosPorCursoGrupo($nu_curso, $nu_contexto, $userid, $nombregrupo);

								if($alumnos !== false)
								{
									while($alumnos->NextByName())
									{
										$idalumno = $_POST["alumno$alumnos->student"];
										$asistio = isset($_POST["asistio$alumnos->student"]) ? 1: 0;	
										
										$sga->AgregarAsistenciaAlumnoEnCurso($periodo, $nu_carrera, $nu_curso, $nu_contexto, $userid, $nombregrupo, $idalumno, $fecha, $asistio);
									}
								?>
									<span>Las asistencia del dia <date><?php echo $fecha; ?></date> han sido guardadas</span>
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