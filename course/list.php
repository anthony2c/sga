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
				if(isset($_GLOBALS['sesion']->userid) and isset($_GLOBALS['sesion']->role) and isset($_GLOBALS['sesion']->rolename))
				{
					require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/moodle.php");
					require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/sga.php");

					try
					{
						$moodle = new Moodle();
						$sga = new SGA();

						$nu_docente = $_GLOBALS['sesion']->userid;
						
						$periodo_actual = $sga->obtenerPeriodoVigente();
						
						if($periodo_actual !== false)
						{
							if($periodo_actual->NextByName())
							{
								$_GLOBALS['sesion']->nu_periodo = $periodo_actual->nu_periodo;
								$_GLOBALS['sesion']->nombreperiodo = htmlentities($periodo_actual->nombre);
								$_GLOBALS['sesion']->inicio_periodo = $periodo_actual->fe_inicio;
								$_GLOBALS['sesion']->final_periodo = $periodo_actual->fe_final;
							}
						}							
						
						$cursos = $moodle->ObtenerCursosDeDocente($nu_docente);

						if($cursos !== false)
						{
							while($cursos->NextByName())
							{
								$carrera = $moodle->obtenerCarreraCurso($cursos->idcurso);
								
								if($carrera !== false)
								{
									$carrera->NextByName();
							?>
								<h3><?php echo htmlentities($carrera->carrera); ?></h3>
									<h5>
										<?php 
											echo $layout->generarLiga(htmlentities($cursos->nombrecurso), "course/view.php", "contextid=$cursos->idcontexto&courseid=$cursos->idcurso&careerid=$carrera->idcarrera&period=$periodo_actual->nu_periodo");	
										?>
									</h5>
							<?php
								}
								else
									echo "<ul><li><span style='color:red'><big>Sin grupos. Hay que crearlos en <a href='http://www.moodle.itsescarcega.edu.mx/group/index.php?id=$cursos->courseid'>Moodle</a></big></span></li></ul>";
							}
						}
						else
							{
								echo "no hay cursos";
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