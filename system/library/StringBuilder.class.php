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
		}
	}
	
	public function Append($value) 
	{
		$this->source .= $value;
		return $this;
	}
	
	public function Capitalize()
	{
		if(ord($this->source[0]) >= 97 && ord($this->source[0]) <= 123)
		{
			$this->source = chr(ord($this->source[0])-32).substr($this->source, 1, strlen($this->source));
		}
		return $this;
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
		return new self($formatted_string);
	}
	
	public function InnerTrim()
	{
		$this->source = str_replace(" ", "", $this->source);
		return $this;
	}

	public function LowerCase()
	{
		$this->source = strtolower($this->source);
		return $this;
	}

	public function Prepend($value)
	{
		$this->source = $value.$this->source;
		return $this;
	}
	
	public function Replace($old, $replacement)
	{
		$this->source = str_replace($old, $replacement, $this->source);
		return $this;
	}
	
	public function Separate($separator, $increment)
	{
		$destination = "";
		for($i=0; $i<strlen((string) $this->source); $i++)
		{
			if($i % $increment == 0 && $i > 0)
			{
				$destination .= $separator;
			}
			$destination .= $this->source[$i];
		}
		$this->source = $destination;
		return $this;
	}
	
	public function Substring($start, $length)
	{
		$this->source = substr($this->source, $start, $length);
		return $this;
	}
	
	public function StripDigits()
	{
		$digits = "0123456789";
		for($i=0; $i<strlen($digits); $i++) { $this->source = str_replace($digits[$i],"",$this->source); }
		return $this;
	}
	
	public function ToString()
	{
		return $this->source;
	}
	
	public function Trim()
	{
		trim($this->source);
		return $this;
	}
	
	public function UpperCase()
	{
		$this->source = strtoupper($this->source);
		return $this;
	}
}

?>