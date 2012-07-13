<?

class File
{
	public $original_text = array();
	public $editted_text = array();
	public $editted_line_numbers = array();
	
	public __construct($path)
	{
		$handle = fopen($path, "r");
		while(!feof($handle))
		{
			$this->original_text[] = fgets($handle);
		}
		fclose($handle);
	}
	public function BubbleSort()
	{
		
	}
	public function GetLine($a)
	{
		return $this->editted_text[$a];
	}
	public function SwapLines($a, $b)
	{
		$temp = $this->editted_text[$a];
		$this->editted_text[$a] = $this->editted_text[$b];
		$this->editted_text[$b] = $temp;
		
		$this->editted_line_numbers[] = $a;
		$this->editted_line_numbers[] = $b;
	}
	public function Synchronize()
	{
		for($i=0; $i<count($this->editted_line_numbers); $i++)
		{
			$editted_line = $this->editted_line_numbers[$i];
			if($this->GetLine($i) !== $this->original_text[$editted_line])
			{
			
				//array_insert($this->original_text, $this->GetLine($i));
			}
		}
	}
}

?>