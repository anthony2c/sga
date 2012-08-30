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
		<div class="contenedorPrincipal">
			<div class="infocontainer">
				<?php
				if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid) and isset($_GLOBALS['sesion']->role))
				{
					require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/sga.php");
					require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/moodle.php");
					
					$moodle = new Moodle();
					$sga = new SGA();

					$nu_docente = $_GLOBALS['sesion']->userid;
					$nu_curso = $_GET['courseid'];
					$nu_contexto = $_GET['contextid'];
					$nu_carrera = $_GET['careerid'];
					$nu_grupo = $_GET['group'];
					$nu_periodo = $_GET['period'];
					
					$instrumentaciones = $sga->obtenerInstrumentacion($nu_periodo, $nu_carrera, $nu_docente, $nu_curso, $nu_contexto, $nu_grupo);
					
					if($instrumentaciones !== false)
					{
						$instrumentaciones->NextByName();
					?>
						<div class="Unidades">
							<h3>Unidades disponibles</h3>
							<ul>
						<?php
							for($i = 1; $i <= $instrumentaciones->nu_unidades; $i++)
							{
							?>
								<li>
									<?php echo $layout->generarLigaBoton("Unidad $i", "course/planeation.php", "courseid=$instrumentaciones->courseid&contextid=$instrumentaciones->contextid&unidad=$i"); ?>
								</li>
							<?php
							}
						?>
							</ul>
						</div>
					<?php
					}
						
				?>
					<form action="coverart.php" method="post" enctype="application/x-www-form-urlencoded">
						<input name="courseid" type="hidden" value="<?php echo $courseid; ?>"/>
						<input name="contextid" type="hidden" value="<?php echo $contextid; ?>"/>
						<input name="careerid" type="hidden" value="<?php echo $careerid; ?>"/>
						<input name="period" type="hidden" value="<?php echo $period; ?>"/>
						<input name="groupname" type="hidden" value="<?php echo $groupname; ?>"/>
						<input name="nu_instrumentacion" type="hidden" value="<?php echo $instrumentaciones !== false ? $instrumentaciones->nu_instrumentacion: -1 ?>"/>
						<input name="edit" type="hidden" value="<?php echo $instrumentaciones !== false ? 'true': 'false' ?>"/>
						
						<div class="planeacion">
							<table>
								<tr>
									<td><p>Nombre de la Asignatura:</p></td>
									<td><?php echo $instrumentaciones !== false ? $moodle->NombreMateria($instrumentaciones->nu_materia, false): $moodle->NombreMateria($courseid, false); ?></td>
								</tr>
								<tr>
									<td><p>Carrera:</p></td>
									<td><?php echo $instrumentaciones !== false ? $moodle->NombreCarrera($instrumentaciones->nu_carrera): $moodle->NombreCarrera($careerid); ?></td>
								</tr>
								<tr>
									<td><p>Clave de la Asignatura:</p></td>
									<td><input name="clave" type="text" value="<?php echo $instrumentaciones !== false ? $instrumentaciones->clave: ''; ?>"/></td>
								</tr>
								<tr>
									<td><p>Horas teóricas- Horas prácticas- Créditos:</p></td>
									<td><input name="satca" type="text" value="<?php echo $instrumentaciones !== false ? $instrumentaciones->satca: ''; ?>" /></td>
								</tr>
								<tr>
									<td><p>Número de Unidades:</p></td>
									<td>
									<?php
										if($instrumentaciones !== false)
										{
											echo "<input name=\"nu_unidades\" type=\"number\" step=\"1\" min=\"1\" max=\" . $sga->ObtenerMaximoNumeroUnidades() . \"style=\"width: 95%\" value=\"$instrumentaciones->nu_unidades\" />";
										}
										else
										{
									?>
										<select name="nu_unidades">
										<?php
											for($i = 1; $i < $sga->ObtenerMaximoNumeroUnidades(); $i++)
												echo "<option value=\"$i\">$i</option>";
										?>
										</select>
									<?php
										}
									?>
									</td>
								</tr>
							</table>
						</div>
						
						<div class="planeacion">
							<table>
								<tr>
									<th>I. Caracterización de la asignatura</th>
								</tr>
								<tr>
									<td><textarea name="caracterizacion"><?php echo $instrumentaciones !== false ? $instrumentaciones->caracterizacion: ''; ?></textarea></td>
								</tr>
							</table>
						</div>
						
						<div class="planeacion">
							<table>
								<tr>
									<th>II.- Competencias específicas a desarrollar (Objetivo (s) General (s) del Curso)</th>
								</tr>
								<tr>
									<td><textarea name="competencias"><?php echo $instrumentaciones !== false ? $instrumentaciones->competencias: ''; ?></textarea></td>
								</tr>
							</table>
						</div>
						
						<div class="contenedorGuardar">
							<input type="submit" value="Guardar"/>
							<input type="reset" name="reset" value="Cancelar" />
						</div>
					</form>

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