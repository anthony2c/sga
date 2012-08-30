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
				if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid) and isset($_GLOBALS['sesion']->role))
				{
					try
					{
						require_once($_SERVER["DOCUMENT_ROOT"] . "/sga/sgalib.php");
						
						$sga = new SGA();
	
						$userid = $_GLOBALS['sesion']->userid;
						$courseid = $_POST['courseid'];
						$contextid = $_POST['contextid'];
						$careerid = $_POST['careerid'];
						$groupname = $_POST['groupname'];
						$period = isset($_POST['period']) ? $_POST['period']: $sga->ObtenerPeriodoActual();
						$clave = $_POST['clave'];
						$nu_instrumentacion = $_POST['nu_instrumentacion'];
						$edit = $_POST['edit'];
						$nu_unidades = $_POST['nu_unidades'];
						$satca = $_POST['satca'];
						$caracterizacion = $_POST['caracterizacion'];
						$competencias = $_POST['competencias'];
						
						if($edit == 'true')
							$sga->ActualizarInstrumentacion($nu_instrumentacion, $clave, $nu_unidades, $satca, $caracterizacion, $competencias);
						else
							$sga->AgregarInstrumentacion($period, $careerid, $userid, $courseid, $contextid, $groupname, $clave, $nu_unidades, $satca, $caracterizacion, $competencias);
	
						$layout->RedireccionarSGA("/course/view.php?contextid=$contextid&courseid=$courseid&careerid=$careerid&period=$period", 3);
	
						echo $layout->generarBotonRegresar("Regresar...");
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