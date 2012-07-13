<?

class blogController extends Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->registry->model->blog = 'blogModel';
		$this->registry->load->helper('form');
	}
	
	public function index()
	{	
		echo $this->registry->model->blog->Archives();
		$this->registry->view->load('blog/welcome');
	}
	
	public function search()
	{
		$this->registry->model->blog->GetPosts();
		$this->registry->view->load('blog/welcome');
	}
}

?>