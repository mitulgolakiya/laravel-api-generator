<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 5:35 PM
 */

namespace Mitul\APIGenerator\Generators;

use Config;
use Mitul\APIGenerator\CommandData;

class ModelGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_model', app_path('/'));
		$this->namespace = Config::get('generator.namespace_model', 'App');
	}

	function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Model");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . ".php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nModel created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);

		$templateData = str_replace('$TABLE_NAME$', $this->commandData->tableName, $templateData);

		$primaryKey = "";
		$fillables = [];

		foreach($this->commandData->inputFields as $field)
		{
			if($field['isPrimary'])
				$primaryKey = $field['fieldName'];
			elseif($field['fieldType'] != 'defaultTimestamps')
				$fillables[] = '"' . $field['fieldName'] . '"';
		}

		if(!empty($primaryKey))
			$templateData = str_replace('$PRIMARY_KEY$', "public \$primaryKey = \"" . $primaryKey . "\";", $templateData);
		else
			$templateData = str_replace('$PRIMARY_KEY$', "", $templateData);

		$templateData = str_replace('$FIELDS$', implode(",\n", $fillables), $templateData);

		$templateData = str_replace('$RULES$', implode(",\n", $this->generateRules()), $templateData);

		return $templateData;
	}

	private function generateRules()
	{
		$rules = [];

		foreach($this->commandData->inputFields as $field)
		{
			if(!empty($field['validations']))
			{
				$rule = '"' . $field['fieldName'] . '" => "' . $field['validations'] . '"';
				$rules[] = $rule;
			}
		}

		return $rules;
	}


}