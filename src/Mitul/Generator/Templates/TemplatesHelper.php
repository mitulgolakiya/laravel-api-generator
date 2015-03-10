<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 4:54 PM
 */

namespace Mitul\Generator\Templates;


class TemplatesHelper
{
	public function getTemplate($template, $type = "Common")
	{
		$path = base_path('vendor/mitulgolakiya/laravel-api-generator/src/Mitul/Generator/Templates/' . $type . '/' . $template . '.txt');

		$fileData = file_get_contents($path);

		return $fileData;
	}
}