<?

class FormValidator
{
	public $error_log = array();
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
		$this->error_messages['InvalidEmail'] = "'%s' is not a valid email address.";
	}
	
	/*
	
	
	Description
	---
	Let's the user reset the default error messages logged and displayed when a validation rule is broken
	
	Arguments
	---
		* $msgs: an array of new messages to substitute for the default error messages
	
	Returns
	---
	Void
	 
	*/
	
	public function ResetErrorMessages($msgs = array())
	{
		foreach($msgs as $key => $value) 
		{
		    $key_exists = in_array($key, $this->error_messages[$key]);
			$messages_are_different = $this->error_messages[$key] != $value;
			
			if($key_exists && $messages_are_different)
			{
				$this->error_messages[$key] = $value;
			}
		}
	}
	
	/*
	
	
	Description
	---
	Sets every field in the array $fields to a 'Required' field, meaning it must not be empty when the form is submitted. 
	
    Arguments
    ---
		* $fields: the array of fields that will have the 'Required' validation rule applied to
	 
    Returns
    ---
    Void
    
	*/
	
	public function SetRequiredFields($fields)
	{
		foreach($fields as $key => $value)
		{
			$this->SetFieldRules($key, $value, array("Required"));
		}
	}
	
	/*
	 
	 Description
	 ---
	 Sets form validation rules ($rules) on the specified field $field. If the field fails to validate, the error will be logged.
	 
	 Arguments
	 ---
		* $field: The key index of the field to validate on the form
	
		* $field_text: the text that will display in the error message when the field fails to validate; usually just a short descriptive name
	
		* $rules: array of validation rules to apply to the field (e.g 'Required')
	 
	 Returns
	 ---
	 Void
	 
	 Notes
	 ---
	 There are several validation rules that can be applied to a field. Here is a list of these rules:
		
		* Required: 	makes the field required (must not be empty when form is submitted)
		
		* MinLength: 	the field text's length can't be smaller than the value of MinLength
		
		* MaxLength:	the field text's length can't be longer than the value of MaxLength
		
		* WithinRange:  the field text's length must be within the range allowed by WithinRange
		
		* Matches:      the field must match one of the values in Matches
		
		* NoNumbers:    the field must not contain numbers
		
		* NoLetters:    the field must not contain letters
		
		* MustHave:     the field must have specified characters
		
		* MustNotHave:  the field must not have specified characters
		
		* PhoneNumber:  the field must be a phone number, or in a valid phone number format (e.g 123-456-789)
		
		* EmailAddress: the field must be a valid email address (e.g contains an '@')
		
    Each of these rules are a key in the $rules array (e.g $rules['Required']. In some cases, such as with 'WithinRange', other
    keys must used in conjunction with it.
    

    e.g SetFieldRules($field, $field_text, ['Required','WithinRange'=>['MinLength'=>0, 'Maxlength'=>10]])
    
    or
    
    e.g SetFieldRules($field, $field_text, 'required|range[0:10]')
	 
	*/
	
	public function SetFieldRules($field, $field_text, $validation_rules)
	{
		if(!is_array($validation_rules))
		{
			$rules = $this->ParseRules($validation_rules);	
		}
		else
		{
		    $rules = $validation_rules;
		}
		
		if(in_array('Required',$rules) && empty($_POST[$field]))
		{
			$this->error_log[] = sprintf($this->error_messages['Required'], $field_text);
		}
		if(isset($rules['MinLength']) && (strlen($_POST[$field]) < $rules['MinLength']  && !empty($_POST[$field])))
		{
			$this->error_log[] = sprintf($this->error_messages['TooShort'], $field_text, $rules['MinLength']);
		}
		if(isset($rules['MaxLength']) && strlen($_POST[$field]) > $rules['MaxLength'])
		{
			$this->error_log[] = sprintf($this->error_messages['TooLong'], $field_text, $rules['MaxLength']);
		}
		if(isset($rules['WithinRange']))
		{
			$too_short = strlen($_POST[$field]) < $rules['WithinRange']['MinLength'] && !empty($_POST[$field]);
			$too_long = strlen($_POST[$field]) > $rules['WithinRange']['MaxLength'];
			
			if($too_short || $too_long)
			{
				$this->error_log[] = sprintf($this->error_messages['OutOfRange'], $field_text, $rules['WithinRange']['MinLength'], $rules['WithinRange']['MaxLength']);
			}
		}
		if(isset($rules['Matches']))
		{
			if($_POST[$field] != $rules['Matches'])
			{
				$this->error_log[] = sprintf($this->error_messages['DontMatch'], $field_text, $rules['Matches']);
			}
		}
		if(isset($rules['NoNumbers']))
		{
			if(ctype_digit($_POST[$field]))
			{
				$this->error_log[] = sprintf($this->error_messages['HasNumbers'], $field_text, $rules['NoNumbers']);
			}
		}
		if(isset($rules['NoLetters']))
		{
			if(ctype_alpha($_POST[$field]))
			{
				$this->error_log[] = sprintf($this->error_messages['HasLetters'], $field_text, $rules['NoLetters']);
			}
		}
		if(isset($rules['EmailAddress']))
		{
			if(!in_array('@',$_POST[$field]))
			{
				$this->error_log[] = sprintf($this->error_messages['InvalidEmail'], $field_text);
			}
		}
	}
	
	private function ParseRules($rule_string)
	{
		$rules = array();
		$rule_parts = explode('|',$rule_string);
		foreach($rule_parts as $rule)
		{
				if(strtolower($rule) == 'required')
				{
						$rules['Required'] = true;
				}
				else if(strtolower($rule) == 'noletters')
				{
						$rules['NoLetters'] = true;
				}
				else if(strtolower($rule) == 'nonumbers')
				{
						$rules['NoNumbers'] = true;
				}
				else if(strtolower($rule) == 'email')
				{
						$rules['EmailAddress'] = true;
				}
				else if(substr(strtolower($rule), 0, 9) == 'minlength')
				{
						$minlength = explode('minlength', strtolower($rule));
						$rules['MinLength'] = (int)(substr($minlength[1], 1, strlen($rule)-2));
				}
				else if(substr(strtolower($rule), 0, 9) == 'maxlength')
				{
						$maxlength = explode('maxlength', strtolower($rule));
						$rules['MaxLength'] = (int)(substr($maxlength[1], 1, strlen($rule)-2));
				}
				else if(substr(strtolower($rule), 0, 5) == 'range')
				{
						$range_parts = explode('range', strtolower($rule));
						$range = explode(':', substr($range_parts[1], 1, strlen($range_parts[1])-2));
						
						$rules['WithinRange']['MinLength'] = $range[0];
						$rules['WithinRange']['MaxLength'] = $range[1];
				}
		}
		return $rules;
		
	}
	
     /*
	 
	 Description
	 ---
	 Checks to see if the form is validated. In other words, if no errors were logged, the form is considered validated.
	 
	 Arguments
	 ---
     None
	 
	 Returns
	 ---
	 (Boolean) If there are no errors, returns true. Otherwise, returns false.
	 
	*/
	
	public function IsValidated() { return count($this->error_log) == 0; }
	
	 /*
	 
	 Description
	 ---
	 Checks to see if the form is validated. In other words, if no errors were logged, the form is considered validated.
	 
	 Arguments
	 ---
     None
	 
	 Returns
	 ---
	 (Array) The error log array
	 
	*/
	
	public function GetErrors() { return $this->error_log; }
}



?>