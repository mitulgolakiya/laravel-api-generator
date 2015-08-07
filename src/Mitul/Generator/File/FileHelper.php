<?php

namespace Mitul\Generator\File;

class FileHelper
{
    public function writeFile($file, $contents)
    {
        file_put_contents($file, $contents);
    }

    public function getFileContents($file)
    {
        return file_get_contents($file);
    }
}
