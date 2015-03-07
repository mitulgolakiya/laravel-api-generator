<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 4:54 PM
 */

namespace Mitul\APIGenerator\Templates;


class TemplatesHelper
{
	public function getTemplate($template)
	{
		$path = base_path('vendor/mitulgolakiya/laravel-api-generator/src/Mitul/APIGenerator/Templates/' . $template . '.txt');

		$fileData = file_get_contents($path);

		return $fileData;
	}
}