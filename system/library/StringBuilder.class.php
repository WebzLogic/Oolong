<?

class StringBuilder
{
	public $source = "";
	public $Length = 0;
	
	public static function ArraySplice($array, $delimiter)
	{
		return implode($delimiter, $array);
	}
	
	public function __construct($source = null)
	{
		if($source != null)
		{
			$this->source = $source;
			$this->Length = strlen($this->source);
		}
	}
	
	public function Append($value) 
	{
		$this->source .= $value;
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function Capitalize()
	{
		if(ord($this->source[0]) >= 97 && ord($this->source[0]) <= 123)
		{
			$this->source = chr(ord($this->source[0])-32).substr($this->source, 1, strlen($this->source));
		}
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function CapitalizeAllWords()
	{
		return ucword($this->source);
	}
	
	public function Chunk($length)
	{
		return chunk_split($this->source, $length);
	}
	
	public function Count()
	{
		return $this->Length;
	}
	
	public function Format($arguments = array())
	{
		$tag = "";
		$formatted_string = $this->source;
		$tag_is_open = false;
		$index = "";
		for($i=0; $i<strlen($this->source); $i++)
		{
			$char = $this->source[$i];
			if($char == '{')
			{
				$tag .= '{';
				$tag_is_open = true;
			}
			else if($char == '}')
			{
				$tag .= '}';
				$tag_is_open = !$tag_is_open;
				$index = (int) $index;
				$formatted_string = str_replace($tag, $arguments[$index], $formatted_string);
				$tag = "";
				$index = "";
			}
			else if($tag_is_open)
			{
				$tag .= $char;
				$index .= $char;
			}
		}
		$this->Length = strlen($this->source);
		return new self($formatted_string);
	}
	
	public function InnerTrim()
	{
		$this->source = str_replace(" ", "", $this->source);
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function IndexOf($substring, $all = false)
	{
		
	}
	
	public function IsEmpty()
	{
		return $this->Length == 0 && $this->source == "";
	}
	
	public function LowerCase()
	{
		$this->source = strtolower($this->source);
		$this->Length = strlen($this->source);
		return $this;
	}

	public function Prepend($value)
	{
		$this->source = $value.$this->source;
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function Replace($old, $replacement)
	{
		$this->source = str_replace($old, $replacement, $this->source);
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function Partition($separator, $increment)
	{
		$destination = "";
		for($i=0; $i<strlen((string) $this->source); $i++)
		{
			$end_of_partition = ($i % $increment == 0);
			$valid_index = ($i > 0);
			if($end_of_partition && $valid_index)
			{
				$destination .= $separator;
			}
			$destination .= $this->source[$i];
		}
		$this->source = $destination;
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function Split($separator)
	{
		$this->Length = strlen($this->source);
		return explode($separator, $this->source);
	}
	
	public function Substring($start, $length)
	{
		if($this->WithinRange($start, $length-1) && !$this->IsEmpty())
		{
			return new self(substr($this->source, $start, $length));
		}
	}
	
	public function StartsWith($substring)
	{
		return $this->Substring(0, strlen($substring))->ToString() == $substring;
	}
	
	public function EndsWith($substring)
	{
		return $this->Substring($this->Length - strlen($substring), $this->Length)->ToString() == $substring;
	}
	
	public function Pad($substring, $length, $prepend = false)
	{
		$difference_not_zero = ($length - $this->Length) > 0;
		
		if($difference_not_zero)
		{
			if(!$prepend)
			{
				$this->Append(str_repeat($substring, $length-$this->Length));
			}
			else
			{
				$this->Prepend(str_repeat($substring, $length-$this->Length)); 
			}
		}
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function Reverse()
	{
		strrev($this->source);
		return $this;
	}
	
	public function StripDigits()
	{
		$digits = "0123456789";
		for($i=0; $i<strlen($digits); $i++)
		{
			$this->source = str_replace($digits[$i],"",$this->source);
		}
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function ToAscii($only_unique_allowed = false)
	{
		if(!$this->IsEmpty())
		{
			if($this->Length == 1)
			{
				return ord($this->source);
			}
			else
			{
				$ascii_values = array();
				for($character=0; $character<$this->Count(); $character++)
				{
					$is_unique = !in_array(ord($this->source[$character]), $ascii_values);
					if($only_unique_allowed && $is_unique)
					{
						$ascii_values[] = ord($this->source[$character]);
					}
					else if(!$only_unique_allowed)
					{
						$ascii_values[] = ord($this->source[$character]);
					}
				}
				return $ascii_values;
			}
		}
	}
	
	public function ToString()
	{
		return $this->source;
	}
	
	public function Trim()
	{
		trim($this->source);
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function UpperCase()
	{
		$this->source = strtoupper($this->source);
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function WithinRange($start, $finish)
	{
		return $start >= 0 && $finish <= $this->Length - 1;
	}
	
	public function ZeroPad($length)
	{
		$this->Pad('0',$length, true);
		return $this;
	}
}

?>