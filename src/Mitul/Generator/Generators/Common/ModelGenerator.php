<?php

namespace Mitul\Generator\Generators\Common;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class ModelGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	private $customModelExtend;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_model', app_path('/'));
		$this->namespace = Config::get('generator.namespace_model', 'App');
		$this->customModelExtend = Config::get('generator.model_extend', false);
	}

	function generate()
	{
		$templateName = "Model";

		if($this->customModelExtend)
		{
			$templateName = "Model_Extended";
		}

		$templateData = $this->commandData->templatesHelper->getTemplate($templateName, "Common");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . ".php";

		if(!file_exists($this->path))
			mkdir($this->path, 0755, true);

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nModel created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);

		if($this->commandData->useSoftDelete)
		{
			$templateData = str_replace('$SOFT_DELETE_IMPORT$', "use Illuminate\\Database\\Eloquent\\SoftDeletes;\n", $templateData);
			$templateData = str_replace('$SOFT_DELETE$', "use SoftDeletes;\n", $templateData);
			$templateData = str_replace('$SOFT_DELETE_DATES$', "\n\tprotected \$dates = ['deleted_at'];\n", $templateData);
		}
		else
		{
			$templateData = str_replace('$SOFT_DELETE_IMPORT$', "", $templateData);
			$templateData = str_replace('$SOFT_DELETE$', "", $templateData);
			$templateData = str_replace('$SOFT_DELETE_DATES$', "", $templateData);
		}

		$templateData = str_replace('$TABLE_NAME$', $this->commandData->tableName, $templateData);

		if($this->customModelExtend)
		{
			$templateData = str_replace(
				'$MODEL_EXTEND_NAMESPACE$',
				Config::get('generator.model_extend_namespace', 'Illuminate\Database\Eloquent\Model'),
				$templateData
			);

			$templateData = str_replace(
				'$MODEL_EXTEND_CLASS$',
				Config::get('generator.model_extend_class', 'Model'),
				$templateData
			);
		}

		$fillables = [];

		foreach($this->commandData->inputFields as $field)
		{
			$fillables[] = '"' . $field['fieldName'] . '"';
		}

		$templateData = str_replace('$FIELDS$', implode(",\n\t\t", $fillables), $templateData);

		$templateData = str_replace('$RULES$', implode(",\n\t\t", $this->generateRules()), $templateData);

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