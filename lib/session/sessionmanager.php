<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/session/session.php");
	
	if(!isset($_GLOBALS['sesion']))
	{
		$_GLOBALS['sesion'] = Session::getInstance();
	}
?>