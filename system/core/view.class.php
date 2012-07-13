<?

class view extends Registry
{
	public function load($view, $data = null)
	{
		include_once "./application/views/".$view.".php";
	}
}

?>