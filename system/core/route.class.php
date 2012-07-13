<?

class route extends Registry
{
	public function RouteURL($query_string)
	{
		$parts = explode("/",$query_string);
		$app = $parts[0];
		$action = (isset($parts[1]) || empty($parts[0])) ? $parts[1]: "index";
		$arguments = array_slice($parts, 2, count($parts));

		include_once '/application/controllers/'.$app.'Controller.class.php';
	
		if(class_exists($app.'Controller'))
		{
			Registry::$instance->controller->$app = $app.'Controller';
			
			$action = (!method_exists(Registry::$instance->controller->$app, $action)) ? "index": $action;
			Registry::$instance->controller->$app->$action();
		}
		else
		{
			print "<span style='color: red'>class doesn't exist</span>";	
		}
	}
}

?>