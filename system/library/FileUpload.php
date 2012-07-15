<?php

class FileUpload
{
    function UploadFile($source, $destination)
    {
        if(!empty($source))
        {
            copy($FILES[$source]['tmp-name'], $destination.'/'.$FILES[$source]['name']);
        }
        return false;
    }
}

?>