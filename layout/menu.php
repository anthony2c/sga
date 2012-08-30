<?php

	function getMenuDocentes($userid, $role)
	{
		if(isset($userid) and isset($role))
		{
			if($role == 'editingteacher')
			{
			?>
				<li class="marcoNavegacion"><p>Docentes</p>
					<ul>
						<li>
							<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/course/list.php" >
								Cursos
							</a>
						</li>
					</ul>
				</li>
			<?php
			}
		}
	}

	function getMenuAdministradores($userid, $role)
	{
		if(isset($userid) and isset($role))
		{
			if($role == 'root')
			{
			?>
				<li class="marcoNavegacion"><p>Administradores</p>
					<ul>
						<li>
							<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/admin/perido.php" >
								Periodos
							</a>
						</li>
						<li>
							<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/admin/cursos.php" >
								Cursos
							</a>
						</li>
					</ul>
				</li>
			<?php
			}
		}
	}

	function getMenuTutores($userid, $role)
	{
		if(isset($userid) and isset($role))
		{
			if($role == 'tutor')
			{
		?>
			<li class="marcoNavegacion"><p>Tutores</p>
				<ul>
					<li>
						<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/tutors/reportlist.php" >
								Reportes
						</a>
					</li>
				</ul>
			</li>
		<?php
			}
		}			
	}
	
	function getMenuLogin($userid)
	{
		?>
			<li>
				<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>">Inicio</a>
			</li>
		<?php
		if(isset($userid))
		{
		?>
			<li>
				<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/login/index.php?action=logout">Salir</a>				
			</li>
		<?php		
		}
		else
		{
		?>
			<li>
				<a href="http://<?php echo $_SERVER["SERVER_NAME"]; ?>/login/index.php?action=login">Iniciar sesi&oacute;n</a>
			</li>
		<?php
		}
	}
		
	function getMenu($userid, $role, $roleTutor, $roleRootSGC)
	{
		?>
			<nav>
				<ul>
					
					<?php getMenuDocentes($userid, $role); ?>						

					<?php getMenuTutores($userid, $roleTutor); ?>

					<?php getMenuAdministradores($userid, $roleRootSGC); ?>						

					<?php getMenuLogin($userid); ?>
				</ul>
			</nav>
		<?php					
	}
?>