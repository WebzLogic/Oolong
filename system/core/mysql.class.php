<?

class MySQL
{
	private $db_handle;
	private $query;
	private static $cache = array();
	private static $connections = array();
	
	public function CacheQuery()
	{
		self::$cache[] = $this->query;
	}
	
	public function Connect($localhost, $username, $password, $db)
	{
		self::$connections[$db] = mysql_connect($localhost, $username, $password);
		$this->db_handle = self::$connections[$db];
		mysql_select_db($db);
	}
	
	public function CloseAll()
	{
		if(count(self::$connections) > 0)
		{
			foreach(self::$connections as $connection)
			{
				mysql_close(self::$connections[$connection]);
			}	
		}
		else
		{
			$this->Close();
		}
		$db_handle = null;
	}
	
	public function Close()
	{
		mysql_close($this->db_handle);
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
	
	public function Prepare($statement, $parameters)
	{
		$index = 0;
		foreach($parameters as $param)
		{
			$param = new StringBuilder($param);
			$parameters[$index++] = $param->EscapeString()->StripHTMLTags()->ToString();
		}
		return StringBuilder::StringReplaceMap($statement, '?', $parameters);
	}
	
	public function RowCount()
	{
		return mysql_num_rows($this->query);
	}
	
	public function SwitchConnection($key)
	{
		if(isset(self::$connections[$key]))
		{
			$current_connection = $this->db_handle == self::$connections[$key];
			if(!$current_connection)
			{
				$this->db_handle = self::$connections[$key];
			}
		}
	}
	
	public function IsEmpty()
	{
		return $this->RowCount() == 0;
	}
	
	public function FetchRows()
	{
		return mysql_fetch_row($this->query);
	}
	
	public function GetRow($fields = null)
	{
		if($fields == null)
		{
			return mysql_fetch_assoc($this->query);	
		}
		else
		{
			$row = mysql_fetch_assoc($this->query);
			$altered_row = StringBuilder::EMPTY_STRING;
			if(count($fields) > 1)
			{
				foreach($fields as $field)
				{
					if(isset($row[$field]))
					{
						$altered_row[$field] = $row[$field];
					}
				}	
			}
			else
			{
				$field = $fields[0];
				if(isset($row[$field]))
				{
					$altered_row[$field] = $row[$field];
				}
			}
			
			return $altered_row;
		}
	}
}

?>