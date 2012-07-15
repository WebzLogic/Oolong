<?

class Stack
{
	private $stack = array();
	public $Length = 0;
	
	public function __construct($array = null)
	{
		if($array != null)
		{
			array_merge($stack, $array);
		}
	}
	
	public function IsEmpty()
	{
		returh $this->Count() == 0;
	}
	
	public function Push($value)
	{
		$this->stack[] = $value;
		return $this;
	}
	
	public function Pop()
	{
		if(!$this->IsEmpty())
		{
			unset($this->stack[$this->Count() - 1]);
		}
		return $this;
	}
	
	public function Peek()
	{
		if(!$this->IsEmpty())
		{
			return $this->stack[$this->Count() - 1];
		}
		else
		{
			return null;
		}
	}
	
	public function Count()
	{
		return $this->Length;
	}
}

?>