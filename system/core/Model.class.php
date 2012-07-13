<?

class Model extends Registry
{
	private static $models = array();
	public function __construct()
	{
		
	}
	public function __get($key)
	{
		return self::$models[$key];
	}
	public function __set($key, $obj)
	{
		if(!in_array($key, self::$models))
		{
			include_once "./application/models/".$obj.".class.php";
			self::$models[$key] = new $obj();
		}
	}
}

?>