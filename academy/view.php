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
		$layout->getHeader($_GLOBALS['sesion']->userid, $_GLOBALS['sesion']->role);
	?>
		<div class="contenedorPrincipal">
			<div class="infocontainer">
				<?php
					if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid))
					{
						require_once($_SERVER["DOCUMENT_ROOT"] . "/moodle/moodlelib.php");

						$userid = $_GLOBALS['sesion']->userid;
						$courseid = $_GET['courseid'];
						$contextid = $_GET['contextid'];
						$careerid = $_GET['careerid'];
						$period = isset($_GET['period']) ? $_GET['period']: $config_tutorias->currentperiod;							
									
						try
						{
							$moodle = new Moodle();
							
							$resultado = $moodle->CursosPorDocente($courseid, $contextid, $userid);
							
							while($resultado->NextByName())
							{
							?>
								<ul>
									<li>
										<a href="http://<?php echo $_SERVER["SERVER_NAME"];?>/group/view.php?contextid=<?php echo $contextid;?>&courseid=<?php echo $courseid;?>&groupname=<?php echo $resultado->groupname;?>&period=<?php echo $period;?>&careerid=<?php echo $careerid;?>" > <?php echo htmlentities($resultado->groupname);?></a>
										<ul>
											<li>
												<a href="http://<?php echo $_SERVER["SERVER_NAME"];?>/grade/view.php?contextid=<?php echo $contextid;?>&courseid=<?php echo $courseid;?>&groupname=<?php echo $resultado->groupname;?>&period=<?php echo $period;?>&careerid=<?php echo $careerid;?>" > Calificaciones </a>
											</li>
											<li>
												<a href="http://<?php echo $_SERVER["SERVER_NAME"];?>/section/view.php?contextid=<?php echo $contextid;?>&courseid=<?php echo $courseid;?>&groupname=<?php echo $resultado->groupname;?>&period=<?php echo $period;?>&careerid=<?php echo $careerid;?>" > Unidades </a>
											</li>
											<li>
												<?php echo htmlentities($resultado->description);?>
											</li>
										</ul>
									</li>
								</ul>
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
					else
					{
						$layout->RedireccionarSGA("/login/index.php?action=login");
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