<?

define('APPLICATION_PATH',$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']));

include_once "/system/registry.class.php";

function __autoload($class)
{
	include_once "./system/core/".$class.".class.php";
}

include_once "./system/library/sql.class.php";
include_once "./system/library/Arrays.class.php";
include_once "./system/library/StringBuilder.class.php";
include_once "./system/library/FormValidator.class.php";

$registry = Registry::Singleton();

$registry->route = 'Route';
$registry->mysql = 'MySQL';
$registry->model = 'Model';
$registry->load = 'load';
$registry->controller = 'Controller';
$registry->view = 'view';

$registry->mysql->Connect("localhost", "root", "", "test");

if(isset($_GET['url']))
{
	$registry->route->RouteURL($_GET['url']);
}
else
{
	echo 'Fail!';
}

?>