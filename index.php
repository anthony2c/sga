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
		<meta name="description" content="Inicio para el Sistema de Gestión del Curso" />
		<meta name="author" content="Francisco Salvador Ballina Sánchez" />
		<link rel="stylesheet" href="<?php echo $layout->ObtenerHojaDeEstilo(); ?>" media="screen" />
	</head>
	<body>
	<?php
		$layout->getHeader($_GLOBALS['sesion']->userid, $_GLOBALS['sesion']->role, $_GLOBALS['sesion']->roleTutor, $_GLOBALS['sesion']->roleRootSGC);
	?>
		<section>
			<div class="contenedorPrincipal">
			<?php
				if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid) and isset($_GLOBALS['sesion']->role))
				{
					echo "<h1>" . $_GLOBALS['sesion']->fullname . "</h1>";
					echo "<h2>Entras como  "  . $_GLOBALS['sesion']->rolename . "</h2>";
				}
				else if(isset($_GET['id']) and isset($_GET['u']) and isset($_GET['e']))
				{
					require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/moodle.php");
					
					$id = $_GET['id'];
					$nombreusuario = $_GET['u'];
					$email = $_GET['e'];
					
					try
					{
						$moodle = new Moodle();
						
						$docente = $moodle->validarDocenteDesdeMoodle($id, $nombreusuario, $email);

						if($docente !== false)
						{
							$layout->RedireccionarSGA("/login/index.php?action=login");
 /*
							$docente->NextByName();
							
							$_GLOBALS['sesion']->username = htmlentities($nombreusuario);
							$_GLOBALS['sesion']->userid = $docente->idusuario;
							$_GLOBALS['sesion']->fullname = htmlentities($docente->nombre . " " . $docente->apellidos);
							$_GLOBALS['sesion']->rolename = htmlentities($docente->nombrerol);
							$_GLOBALS['sesion']->role = $docente->rol;
							
							$tutor = $moodle->ValidarTutor($docente->idusuario);
							
							if($tutor !== false)
							{
								$i = 0;
								while($tutor->NextByName())
								{
									$_GLOBALS['sesion']->roleTutor = $tutor->shortname;
									$_GLOBALS['sesion']->setKeyValue("careers$i", $tutor->careerid);
									$i++;
								}
								$_GLOBALS['sesion']->totalcareers = $i;							
							}						
							
							$root = $moodle->ValidarAdministradorSGC($docente->idusuario);
							
							if($root !== false)
							{
								while($root->NextByName())
								{
									$_GLOBALS['sesion']->roleRootSGC = $root->shortname;
								}
							}						
	
							$layout->RedireccionarSGA("/");
*/
						}
						else 
						{
							$layout->RedireccionarSGA("/login/none.php");						
						}
					}
					catch(Exception $ex)
					{
						$message = $ex->getMessage();
						$message = "<em><font color='#FF0000'>Error en " . __FILE__ . "</em>: <h4>$message</font></h4>";
						echo "$message";
						
					}
				}
				else
				{
					$layout->RedireccionarSGA("/login/index.php?action=login");
				}
				?>
			</div>
		</section>
		<footer>
			<p>
				&copy; Copyright  by <?php echo $layout->getPowerBy(); 		unset($layout); ?>
			</p>
		</footer>
	</body>
</html>