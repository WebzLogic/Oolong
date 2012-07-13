<?

class FormValidator
{
	public $errors = array();
	public $error_messages = array();
	
	public function __construct()
	{
		$this->error_messages['Required'] = "Please enter your %s.";
		$this->error_messages['TooShort'] = "Your %s is too short. It must be at least %d characters long.";
		$this->error_messages['TooLong'] = "Your %s is too long. It must be at most %d characters long.";
		$this->error_messages['OutOfRange'] = "Your %s must be between %d characters and %d characters.";
		$this->error_messages['DontMatch'] = "The %s and the %s don't match.";
		$this->error_messages['HasNumbers'] = "Your %s shouldn't contain numbers.";
		$this->error_messages['HasLetters'] = "Your %s shouldn't contain letters.";
	}
	
	public function ResetErrorMessages($msgs = array())
	{
		foreach($msgs as $key => $value) 
		{
			if(in_array($key, $this->error_messages[$key]) && $this->error_messages[$key] != $value)
			{
				$this->error_messages[$key] = $value;
			}
		}
	}
	
	public function SetRequiredFields($fields)
	{
		foreach($fields as $key => $value)
		{
			$this->SetFieldRules($key, $value, array("Required"));
		}
	}
	
	public function SetFieldRules($field, $field_text, $rules = array())
	{
		if(in_array('Required',$rules) && empty($_POST[$field]))
		{
			$this->errors[] = sprintf($this->error_messages['Required'], $field_text);
		}
		if(isset($rules['MinLength']) && (strlen($_POST[$field]) < $rules['MinLength']  && !empty($_POST[$field])))
		{
			$this->errors[] = sprintf($this->error_messages['TooShort'], $field_text, $rules['MinLength']);
		}
		if(isset($rules['MaxLength']) && strlen($_POST[$field]) > $rules['MaxLength'])
		{
			$this->errors[] = sprintf($this->error_messages['TooLong'], $field_text, $rules['MaxLength']);
		}
		if(isset($rules['WithinRange']))
		{
			$too_short = strlen($_POST[$field]) < $rules['WithinRange']['MinLength'] && !empty($_POST[$field]);
			$too_long = strlen($_POST[$field]) > $rules['WithinRange']['MaxLength'];
			
			if($too_short || $too_long)
			{
				$this->errors[] = sprintf($this->error_messages['OutOfRange'], $field_text, $rules['WithinRange']['MinLength'], $rules['WithinRange']['MaxLength']);
			}
		}
		if(isset($rules['Matches']))
		{
			if($_POST[$field] != $rules['Matches'])
			{
				$this->errors[] = sprintf($this->error_messages['DontMatch'], $field_text, $rules['Matches']);
			}
		}
		if(isset($rules['HasNumbers']))
		{
			if(ctype_digit($_POST[$field]))
			{
				$this->errors[] = sprintf($this->error_messages['HasNumbers'], $field_text, $rules['CheckNumbers']);
			}
		}
		if(isset($rules['HasLetters']))
		{
			if(ctype_digit($_POST[$field]))
			{
				$this->errors[] = sprintf($this->error_messages['HasLetters'], $field_text, $rules['CheckLetters']);
			}
		}
	}
	public function IsValidated() { return count($this->errors) == 0; }
	public function GetErrors() { return $this->errors; }
}
?>