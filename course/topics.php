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
		$layout->getHeader($_GLOBALS['sesion']->userid, $_GLOBALS['sesion']->role, $_GLOBALS['sesion']->roleTutor, $_GLOBALS['sesion']->roleRootSGC);
	?>
		<div class="contenedorPrincipal">
			<div class="infocontainer">
				<?php
					if(isset($_GLOBALS['sesion']->username) and isset($_GLOBALS['sesion']->userid))
					{
						require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/moodle.php");
						require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/sga.php");
						
						$userid = $_GLOBALS['sesion']->userid;
						$courseid = $_GET['courseid'];
						$contextid = $_GET['contextid'];
						$careerid = $_GET['careerid'];
						$period = isset($_GET['period']) ? $_GET['period']: $sga->ObtenerPeriodoActual();
						$nu_periodo = 1;							
									
						try
						{
							$moodle = new Moodle();
							$sga = new SGA();
						?>
							<h1>Curso: <?php echo $moodle->NombreMateria($courseid, false); ?></h1>	
							
							<form class="Formulario" action="savetopics.php" method="post">
								<ol>
									<li>
										<div class="planeacion">
											<h2>Datos de la asignatura</h2>
											<table>
												<tbody>
													<tr>
														<td><p>Nombre de la asignatura</p></td>
														<td><input name="nombre" type="text" placeholder="Escriba el nombre de la asignatura" required="true"/></td>
													</tr>
													<tr>
														<td><p>Carrera</p></td>
														<td>
															<select name="carrera">
															<?php
																$carreras = $sga->obtenerListaCarreras($nu_periodo);
																while($carreras !== false && $carreras->NextByName())
																{
																	echo "<option value=$carreras->nu_carrera>" . htmlentities($carreras->nombre) . "</option>";
																}
															?>
															</select>
														</td>
													</tr>
													<tr>
														<td><p>Clave de la asignatura</p></td>
														<td><input type="text" name="clave" placeholder="Escriba la clave de la asignatura"/></td>
													</tr>
													<tr>
														<td><p>(Créditos) SATCA</p></td>
														<td><input type="text" name="satca" placeholder="Escriba el número de créditos SATCA correspondientes"/></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									
									<li>
										<div class="planeacion">
											<h2>Presentación</h2>
											<table>
												<tbody>
													<tr>
														<th>Caracterización de la asignatura</th>
													</tr>
													<tr>
														<td>
															<textarea name="caracterizacion"></textarea>
														</td>
													</tr>
												</tbody>
											</table>
											<table>
												<tbody>
													<tr>
														<th>Intención didáctica</th>
													</tr>
													<tr>
														<td>
															<textarea name="intencion_didac"></textarea>
														</td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									
									<li>
										<div class="planeacion">
											<h2>Competencias a Desarrollar</h2>
											<table>
												<tbody>
													<tr>
														<th>Competencias específicas</th>
														<th>Competencias genéricas</th>
													</tr>
													<tr>
														<td><input name="comp_especificas" type="text" placeholder="Escribe las competencias específicas a desarrollar"/></td>
														<td><textarea name="comp_genericas"></textarea></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									
									<li>
										<div class="planeacion">
											<h2>Historia del Programa</h2>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Competencias Previas</h2>
											<table>
												<tbody>
													<tr>
														<td><textarea name="comp_previas"></textarea></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Temario</h2>
											<table>
												<tbody>
													<tr>
														<th>Unidad</th>
														<th>Temas</th>
														<th>Subtemas</th>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Sugerencias didácticas</h2>
											<table>
												<tbody>
													<tr>
														<td><textarea name="sugerencias_didac"></textarea></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Sugerencias de evaluación</h2>
											<table>
												<tbody>
													<tr>
														<td><textarea name="sugerencias_eval"></textarea></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Unidades de Aprendizaje</h2>
											<table>
												<tbody>
													<tr>
														<th>Unidad</th>
														<th>Competencias específicas</th>
														<th>Actividades de aprendizaje</th>
													</tr>
													<tr>
														<td></td>
														<td></td>
														<td></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Fuentes de Información</h2>
											<table>
												<tbody>
													<tr>
														<td><textarea name="fuentes_inf"></textarea></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
									<li>
										<div class="planeacion">
											<h2>Prácticas Propuestas</h2>
											<table>
												<tbody>
													<tr>
														<td><textarea name="practicas_prop"></textarea></td>
													</tr>
												</tbody>
											</table>
										</div>
									</li>
								</ol>

								<div class="contenedorGuardar">
									<input type="submit" class="submit button" name="submit" value="Guardar" />
									<input type="reset" class="reset button" name="reset" value="Cancelar" />											
								</div>
							</form>
						<?php
						
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
				&copy; Copyright  by <?php echo $layout -> getPowerBy();
				unset($layout);
				?>
			</p>
		</footer>
	</body>
</html>