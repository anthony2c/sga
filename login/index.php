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
<html dir="ltr" lang="es-mx">
	<head>
		<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
		<title><?php echo $layout->getSiteName(); ?></title>
		<meta content="francisco@hostingbroad.com" name="author">
		<meta content="tutorias" name="keywords">
		<link rel="stylesheet" href="<?php echo $layout->ObtenerHojaDeEstilo(); ?>" media="screen" />
	</head>
	
	<body>
	<?php
		$layout->getHeader($_GLOBALS['sesion']->userid, $_GLOBALS['sesion']->role, $_GLOBALS['sesion']->roleTutor, $_GLOBALS['sesion']->roleRootSGC);
	?>
		<div class="contenedorPrincipal">
			<div class="infocontainer">
			<?php
				if(isset($_GLOBALS['sesion']->userid) and isset($_GLOBALS['sesion']->username))
				{
					if(isset($_GET['action']))
					{
						if($_GET['action'] == 'logout')
						{
							$_GLOBALS['sesion']->destroy();
							$layout->RedireccionarSGA("/login/index.php?action=login");						
						}
					}
					else
					{
						$layout->RedireccionarSGA("/");						
					}
				}
			?>
				<div class="inicioSesion">
					<p>Inicio de sesión</p>
					<br>
						<em><?php echo isset($_GET['e']) ? $_GET['e']: ""; ?></em>
					<form enctype="application/x-www-form-urlencoded" autocomplete="off"
					method="POST" action="validate.php" name="login">
						<table>
							<tr>
								<td><label>Usuario:</label></td>
								<td><input autocomplete="off" required="required" name="username" type="text"></td>
							</tr>
							<tr>
								<td><label>Contrase&ntilde;a:</label></td>
								<td><input autocomplete="off" required="required" name="password" type="password"></td>
							</tr>
						</table>
						<div class=contenedorGuardar>
							<button type="submit" name="iniciar">Iniciar</button>
						</div>
					</form>
					<br>
				</div>
			</div>
		</div>
		<footer>
			<p>
				&copy; Copyright  by <?php echo $layout->getPowerBy(); 		unset($layout); ?>
			</p>
		</footer>
	</body>
</html>