<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/connection/connection.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/configuration/configuration.php");

	class SGA
	{
		private $conexion;
		private $periodoActual;
		private $maxUnidades;
		
		public function __construct()
		{
			$config = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/configuration/sgc.conf");
			$this->conexion = new Connection($config->hostname, $config->database, $config->username, $config->password);
			$this->maxUnidades = $config->max_unidades;

			$this->conexion->Open();
		}
		
		public function agregarAsistenciaAlumnoEnCurso($periodo, $nu_carrera, $nu_curso, $nu_contexto, $nu_docente, $nombregrupo, $nu_alumno, $fecha, $asistio)
		{
			$sql = "insert into asistencias (nu_periodo, nu_carrera, nu_curso, nu_contexto, nu_docente, nu_grupo, nu_alumno, fecha, asistio)
					values ($nu_periodo, $nu_carrera, $nu_curso, $nu_contexto, $nu_docente, $nu_grupo, $nu_alumno, '$fecha', $asistio)";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				return $query->ExecuteNoQuery();
				
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$sql<br>$message";
				
				return false;	
			}			
		}
		
		public function actualizarInformeTutorias($nu_periodo, $nu_carrera, $nu_curso, $nu_contexto, $nu_docente, 
			$nu_grupo, $nu_semana, $nu_alumno, $reprobacion, $indisciplina, $inasistencia, $no_entrega_trabajo,
			$apoyo_psicologico, $apoyo_economico, $observaciones)
		{
			$sql = "update informes_docentes
					set reprobacion = $reprobacion, indisciplina = $indisciplina, 
						inasistencia = $inasistencia, no_entrega_trabajo = $no_entrega_trabajo, 
						apoyo_psicologico = $apoyo_psicologico, apoyo_economico = $apoyo_economico,
						observaciones = '$observaciones'
					where nu_periodo = $nu_periodo and nu_carrera = $nu_carrera
						and nu_semana = $nu_semana and nu_docente = $nu_docente
						and nu_materia = $nu_materia and nu_contexto = $nu_contexto
						and nu_grupo = '$nu_grupo' and nu_alumno = $nu_alumno";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				return $query->ExecuteNoQuery();
				
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$sql<br>$message";
				
				return false;	
			}			
		}
				
		public function agregarInformeTutorias($nu_periodo, $nu_carrera, $nu_curso, $nu_contexto, $nu_docente, 
			$nu_grupo, $nu_semana, $nu_alumno, $reprobacion, $indisciplina, $inasistencia, $no_entrega_trabajo,
			$apoyo_psicologico, $apoyo_economico, $observaciones)
		{
			$sql = "insert into informes_docentes(nu_periodo, nu_carrera, nu_semana, nu_docente, nu_materia,
						nu_contexto, nu_grupo, nu_alumno, reprobacion, inasistencia, indisciplina, 
						no_entrega_trabajo, apoyo_psicologico, apoyo_economico, observaciones)
					values ($nu_periodo, $nu_carrera, $nu_semana, $nu_docente, $nu_materia, 
						$nu_contexto, $nu_grupo, $nu_alumno, $reprobacion, $inasistencia, $indisciplina,  
						$no_entrega_trabajo, $apoyo_psicologico, $apoyo_economico, '$observaciones')";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				return $query->ExecuteNoQuery();
				
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$sql<br>$message";
				
				return false;	
			}			
		}
		public function ObtenerMaximoNumeroUnidades()
		{
			return $this->maxUnidades;
		}
		
		public function ObtenerPeriodoVigente()
		{
			$sql = "select periodos.nu_periodo, nombre, fe_inicio, fe_final
					from periodos join periodo_carreras_vigentes 
						on (periodos.nu_periodo = periodo_carreras_vigentes.nu_periodo)
					group by periodos.nu_periodo";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				if($query->ExecuteQuery() > 0)
					return new Reader($query->getResult());
				
				return false;
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}
		}
		
		public function AgregarActividad($actividad, $tipo, $nu_docente, $nu_carrera)
		{
			$sql = "insert into actividades (descripcion, tipo, nu_docente, nu_carrera)
					values ('$actividad', $tipo, $nu_docente, $nu_carrera)";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				return $query->ExecuteNoQuery();
				
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}		
		}
		
		public function ObtenerListaActividades($condicion)
		{
			$sql = "SELECT nu_actividad, descripcion, tipo, nu_docente, nu_carrera
					FROM actividades
					where $condicion";

			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				if($query->ExecuteQuery() > 0)
					return new Reader($query->getResult());
				
				return false;
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}		
		}
		
		public function obtenerInstrumentacion($nu_periodo, $nu_carrera, $nu_docente, $nu_curso, $nu_contexto, $nu_grupo)
		{
			$sql = "SELECT nu_instrumentacion, nu_periodo, nu_carrera,         
						nu_docente, nu_materia, nu_contexto, nu_grupo,        
						clave, nu_unidades, satca, caracterizacion, competencias       
					FROM instrumentaciones
					where nu_periodo = $nu_periodo
						and nu_carrera = $nu_carrera
						and nu_docente = $nu_docente
						and nu_materia = $nu_curso
						and nu_contexto = $nu_contexto
						and nu_grupo = $nu_grupo";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				if($query->ExecuteQuery() > 0)
					return new Reader($query->getResult());
				
				return false;
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}					
		}
		
		public function ActualizarInstrumentacion($id, $clave, $nu_unidades, $satca, $caracterizacion, $competencias)
		{
			$sql = "update instrumentaciones
					set clave = '$clave', nu_unidades = $nu_unidades, satca = '$satca', 
						caracterizacion = '$caracterizacion', competencias = '$competencias'
					where nu_instrumentacion = $id";

			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				return $query->ExecuteNoQuery();
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message Consulta: $sql";

				return false;	
			}		
		}
		
		public function AgregarInstrumentacion($periodo, $nu_carrera, $nu_docente, $nu_materia, $nu_contexto, $nombregrupo, $clave, $nu_unidades, $satca, $caracterizacion, $competencias)
		{
			$sql = "insert into instrumentaciones (periodo, nu_carrera, nu_docente, nu_materia, nu_contexto, nombregrupo, clave, nu_unidades, satca, caracterizacion, competencias)
					values ('$periodo', $nu_carrera, $nu_docente, $nu_materia, $nu_contexto, '$nombregrupo', '$clave', $nu_unidades, '$satca', '$caracterizacion', '$competencias')";
			
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				$query->ExecuteNoQuery();
				return $query->LastIDQuery();
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";

				return false;	
			}		
		}

		public function AgregarFechaProgramada($nu_unidad, $nu_instrumentacion, $fe_programada)
		{
			$sql = "insert into fechas_unidades (nu_unidad, nu_instrumentacion, fecha_programada)
					values ($nu_unidad, $nu_instrumentacion, '$fe_programada')";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				$query->ExecuteNoQuery();
				return $query->LastIDQuery();
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";

				return false;	
			}			
		}
		
		public function SemanasCapturadasPorDocente($periodo, $nu_carrera, $nu_docente, $nu_curso, $nu_contexto, $nombregrupo)
		{
			$sql = "select nu_semana 
					from informes_docentes
					where periodo = '$periodo'
						and nu_carrera = $nu_carrera
						and nu_docente = $nu_docente
						and nu_materia = $nu_curso
						and nu_contexto = $nu_contexto
						and nombregrupo = '$nombregrupo'
					group by nu_semana";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				if($query->ExecuteQuery() > 0)
					return new Reader($query->getResult());
				
				return false;
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}
		}

		public function obtenerListaCarreras($nu_periodo)
		{
			$sql = "select carreras.nu_carrera, carreras.nombre
					from carreras, periodos, periodo_carreras_vigentes
					where carreras.nu_carrera = periodo_carreras_vigentes.nu_carrera 
						and periodos.nu_periodo = periodo_carreras_vigentes.nu_periodo
						and periodos.nu_periodo = '$nu_periodo'
					order by carreras.nombre";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				if($query->ExecuteQuery() > 0)
					return new Reader($query->getResult());
				
				return false;
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}
		}

		public function obtenerListaPeriodos()
		{
			$sql = "select nu_periodo, nombre, fe_inicio, fe_final
					from periodos
					order by fe_inicio desc, fe_final desc";
			try
			{
				$query = new Command($this->conexion);
				$query->setCommand($sql);
				if($query->ExecuteQuery() > 0)
					return new Reader($query->getResult());
				
				return false;
			}
			catch(Exception $ex)
			{
				$message = $ex->getMessage();
				$message = "<em><font color='#FF0000'>Error</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}
		}
 	}
?>