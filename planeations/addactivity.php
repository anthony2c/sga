<?php
	require_once ($_SERVER["DOCUMENT_ROOT"] . "/session/sessionmanager.php");
	
	if ($_GLOBALS['sesion'] -> expireSession() == true)
	{
?>
		session destruida<br>
<?php
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
					require_once($_SERVER["DOCUMENT_ROOT"] . "/sga/sgalib.php");

					$userid = $_GLOBALS['sesion']->userid;
					$courseid = $_POST['courseid'];
					$contextid = $_POST['contextid'];
					$careerid = $_POST['careerid'];
					$groupname = $_POST['groupname'];
					$period = isset($_POST['period']) ? $_POST['period']: $config_tutorias->currentperiod;
					$actividad = $_POST['actividad'];
					$tipo = $_POST['tipo'];
					
					$sga = new SGA();
					
					if( $sga->AgregarActividad(htmlentities($actividad), $tipo, $userid, $careerid) !== false)
					{
						$layout->RedireccionarSGA("/course/planeation.php?contextid=$contextid&courseid=$courseid&groupname=$groupname&careerid=$careerid&period=$period");
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