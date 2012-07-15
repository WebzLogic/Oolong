<?

class route extends Registry
{
	public function RouteURL($query_string)
	{
		$parts = explode("/",$query_string);
		$app = $parts[0];
		$action = (isset($parts[1]) || empty($parts[1])) ? $parts[1]: "index";
		$arguments = array_slice($parts, 2, count($parts));

		$controller_filename = '/application/controllers/'.$app.'Controller.class.php';
		//if(file_exists($controller_filename))
		//{
				include_once '/application/controllers/'.$app.'Controller.class.php';
			
				if(class_exists($app.'Controller'))
				{
					Registry::$instance->controller->$app = $app.'Controller';
					
					$action = (!method_exists(Registry::$instance->controller->$app, $action)) ? "index": $action;
					Registry::$instance->controller->$app->$action($arguments);
				}
		//}
	}
}

?>