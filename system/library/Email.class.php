<?

class Email
{
	public $email = array();
	const LINE_BREAK = '\r\n';
	
	function __construct()
	{

	}
	function From($email)
	{
		$this->email['headers']['from'] = "From:".$email;
		return $this;
	}
	function Cc($emails)
	{
		$this->email['headers']['cc'] = "Cc:".implode(",",$emails);
		return $this;
	}
	function Bcc($emails)
	{
		$this->email['headers']['bcc'] = "Bcc:".implode(",",$emails);
		return $this;
	}
	function Send()
	{
		return mail($this->email['to'], $this->email['subject'], $this->email['body'], implode(self::LINE_BREAK, $this->email['headers']));
	}
	function To($emails)
	{
		if(is_array($emails))
		{
			$this->email['to'] = implode(",", $emails);
		}
		else
		{
			$this->email['to'] = $emails;
		}
		return $this;
	}
	function Subject($text)
	{
		$this->email['subject'] = $text;
		return $this;
	}
	function Body($text)
	{
		$this->email['body'] = $text;
		return $this;
	}
	function Debug()
	{
		print_r($this->email);
	}
}

$g = new Email();
echo $g->To("chris@primecontact.ca")->From("chris@primecontact.ca")->Subject("chris@primecontact.ca")->Body("chris@primecontact.ca")->Debug();

?>