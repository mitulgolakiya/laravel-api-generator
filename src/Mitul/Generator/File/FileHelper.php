<?php
namespace Mitul\Generator\File;

use Storage;

class FileHelper
{
	public function writeFile($file, $contents)
	{
		Storage::put($file, $contents);
	}

	public function getFileContents($file)
	{
		return Storage::get($file);
	}
}
