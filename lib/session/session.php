<?php	
	class Session
	{
		const SESSION_STARTED= TRUE;
		const SESSION_NOT_STARTED= FALSE;
		const SESSION_MAXIME_TIME = 60;
	
		private $sessionState;
		private static $instance;
		
		private function __construct()
		{
			$this->sessionState = self :: SESSION_NOT_STARTED;
			if($this->getSID() != "")
				$this->destroy();
			$_SESSION['LAST_ACTIVITY'] = time();
		}
	
		public function getSID()
		{
			return session_id();
		}

	    public static function getInstance()
	    {
	        if ( !isset(self::$instance))
	        {
	            self::$instance = new self;
	        }
	       
	        self::$instance->startSession();
	       
	        return self::$instance;
    }

		public function expireSession()
		{
		    $resto = time() - $_SESSION['LAST_ACTIVITY'];
		    
			if ($resto > self::SESSION_MAXIME_TIME) 
			{
			    $this->destroy();
			    
			    return true;
			}
	
			$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
			
			return false;			
		}
		
		public function startSession()
		{
			if($this->sessionState == self::SESSION_NOT_STARTED)
			{
				$this->sessionState = session_start();
				$_SESSION['LAST_ACTIVITY'] = time() + self::SESSION_MAXIME_TIME;
			}
	
			return $this->sessionState;
		}
	
		public function __set($name, $value)
		{
			$_SESSION[$name]= $value;
		}
	
		public function __get($name)
		{
			if(isset($_SESSION[$name]))
			{
				return $_SESSION[$name];
			}
		}
	
		public function getByKey($name)
		{
			if(isset($_SESSION[$name]))
			{
				return $_SESSION[$name];
			}
			return null;
		}
	
		public function setKeyValue($name, $value)
		{
			$_SESSION[$name]= $value;
		}
	
		public function __isset($name)
		{
			return isset($_SESSION[$name]);
		}
	
		public function __unset($name)
		{
			unset($_SESSION[$name]);
		}
	
		public function destroy()
		{
			if($this->sessionState == self :: SESSION_STARTED)
			{
				$this->sessionState = self :: SESSION_NOT_STARTED;
				if(session_id() != "")
				{
					session_unset();
					$this->sessionState= !session_destroy();
					
				}
	
				return $this->sessionState;
			}
	
			return FALSE;
		}
	}
?>