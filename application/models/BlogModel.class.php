<?

class BlogModel extends Model
{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function Archives()
	{
		$g = new sql;
		return $g->SelectFrom("COUNT(post_ID) AS post_count, MONTHNAME(post_date) AS post_date_month, YEAR(post_date) AS post_date_year","test")
			 ->GroupBy("post_date_year, post_date_month")
			 ->OrderBy("post_date");
	}
	
	public function GetPosts()
	{
		$g = new sql;
		return $g->SelectFrom(array('post_ID','post_name','post_title','meta_ID'), "hello")->ToString();
	}
	
	public function GetPostsByCategory()
	{
		$g = new sql;
		return $g->SelectFrom(array('post_ID','post_name','post_title','meta_ID'), "hello")->ToString();
	}
}

?>