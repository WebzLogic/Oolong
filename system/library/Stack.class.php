<?

class Stack
{
	private $stack = array();
	public $Length = 0;
	
	public function __construct()
	{
	}
	
	public function Push($value)
	{
		$this->stack[] = $value;
		return $this;
	}
	
	public function Pop()
	{
		if($this->Count() > 0)
		{
			unset($this->stack[$this->Count() - 1]);
		}
		return $this;
	}
	
	public function Peek()
	{
		if($this->Count() > 0)
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

$stack = new Stack();
echo $stack->Push("hello")
		   ->Push("jegs")
		   ->Push("sdad")
		   ->Push("sadad")
		   ->Peek();
echo $stack->Pop()
		   ->Pop()
		   ->Peek();
?>