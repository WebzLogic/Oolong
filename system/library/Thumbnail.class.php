<?php

class Thumbnail
{
    public $image;
    public $image_handle;
    public $thumbnail_handle;
    public $image_height;
    public $image_width;
    public $thumbnail_height;
    public $thumbnail_width;
    
    public function __construct($image, $thumbnail_width, $thumbnail_height)
    {
        $this->image = $image;
        $this->image_handle = imagecreatefrompng($this->image);
        $this->image_height = imagesy($this->image_handle);
        $this->image_width = imagesx($this->image_handle);
        
        if($thumbnail_width >= 0 and $thumbnail_width <= 1)
        {
            $this->thumbnail_width = $this->image_width * $thumbnail_width;
        }
        
        if($thumbnail_height >= 0 and $thumbnail_height <= 1)
        {
            $this->thumbnail_height = $this->image_height * $thumbnail_height;
        }
        
        $this->thumbnail_handle = imagecreatetruecolor($this->thumbnail_width, $this->thumbnail_height);
        imagecopyresampled($this->thumbnail_handle, $this->image_handle, 0, 0, 0, 0, $this->thumbnail_width, $this->thumbnail_height, $this->image_width, $this->image_height);
        imagepng($this->thumbnail_handle, './images/test.png');
    }
}

?>