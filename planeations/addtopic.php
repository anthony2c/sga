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
		<link rel="stylesheet" href="http://<?php echo $_SERVER["SERVER_NAME"];?>/styles/styles.css" media="screen" />
		<script type="text/javascript" src="http://<?php echo $_SERVER["SERVER_NAME"];?>/script/planeation.js"></script>
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
					
					$sga = new SGA();
					$userid = $_GLOBALS['sesion']->userid;
					$courseid = $_GET['courseid'];
					$contextid = $_GET['contextid'];
					$careerid = $_GET['careerid'];
					$period = isset($_GET['period']) ? $_GET['period']: $sga->ObtenerPeriodoActual();
					
					
				?>
				<div class="ContenedorActividades">
					<div class="actividades">
						<form action="addactivity.php" method="post">
							Actividad de aprendizaje: 
							<input name="actividad" type="text" 
							placeholder="Introducir una nueva actividad de enseñanza"
							class="actividad"/>
							<input name="tipo" type="hidden" value="0"/>
							<input name="courseid" type="hidden" value="<?php echo $courseid; ?>"/>
							<input name="contextid" type="hidden" value="<?php echo $contextid; ?>"/>
							<input name="careerid" type="hidden" value="<?php echo $careerid; ?>"/>
							<input name="period" type="hidden" value="<?php echo $period; ?>"/>

							<div class="contenedorGuardar">
								<input type="submit" value="Agregar Actividad"/>
								<input type="reset" name="reset" value="Cancelar" />
							</div>
							<select id="actividadesAprendizaje" class="listaActividades" name="actividades[]" multiple="multiple" size="20" ondblclick="VerDetalleActividadAprendizaje()">
							<?php
								
								$Reader = $sga->ObtenerListaActividades("tipo = 0");
								while($Reader->NextByName())
								{
									echo "<option value='$Reader->nu_actividad'>" . html_entity_decode($Reader->descripcion) . "</option>";
								}
							?>
							</select>
						</form>
					</div>
					
					<div class="actividades">
						<form action="addactivity.php" method="post">
							Actividad de ense&ntilde;anza: 
							<input name="actividad" type="text" 
							placeholder="Introducir una nueva actividad de enseñanza"
							class="actividad"/>
							<input name="tipo" type="hidden" value="1"/>
							<input name="courseid" type="hidden" value="<?php echo $courseid; ?>"/>
							<input name="contextid" type="hidden" value="<?php echo $contextid; ?>"/>
							<input name="careerid" type="hidden" value="<?php echo $careerid; ?>"/>
							<input name="period" type="hidden" value="<?php echo $period; ?>"/>

							<div class="contenedorGuardar">
								<input type="submit" value="Agregar Actividad"/>
								<input type="reset" name="reset" value="Cancelar" />
							</div>
							<select id="actividadesEnsenanza" class="listaActividades" name="actividades[]" multiple="multiple" size="20" ondblclick="VerDetalleActividadEnsenanza()">
							<?php
								$Reader = $sga->ObtenerListaActividades("tipo = 1");
								while($Reader->NextByName())
								{
									echo "<option value='$Reader->nu_actividad'>" . html_entity_decode($Reader->descripcion) . "</option>";
								}
							?>
							</select>
						</form>
					</div>
					
					<div class="fechasActividades">
						<form action="adddateactivity.php" method="post" >
							Actividad de aprendizaje: 
							<input class="actividad" type="date" name="dateactivity" />
							<div class="contenedorGuardar">
								<input type="submit" value="Agregar"/>
								<input type="reset" name="reset" value="Cancelar" />
							</div>
							<select class="listaActividades" name="dateactivities" multiple="multiple" title="Lista Actividades" size="20">
								<option class="opcionListaActividades"><time>2011-09-11</time></option>
								<option class="opcionListaActividades"><time>2011-09-11</time></option>
								<option class="opcionListaActividades"><time>2011-09-11</time></option>
								<option class="opcionListaActividades"><time>2011-09-11</time></option>
							</select>
						</form>
					</div>
				</div>
				<?php

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