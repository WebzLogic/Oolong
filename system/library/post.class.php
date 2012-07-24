<?php

class _GET extends ArrayList
{
    private static $get = array();
    private static $instance;
    
    public static function Singleton()
    {
        self::$get = new ArrayList($_POST);
        foreach(self::$get as $value)
        {
            self::$get[] = StringBuilder::ToStringBuilder($value)->EscapeString()->ToString();
        }
        
        $class = __CLASS__;
		return new $class();
    }
     
    public function Clean()
    {
        return self::$get;
    }
    
    public function Get($key)
    {
        return self::$get->$key;
    }
}

class _POST extends ArrayList
{
    private static $post = array();
    private static $instance;
    
    public static function Singleton()
    {
        self::$post = new ArrayList($_POST);
        $class = __CLASS__;
		return new $class();
    }
    
    public function GetAll()
    {
        foreach(self::$post->ToArray() as $key => $value)
        {
            $cleaned_value = new StringBuilder($value);
            self::$post->$key = $cleaned_value->EscapeString()->StripHTMLTags()->ToString();
        }
        return self::$post->ToArray();
    }
    
    public function Get($key)
    {
        return self::$post->$key;
    }
    
    public function Submitted()
    {
        return self::$post->Size() > 0;
    }
}

?>