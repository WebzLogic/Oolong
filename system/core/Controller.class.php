<?

class Controller extends Registry
{
	protected $registry;
	public function __construct()
	{
		$this->registry = Registry::$instance;
	}
}

?>