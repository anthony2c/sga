<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/session/sessionmanager.php");
	
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

						if(isset($_POST['courseid']) and isset($_POST['contextid']) and isset($_POST['group']) and isset($_POST['careerid']) and isset($_POST['period']))
						{
							require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/sga.php");
						
							$sga = new SGA();
							$nu_periodo = $_POST['nu_periodo'];
							$nu_docente = $_POST['nu_docente'];
							$nu_curso = $_POST['nu_curso'];
							$nu_contexto = $_POST['nu_contexto'];
							$nu_grupo = $_POST['nu_grupo'];
							$nu_semana = $_POST['nu_semana'];
							$nu_carrera = $_POST['nu_carrera'];
							$nu_alumno = $_POST['nu_alumno'];
							$mode = isset($_POST['mode']) ? $_POST['mode']: 'insert';

							try
							{
								$reprobacion = isset($_POST["reprobacion$nu_alumno"]) ? 1: 0;
								$indisciplina = isset($_POST["indisciplina$nu_alumno"]) ? 1: 0; 
								$inasistencia = isset($_POST["inasistencia$nu_alumno"]) ? 1: 0;
								$no_entrega_trabajo = isset($_POST["notrabajos$nu_alumno"]) ? 1: 0;
								$apoyo_psicologico = isset($_POST["apoyopsico$nu_alumno"]) ? 1: 0;
								$apoyo_economico = isset($_POST["apoyoecono$nu_alumno"]) ? 1: 0;
								$observaciones = isset($_POST["razones$nu_alumno"]) ? $_POST["razones$nu_alumno"]: null;
								$sql_inserta = "";
								if($mode == 'edit')
								{
									$sga->actualizarInformeTutorias($nu_periodo, $nu_carrera, $nu_curso, $nu_contexto, $nu_docente, 
											$nu_grupo, $nu_semana, $nu_alumno, $reprobacion, $indisciplina, $inasistencia, $no_entrega_trabajo,
											$apoyo_psicologico, $apoyo_economico, $observaciones);
								}
								else
								{
									$sga->agregarInformeTutorias($nu_periodo, $nu_carrera, $nu_curso, $nu_contexto, $nu_docente, 
											$nu_grupo, $nu_semana, $nu_alumno, $reprobacion, $indisciplina, $inasistencia, $no_entrega_trabajo,
											$apoyo_psicologico, $apoyo_economico, $observaciones);
								}
								$layout->RedireccionarSGA("/", 1500);
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