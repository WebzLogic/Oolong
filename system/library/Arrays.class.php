<?

class ArrayList
{
	private $source = array();
	
	public static function IsArray($array)
	{
		return is_array($array);
	}

	public static function Split($string, $separator)
	{
		return new ArrayList(explode($separator, $string));
	}
	
	public static function ToArrayList($source)
	{
		return new self($source);
	}

	public function __construct($source = null)
	{
		if(is_array($source))
		{
			$this->source = $source;
		}
		else if(!is_array($source) && $source != null)
		{
			$this->source[] = $source;
		}
	}
	
	public function Average()
	{
		return $this->Sum()/$this->Size();
	}
	
	public function Append($value)
	{
		$this->source[] = $value;
		return $this;
	}
	
	public function Compact()
	{
		return $this->Filter();
	}
	
	public function Contains($value)
	{
		return in_array($value, $this->source);
	}
	
	public function Filter($callback = null)
	{
		$filter = array();
		foreach($this->source as $value)
		{
			if(function_exists($callback))
			{
				if($comparison($value))
				{
					$filter[] = $value;
				}
			}
			else
			{
				switch($callback)
				{
					case 'EMPTY':
						$comparison = empty($value);
					case 'NULL':
						$comparison = ($value == null);
					default:
						$comparison = empty($value) || ($value == null);
				}
				
				if(!$comparison)
				{
					$filter[] = $value;
				}
			}
		}
		
		$this->source = $filter;
		return $this;
	}
	
	public function Intersect($array)
	{
		$intersection = array();
		foreach($this->source as $a)
		{
			foreach($array as $b)
			{
				$is_unique = !in_array($a, $intersection);
				if($a == $b && $is_unique)
				{
					$intersection[] = $a;
				}
			}
		}
		return new self($intersection);
	}
	
	public function Frequency()
	{
		$frequencies = array();
		foreach($this->source as $value)
		{
			$key = "'".$value."'";
			if($frequencies[$key] >= 1)
			{
				$frequencies[$key] ++;
			}
			else
			{
				$frequencies[$key] = 1;
			}
		}
		return new self($frequencies);
	}
	
	public function IsUnique()
	{
		foreach($this->Frequency() as $key => $value)
		{
			if($value > 1)
			{
				return false;
			}
		}
		return true;
	}
	
	public function Keys()
	{
		return self::ToArrayList(array_keys($this->source));
	}
	
	public function Map($callback = null)
	{
		array_map($callback, $this->source);
		return $this;
	}
	
	public function Merge($merge)
	{
		array_merge($this->source, $merge);
		return $this;
	}
	
	public function Reduce($callback)
	{
		if(function_exists($callback))
		{
			for($i=0; $i<$this->Count(); $i++)
			{
				$callback($this->source[$i], $reduce);
			}
		}
	}
	
	public function Reverse()
	{
		array_reverse($this->_array);
		return $this;
	}
	
	public function Size()
	{
		return count($this->source);
	}
	
	public function Sum()
	{
		$sum = 0;
		foreach($this->source as $value)
		{
			$sum += $value;
		}
		return $sum;
	}
	
	public function Sort($callback = null)
	{
		if(function_exists($callback))
		{
			usort($this->source, $callback);
		}
		return $this;
	}
	
	public function Swap($first, $second)
	{
		$temp = $array[(int)$first];
		$array[(int)$first] = $array[(int)$second];
		$array[(int)$second] = $temp;
		return $this;
	}	
	
	public function ToArray()
	{
		return $this->source;
	}
	
	public function Unique()
	{
		return $this->Frequency()->Keys();
	}
	
	public function Value($index)
	{
		if($index >= 0 && $index < $this->Size())
		{
			return $this->source[$index];
		}
	}
	
	public function __get($v)
	{
		return $this->Value($v);
	}
	
	public function __set($key, $value)
	{
		return $this->source[$key] = $value;
	}
}

?>