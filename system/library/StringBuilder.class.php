<?

class StringBuilder
{
	const CARRIAGE = "\r";
	const EMPTY_STRING = "";
	const NEWLINE = "\n";
	const SPACE = "\s";
	const TAB = "\t";
	
	public $source = self::EMPTY_STRING;
	public $Length = 0;
	
	
	public static function ArraySplice($array, $delimiter)
	{
		return implode($delimiter, $array);
	}
	
	public static function test($a)
	{
		return '//'.$a;
	}
	
	public static function ToStringBuilder($object)
	{
		if(is_string($object))
		{
			return new self($object);	
		}
		return "error";
	}
	
	public static function StringReplaceMap($subject, $old, $replacements)
	{
		$has_replacements = count($replacements) > 0;
		$next_replace_index = 0;
		$new_string = StringBuilder::EMPTY_STRING;
		$used_symbols = array();
		$old_string_length = strlen($old);
		
		if(!($subject == StringBuilder::EMPTY_STRING) && $has_replacements)
		{
			for($index=0; $index<strlen($subject); $index+=1)
			{
				$match = substr($subject, $index, $old_string_length);
				if(StringBuilder::StringsEqual($match,$old))
				{
					$new_string .= $replacements[$next_replace_index++];
				}
				else
				{
					$new_string .= $subject[$index];	
				}
			}
		}
		return $new_string;
	}
	
	public static function StringsEqual($a, $b)
	{
		if(strlen($a) != strlen($b))
		{
			return false;
		}
		else if(!is_string($a) || !is_string($b))
		{
			return false;
		}
		else if(strlen($a) == 1)
		{
			if(ord($a) != ord($b))
			{
				return false;
			}
		}
		else
		{
			for($i=0; $i<strlen($a); $i++)
			{
				if(ord($a[$i]) != ord($b[$i]))
				{
					return false;
				}
			}
		}
		return true;
	}
	
	public static function StringEscapeString($subject)
	{
		$blacklist = array("'",'"','\n','\r');
		return str_replace("'", "\'", $subject);
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
		if(!$this->IsEmpty())
		{
			if($this->Length == 1)
			{
				$this->source = chr(ord($this->source[0])-32);
			}
			else
			{
				if(ord($this->source[0]) >= 97 && ord($this->source[0]) <= 123)
				{
					$this->source = chr(ord($this->source[0])-32).substr($this->source, 1, strlen($this->source));
				}
				$this->Length = strlen($this->source);
			}
		}
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
	
	public function Duplicate()
	{
		return new self($this->source);
	}
	
	public function Contains($substring)
	{
		if(!$this->IsEmpty())
		{
			if(strlen($substring) > $this->Length)
			{
				return false;
			}
			else
			{
				for($index=0; $index < $this->Length-strlen($substring); $index++)
				{
					if(substr($this->source, $index, strlen($substring)) == $substring)
					{
						return true;
					}
				}
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	public function Count()
	{
		return $this->Length;
	}
	
	function Equals($comparison)
	{
		if(strlen($this->source) != strlen($comparison))
		{
			return false;
		}
		else if(!is_string($this->source) || !is_string($comparison))
		{
			return false;
		}
		else if(strlen($this->source) == 1)
		{
			if(ord($this->source) != ord($comparison))
			{
				return false;
			}
		}
		else
		{
			for($i=0; $i<strlen($this->source); $i++)
			{
				if(ord($this->source[$i]) != ord($comparison[$i]))
				{
					return false;
				}
			}
		}
		return true;
	}
	
	public function EscapeString()
	{
		$blacklist = array("'",'"','\n','\r');
		$this->source = str_replace("'", "\'", $this->source);
		return $this;
	}
	
	public function Format($arguments = array())
	{
		$tag = StringBuilder::EMPTY_STRING;
		$index = StringBuilder::EMPTY_STRING;
		$formatted_string = $this->source;
		$tag_is_open = false;
		
		for($i=0; $i<strlen($this->source); $i++)
		{
			$char = $this->source[$i];
			if(StringBuilder::StringsEqual($char, '{') || StringBuilder::StringsEqual($char, '}'))
			{
				$tag .= $char;
				$tag_is_open = !$tag_is_open;
			}
			
			if(StringBuilder::StringsEqual($char, '}'))
			{
				$tag .= '}';
				if(is_int($index))
				{
					$formatted_string = str_replace($tag, $arguments[$index], $formatted_string);
				}
				
				$tag = StringBuilder::EMPTY_STRING;
				$index = StringBuilder::EMPTY_STRING;
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
		$this->source = str_replace(StringBuilder::SPACE, StringBuilder::EMPTY_STRING, $this->source);
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function IsEmpty()
	{
		return $this->Length == 0 && $this->source == StringBuilder::EMPTY_STRING;
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
		if(!$this->IsEmpty())
		{
			$character = StringBuilder::EMPTY_STRING;
			$new_string = StringBuilder::EMPTY_STRING;
			$stop_replace = StringBuilder::EMPTY_STRING;
			
			for($index=0;$index<$this->Length;$index++)
			{
				if(StringBuilder::StringsEqual($this->source[$index],$old) and $stop_replace == false)
				{
					$new_string .= $replacement;
					$stop_replace = true;
				}
				else
				{
					$new_string .= $this->source[$index];		
				}
			}
		}
		return $this;
	}
	
	/* Replaces a character up to the number of values in the array $replacements. If there are more occurrences of the character
	 * than map values, the remaining occurrences will not be replaced. If there are more map values than occurrences of the
	 * character, then the remaining map values will simply be unused. */
	
	public function ReplaceMap($old, $replacements)
	{
		$has_replacements = count($replacements) > 0;
		$next_replace_index = 0;
		$new_string = StringBuilder::EMPTY_STRING;
		$old_string_length = strlen($old);
		
		if(!$this->IsEmpty() && $has_replacements)
		{
			for($index=0; $index<$this->Length-$old_string_length; $index+=1)
			{
				$match = substr($this->source, $index, old_string_length);
				if(StringBuilder::StringsEqual($match,$old))
				{
					$new_string .= $replacements[$next_replace_index++];
				}
				else
				{
					$new_string .= $this->source[$index];	
				}
			}
			$this->source = $new_string;
			$this->Length = strlen($this->source);
		}
		return $this;
	}
	
	public function ReplaceAll($old, $replacement)
	{
		$this->source = str_replace($old, $replacement, $this->source);
		$this->Length = strlen($this->source);
		return $this;
	}
	
	public function Partition($separator, $increment)
	{
		$destination = StringBuilder::EMPTY_STRING;
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
		return $this->Substring(0, strlen($substring))->Equals($substring);
	}
	
	public function Strip($character)
	{
		if(!$this->IsEmpty() and $character != StringBuilder::EMPTY_STRING)
		{
			switch($character)
			{
				case '/':
					$this->source = stripcslashes($this->source);
					break;
				
				case '\\':
					$this->source = stripslashes($this->source);
					break;
				
				default:
					$this->ReplaceAll($character, StringBuilder::EMPTY_STRING);
					break;
			}
		}
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
	
	public function StripHTMLTags()
	{
		$this->source = strip_tags($this->source);
		return $this;
	}
	
	public function EndsWith($substring)
	{
		return $this->Substring($this->Length - strlen($substring), $this->Length)->Equals($substring);
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
					if(($only_unique_allowed && $is_unique) || !$only_uniqued_allowed)
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
	
	public function WithinRange($index)
	{
		return $index >= 0 && $index <= $this->Length - 1;
	}
	
	public function ZeroPad($length)
	{
		$this->Pad('0',$length, true);
		return $this;
	}
}


?>