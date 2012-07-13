<?

class ArrayList
{
	private static $list = array();
	private $source = array();

	public static function BubbleSortArray($source, $callback = null)
	{
		$temp = "";	
		for($passes=0; $passes<count($source); $passes++)
		{
			for($index=0; $index<count($source); $index++)
			{
				$comparison = ($callback == null || !function_exists($callback)) ? $source[$index] > $source[$index+1]: $callback;
				if($comparison)
				{
					$temp = $source[$index];
					$source[$index] = $source[$index+1];
					$source[$index+1] = $temp;
				}
			}
		}
		return new ArrayList($source);
	}
	
	public static function IsArray($array)
	{
		return is_array($array);
	}
	
	public static function QuickSort($array, $sorted)
	{
		$less = array();
		$greater = array();
		
		$locus = $array[rand(0, count($array))];

		foreach($array as $value)
		{
			if($value <= $locus)
			{
				$less[] = $value;
			}
			else if($value > $locus)
			{
				$greater[] = $value;
			}
		}
		
		if(count($less) > 1)
		{
			self::QuickSort($less, $sorted);
		}
		else if(count($less) == 1)
		{
			$sorted[] = $less[0];
		}
		
		$sorted[] = $locus;
		
		if(count($greater) > 1)
		{
			self::QuickSort($greater, $sorted);
		}
		else if(count($greater) == 1)
		{
			$sorted[] = $greater[0];
		}
		
		return $sorted;
	}

	public static function Split($string, $separator)
	{
		return new ArrayList(explode($separator, $string));
	}
	
	public static function ToArrayList($source)
	{
		return new self($source);
	}
	
	/* Member Functions */
	
	public function __construct($source = null)
	{
		if($source != null)
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
	
	public function BinarySearch($start, $finish, $value)
	{
		if(ArrayList::IsArray($this->source))
		{
			static $is_found = false;
			$middle_index = floor(($finish-$start)/2);
			$middle_value = $this->source[$middle_index];
		
			if($value == $middle_value || $start == $finish)
			{
				$is_found = true;
			}
			else
			{
				if($value < $middle_value)
				{
					$this->BinarySearch($start, $middle_index - 1, $value);
				}
				else if($value > $middle_value)
				{
					$this->BinarySearch($middle_index + 1, $finish, $value);
				}
			}
			return $is_found;
		}
		else
		{
			return false;
		}
	}
	
	public function BubbleSort($callback = null)
	{
		return ArrayList::BubbleSortArray($this->source, $callback);
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
				if($a == $b && !in_array($a, $intersection))
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
		if(function_exists($callback))
		{
			for($i=0; $i<count($this->source); $i++)
			{
				$this->source[$i] = $callback($this->source[$i]);
			}
		}
		return $this;
	}
	
	public function Merge($merge)
	{
		array_merge($merge, $this->source);
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
			sort($this->source, $callback);
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
}

?>