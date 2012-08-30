<?php
	require_once ($_SERVER["DOCUMENT_ROOT"] . "/lib/configuration/configuration.php");
	require_once ($_SERVER["DOCUMENT_ROOT"] . "/layout/menu.php");

	class Layout
	{
		private $config;
		private $hojaDeEstilo;
		private $path_styles;
		
		public function __construct()
		{
			$this->config = new Configuration(substr($_SERVER["DOCUMENT_ROOT"], 0, strrpos($_SERVER["DOCUMENT_ROOT"], "/")) . "/configuration/sgc.conf");
			$this->path_styles = "http://" . $_SERVER["SERVER_NAME"] . "/styles/";
			$this->hojaDeEstilo = "styles.css";
		}
		
		public function generarLiga($nombre, $url, $parametros)
		{
			$servidor = $_SERVER["SERVER_NAME"];
			$liga = "<a href=\"http://$servidor/$url?$parametros\" >$nombre</a>";
			
			return $liga;
		}
		
		public function generarLigaSP($nombre, $url)
		{
			$servidor = $_SERVER["SERVER_NAME"];
			$liga = "<a href=\"http://$servidor/$url\">$nombre</a>";
			
			return $liga;
		}

		public function generarLigaBoton($nombre, $url, $parametros)
		{
			$servidor = $_SERVER["SERVER_NAME"];
			$liga = "<div class=\"botonLink\">
						<a href=\"http://$servidor/$url?$parametros\" >$nombre</a>
				</div>";
									
			return $liga;
		}

		public function generarBotonRegresar($nombre="Regresar")
		{
			$servidor = $_SERVER["HTTP_REFERER"];
			$liga = "
				<div class=\"botonLink\">
					<a href=\"$servidor\" >$nombre</a>
				</div>";
				
			return $liga;
		}
				
		public function getHeader($userid, $role, $roleTutor, $roleRootSGC)
		{
			echo "<header>";
//				<div class="navegacion">
			getMenu($userid, $role, $roleTutor, $roleRootSGC);
//				</div>
			echo "</header>";
		}
		
		public function getSiteName()
		{
			return $this->config->sitename;
		}	
		
		public function getPowerBy()
		{
			return $this->config->powerby;
		}	

		public function Redireccionar($url, $tiempo = 0)
		{
		?>
			<script type="text/javascript">
				function redireccionar() 
				{
					window.location = "<?php echo $url ?>";
				}
	
				setTimeout ("redireccionar()", <?php echo $tiempo; ?>);
			</script>
		<?php			
		}

		public function RedireccionarSGA($url, $tiempo = 0)
		{
			$this->Redireccionar("http://" . $_SERVER['SERVER_NAME'] . $url, $tiempo);
		}
		
		public function ObtenerHojaDeEstilo()
		{
			return $this->path_styles . $this->hojaDeEstilo;
		}
		
		public function ObtenerLigaShareSquareWikiMedia()
		{
			?>
				<a href="https://wikimediafoundation.org/wiki/Support_Wikipedia/en">
					<img border="0" alt="Support Wikipedia" src="//upload.wikimedia.org/wikipedia/commons/d/d3/Fundraising_2009-square-share-en.png" />
				</a>
			<?php
		}
		
		public function ObtenerLigaThanksSquareWikiMedia()
		{
			?>
				<a href="https://wikimediafoundation.org/wiki/Support_Wikipedia/en">
					<img border="0" alt="Support Wikipedia" src="//upload.wikimedia.org/wikipedia/commons/2/26/Fundraising_2009-square-thanks-en.png" />
				</a>
			<?php
		}
				
		public function ObtenerBannerWikiMedia()
		{
			?>
				<a href="https://wikimediafoundation.org/wiki/Support_Wikipedia/en">
					<img border="0" alt="Support Wikipedia" src="//upload.wikimedia.org/wikipedia/commons/4/41/Fundraising_2009-horizontal-thanks-en.png" />
				</a>
			<?php
		}
	}
?>