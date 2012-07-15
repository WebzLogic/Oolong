<?

class Pagination
{
	private $page_number;
	private $page_count;
	private $per;
	private $size;
	
	public function Per($per)
	{
		$this->per = $per;
		return $this;
	}
	
	public function IsEmpty()
	{
		return $this->Size() > 0;
	}
	
	public function Size($size)
	{
		$this->size = $size;
		return $this;
	}
	
	public function Paginate($page_number)
	{	
		$this->page_number = $page_number;
		$this->page_count = (int) (($this->size / $this->per) + 1);
		$remainder = $this->size % $this->per;
		
		if($this->!IsEmpty())
		{
				
			$last_page = ($this->page_number == $this->page_count);
			
			if($this->size <= $this->per)
			{
				return ['start'=>0,'end'=>$this->per];
			}
			else if($this->size > $this->per && !$last_page)
			{
				return ['start'=>$this->per*($this->page_number-1), 'end'=>$this->per*$this->page_number];
			}
			else if($last_page)
			{
				$no_residue = ($remainder == 0);
				if($no_residue)
				{
					return ['start'=>$this->per*($this->page_count-1), 'end'=>$this->per*$this->page_count];
				}
				else
				{
					return ['start'=>$this->per*($this->page_count-1), 'end'=>($this->per*($this->page_count-1))+$remainder];
				}
			}
		}
		else
		{
			return null;
		}
	}	
}