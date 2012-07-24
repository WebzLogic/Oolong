<?

class Registry
{
	protected static $instance;
	private static $objects = array();
	private static $settings = array();
	
	public static function Singleton()
	{
		if(!isset(Registry::$instance))
		{
			$class = __CLASS__;
			Registry::$instance = new $class();
			
			return Registry::$instance;
		}
	}
	
	private function __clone()
	{
		echo "Failed!";	
	}
	
	public function __get($key)
	{
		return $this->GetObject($key);
	}
	
	public function __set($key, $value)
	{
		$this->SetObject($key, $value);
	}
	
	public function SetObject($key, $obj)
	{
		if(!in_array($key, Registry::$objects))
		{
			Registry::$objects[$key] = new $obj();
		}
	}
	
	public function GetObject($key)
	{
		return Registry::$objects[$key];
	}
	
	public function StoreSetting($key, $value)
	{
		if(!in_array($key, Registry::$settings))
		{
			Registry::$settings[$key] = $value;
		}
	}
	
	public function GetSetting($key)
	{
		return Registry::$settings[$key];
	}
}

?>