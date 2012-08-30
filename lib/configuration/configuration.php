<?php
	class Configuration
	{
		private $config = array();
		public function __construct($filename)
		{
			$handle = fopen($filename, 'r');
			if($handle)
			{
				while(($buffer = fgets($handle)) !== false)
				{
					
					$key = substr($buffer, 0, strpos($buffer, ' '));
					$value = substr($buffer, strrpos($buffer, '=') + 1);
					$this->config[$key] = trim($value);
				}
				if(!feof($handle))
				{
					echo "Error: fallo inesperado de fgets()\n";
				}
				fclose($handle);
			}
			else {
				echo "No se abrio el archivo";
			}
		}
		
		public function printConfig()
		{
			print_r($this->config);
		}

		public function __get($name)
		{
			if(isset($this->config[$name]))
			{
				return $this->config[$name];
			}
		}

		public function __isset($name)
		{
			return isset($this->config[$name]);
		}

		public function __unset($name)
		{
			unset($this->config[$name]);
		}
	}
?>