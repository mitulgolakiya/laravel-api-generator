<?php

namespace Mitul\Generator\Generators\Common;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class RepositoryGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_repository', app_path('/Libraries/Repositories/'));
		$this->namespace = Config::get('generator.namespace_repository', 'App\Libraries\Repositories');
	}

	function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Repository", "Common");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . "Repository.php";

		if(!file_exists($this->path))
			mkdir($this->path, 0755, true);

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nRepository created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
		$templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
		$templateData = str_replace('$TABLE_NAME$', $this->commandData->tableName, $templateData);

		return $templateData;
	}

}