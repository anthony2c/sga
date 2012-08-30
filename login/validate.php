<?php
	if(isset($_GLOBALS['sesion']))
		unset($_GLOBALS['sesion']);

	require_once $_SERVER["DOCUMENT_ROOT"] . "/lib/session/sessionmanager.php";
	require_once $_SERVER["DOCUMENT_ROOT"] . "/layout/layout.php";
	
	$layout = new Layout();
	
	if(!isset($_GLOBALS['sesion']->username) and !isset($_GLOBALS['sesion']->userid))
	{
		if(isset($_POST['username']) and isset($_POST['password']))
		{
			require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/moodle.php");
			
			$username = $_POST['username'];
			$password = $_POST['password'];
		
			try
			{
				$moodle = new Moodle();
				$usuario = $moodle->validarUsuario($username, $password);
				if($usuario !== false)
				{
					$usuario->NextByName();
					$docente = $moodle->validarDocente($usuario->id);
					if($docente !== false)
					{
						$docente->NextByName();
						
						$_GLOBALS['sesion']->username = htmlentities($username);
						$_GLOBALS['sesion']->userid = $docente->idusuario;
						$_GLOBALS['sesion']->fullname = htmlentities($usuario->fullname);
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
					}
					else 
					{
						echo "Cuenta no corresponde a un docente";
						//$layout->RedireccionarSGA("/login/index.php?action=logout&e=Cuenta no corresponde a un docente");						
					}
 				}
				else
				{
					echo "Cuenta no valida";
					//$layout->RedireccionarSGA("/login/index.php?action=login&e=Cuenta no valida");
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
	}
	else
	{
		//echo "no llegmos al if";
		$layout->RedireccionarSGA("/");
	}
?>