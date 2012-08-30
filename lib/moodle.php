<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/connection/connection.php");
	require_once($_SERVER["DOCUMENT_ROOT"] . "/lib/configuration/configuration.php");

	class Moodle
	{
		private $config;
		private $conexion;
		
		public function __construct() 
		{
			dirname($_SERVER["DOCUMENT_ROOT"]);
			
 			$this->config = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/configuration/moodle.conf");
			$this->conexion = new Connection($this->config->hostname, $this->config->database, $this->config->username, $this->config->password);

			$this->conexion->Open();
		}
		
		public function NombreCarrera($careerid) 
		{
			$sql = "select name
					from mdl_course_categories
					where id = $careerid";
			
			$query = new Command($this->conexion);
			$query->setCommand($sql);
			$count = $query->ExecuteQuery();
			$reader = new Reader($query->getResult());
			
			if($count > 0)
			{
				$reader->NextByName();
				
				return htmlentities($reader->name);
			}
			
			return null;
		}
		
		public function NombreUsuario($id, $upper = true) 
		{
			$campo = "";
			if($upper)
				$campo = "upper(concat(firstname, ' ', lastname))";
			else
				$campo = "concat(firstname, ' ', lastname)";

			$sql = "select $campo as username
					from mdl_user
					where id = $id";
			
			$query = new Command($this->conexion);
			$query->setCommand($sql);
			$count = $query->ExecuteQuery();
			$reader = new Reader($query->getResult());
			
			if($count > 0)
			{
				$reader->NextByName();
				
				return htmlentities($reader->username);
			}
			
			return null;
		}

		public function NombreMateria($courseid, $upper = true) 
		{
			$campo = "";
			if($upper)
				$campo = "upper(fullname)";
			else
				$campo = "fullname";

			$sql = "select $campo as coursename
					from mdl_course
					where id = $courseid";
			
			$query = new Command($this->conexion);
			$query->setCommand($sql);
			$count = $query->ExecuteQuery();
			$reader = new Reader($query->getResult());
			
			if($count > 0)
			{
				$reader->NextByName();
				
				return htmlentities($reader->coursename);
			}
			
			return null;
		}

		
		public function obtenerGruposDeCursoDocente($idcurso, $idcontexto, $iddocente)
		{
			$sql = "select mdl_groups.id as idgrupo, mdl_groups.name as grupo, 
					mdl_groups.description as descripcion
				from mdl_groups, mdl_groups_members, mdl_groupings, 
					mdl_groupings_groups, course_members
				where mdl_groupings.courseid = course_members.idcurso
					and mdl_groupings.id = mdl_groupings_groups.groupingid
					and mdl_groups.id = mdl_groupings_groups.groupid
					and mdl_groups_members.groupid = mdl_groups.id 
					and course_members.idcurso = $idcurso
					and course_members.idusuario = $iddocente
					and course_members.idcontexto = $idcontexto
					group by idgrupo, grupo";
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
		
		public function obtenerCursosDeDocente($nu_docente)
		{
			$sql = "select idcurso, idcontexto, nombrecurso
					from course_members
					where idusuario = $nu_docente
						and rol = 'editingteacher'
						and activo = 1";
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
		
		public function obtenerCarreraCurso($nu_curso)
		{
			$sql = "SELECT mdl_course_categories.id as idcarrera, 
						mdl_course_categories.name as carrera
					FROM mdl_course join mdl_course_categories 
						on (mdl_course.category = mdl_course_categories.id)
					where mdl_course.id = $nu_curso";
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
		
		public function obtenerAlumnosPorCursoGrupo($idcurso, $idcontexto, $iddocente, $idgrupo)
		{
			$sql = "select mdl_groups.id as idgrupo, mdl_groups.name as grupo, 
						course_members.idusuario as idalumno, username as matricula, nombre, apellidos
					from mdl_groups_members, mdl_groups, mdl_groupings, 
						mdl_groupings_groups, course_members, mdl_user
					where course_members.idusuario = mdl_user.id
						and mdl_groupings.courseid = course_members.idcurso
						and mdl_groupings.id = mdl_groupings_groups.groupingid
						and mdl_groups.id = mdl_groupings_groups.groupid
						and mdl_groups_members.groupid = mdl_groups.id 
						and mdl_groups_members.userid = course_members.idusuario
						and course_members.rol = 'student'
						and mdl_groups.id = $idgrupo
						and (course_members.idcurso, course_members.idcontexto) in 
						(
							select idcurso, course_members.idcontexto
							from course_members
							where rol = 'editingteacher'
								and idusuario = $iddocente
								and idcurso = $idcurso
								and idcontexto = $idcontexto
						)
					group by course_members.idusuario, apellidos, nombre, mdl_groups.name
					order by apellidos, nombre";

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

		public function validarUsuario($username, $password)
		{
			$cadena = $password . $this->config->passwmd5;
			$sql = "select id, concat(mdl_user.firstname, ' ', mdl_user.lastname) as fullname
					from mdl_user
					where username = '$username'
						and md5('$cadena') = password
					group by id";
				
			//echo $sql;
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
		
		public function validarDocenteDesdeMoodle($id, $usuario, $email)
		{
			$sql = "select idusuario, nombre, apellidos, rol, nombrerol
					from mdl_user join course_members on (mdl_user.id = course_members.idusuario)
					where rol = 'editingteacher'
						and id = $id 
						and username = '$usuario'
						and email = '$email'
					group by idusuario";		
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
				$message = "<em><font color='#FF0000'>Error en " . __FILE__ . "</em>: <h4>$message</font></h4>";
				echo "$message";
				
				return false;	
			}
		}

		public function validarDocente($usuario)
		{
			$sql = "SELECT idusuario, nombre, apellidos, rol, nombrerol
					FROM course_members
					where idusuario = $usuario
						and rol = 'editingteacher'
					group by idusuario";
			//echo $sql;
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

		public function ValidarTutor($usuario)
		{
			$sql = "select mdl_role.shortname
					from mdl_user, mdl_role, mdl_role_assignments, mdl_context
					where mdl_role.id = mdl_role_assignments.roleid
						and mdl_role_assignments.userid = mdl_user.id
						and mdl_role_assignments.contextid = mdl_context.id
						and mdl_role.shortname = 'tutor'
						and mdl_user.id = $usuario";
						
			//echo $sql;
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

		public function ValidarAdministradorSGC($usuario)
		{
			$sql = "select mdl_role.shortname
					from mdl_user, mdl_role, mdl_role_assignments, mdl_context
					where mdl_role.id = mdl_role_assignments.roleid
						and mdl_role_assignments.userid = mdl_user.id
						and mdl_role_assignments.contextid = mdl_context.id
						and mdl_role.shortname = 'root'
						and mdl_user.id = $usuario";

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

		public function __destruct() 
		{
			$this->conexion->Close();
		}
			
	}
?>