<?php

function clean($a)
{
    return trim(strip_tags($a));
}

class _GET extends ArrayList
{
    private static $get = array();
    private static $instance;
    
    public static function Singleton()
    {
        self::$get = new ArrayList($_POST);
        self::$get->Map('clean');
        
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
     
    public function Clean()
    {
        return self::$post;
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