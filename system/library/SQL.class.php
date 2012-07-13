<?

class sql
{
	private $sql = array();
	
	public static function Between($field, $low_end, $high_end)
	{
		return $field." BETWEEN ".$low_end." AND ".$high_end;
	}
	public static function Alias($field, $alias)
	{
		return $field." AS ".$alias;
	}
	
	function CreateTable($table, $fields)
	{
		$this->sql[] = "CREATE TABLE DISTINCT ".$table."(".implode(",",$fields).")";
		return $this;
	}
	
	function Delete($table)
	{
		$this->sql[] = "DELETE FROM ".$table;
		return $this;
	}
	
	function GroupBy($fields = array())
	{
		$this->sql[] = "GROUP BY ".implode(",",$fields);
		return $this;
	}
	
	function InsertInto($table, $data = array())
	{
		$this->sql[] = "INSERT INTO ".$table."(".implode(",",array_keys($data)).") VALUES(".implode(",",array_values($data)).")";
		return $this;
	}
	
	function Join($table, $source_field, $target_field)
	{
		$this->sql[] = "JOIN ".$table." ON ".$source_field."=".$target_field;
		return $this;
	}
	
	function OrderBy($fields = array())
	{
		$this->sql[] = "ORDER BY ".implode(",",$fields);
		return $this;
	}
	
	function SelectFrom($fields = array(), $table)
	{
		$this->sql[] = "SELECT ".implode(",",$fields)." FROM ".$table;
		return $this;
	}
	
	function Where($condition)
	{
		$this->sql[] = "WHERE ".$condition;
		return $this;
	}
	
	function Update($data, $table)
	{
		$this->sql[] = "UPDATE ".$table." SET ".ArrayList::JoinNVPArray($data);
		return $this;
	}
	
	function ToString()
	{
		return implode(' ', $this->sql);
	}
}

?>