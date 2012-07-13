<?

class MySQL
{
	private $db_handle;
	private $query;
	private static $cache = array();
	
	public function CacheQuery()
	{
		self::$cache[] = $this->query;
	}
	
	public function Connect($localhost, $username, $password, $db)
	{
		$this->db_handle = mysql_connect($localhost, $username, $password);
		mysql_select_db($db);
	}
	
	public function Error()
	{
		mysql_error($this->db_handle);
	}
	
	public function ExecuteQuery($query, $cache_query = false)
	{
		$this->query = mysql_query($query, $this->db_handle);
		if($cache_query)
		{
			$this->CacheQuery();
		}
	}
	
	public function GetCachedQuery($key)
	{
		return self::$cache[$key];
	}
	
	public function RowCount()
	{	
		return mysql_num_rows($this->query);
	}
	public function FetchRows()
	{
		return mysql_fetch_row($this->query);
	}
}

?>