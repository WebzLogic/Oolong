<?

class FileSystem
{
	private $filepath = "";
	private $files = array();
	
	public static function GetDirectoryFiles($path, $recurse = false, $files = array())
	{
		$handle = dir($path);
		while(($file = $handle->read()) !== false)
		{
			if($file != '.' and $file != '..')
			{
				if($recurse and is_dir($path.$file))
				{
					GetDirectoryFiles($path.$file, true, $files);
				}
				else
				{
					$files[] = $path.$file;
				}
			}
		}
		$handle->close();
	}
	
	public function GetFiles($recurse = false)
	{
		self::GetDirectoryFiles($this->filepath, $recurse, $this->files);
	}
	
	public function FilterByExtension($exclusions = array())
	{
		$destination = array();
		foreach($this->files as $value)
		{
			$parts = pathinfo($value);
			if(!in_array($parts['extension'], $exclusions))
			{
				$destination[] = $value;
			}
		}
	}
}

?>