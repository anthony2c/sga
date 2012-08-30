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
<html dir="ltr" lang="es-mx">
	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<title><?php echo $layout->getSiteName(); ?></title>
		<link rel="stylesheet" href="<?php echo $layout->ObtenerHojaDeEstilo(); ?>" media="screen" />
		<meta content="francisco@hostingbroad.com" name="author">
		<meta content="tutorias" name="keywords">
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
									$userid = $_GLOBALS['sesion']->userid;
					$courseid = $_GET['courseid'];
					$contextid = $_GET['contextid'];
					try
					{
						$reader = new Reader($query->getResult());
					
						if($count > 0)
						{
							while($reader->NextByName())
							{
		?>
								<p>
									<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/reports/group.php?contextid=<?php echo $contextid; ?>&courseid=<?php echo $courseid; ?>&userid=<?php echo $userid; ?>&course=<?php echo $course; ?>&groupname=<?php echo $reader->groupname; ?>" >
										<?php echo htmlentities($reader->groupname); ?>
									</a>
									<h4><?php echo htmlentities($reader->description); ?></h4>
								</p>
		<?php
							}
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
				&copy; Copyright  by <?php echo $layout->getPowerBy(); 		unset($layout); ?>
			</p>
		</footer>
	</body>
</html>