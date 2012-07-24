<?

define('APPLICATION_PATH',dirname($_SERVER['SCRIPT_NAME']));

function __autoload($class)
{
	include_once "./system/core/".$class.".class.php";
}

include_once "./system/registry.class.php";

$registry = Registry::Singleton();

include_once "./config.php";
include_once $registry->GetSetting('SYS_FOLDER')."library/sql.class.php";
include_once $registry->GetSetting('SYS_FOLDER')."library/Arrays.class.php";
include_once $registry->GetSetting('SYS_FOLDER')."library/StringBuilder.class.php";
include_once $registry->GetSetting('SYS_FOLDER')."library/FormValidator.class.php";
include_once $registry->GetSetting('SYS_FOLDER')."library/Thumbnail.class.php";
include_once $registry->GetSetting('SYS_FOLDER')."library/post.class.php";

$registry->route = 'Route';
$registry->mysql = 'MySQL';
$registry->model = 'Model';
$registry->load = 'load';
$registry->controller = 'Controller';
$registry->view = 'view';
$registry->post = _POST::Singleton();
$registry->get = _GET::Singleton();


if(isset($_GET['url']))
{
	$registry->route->RouteURL($_GET['url']);
}
else
{
	echo 'Error';
}

?>