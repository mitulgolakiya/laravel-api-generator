<?php

namespace Mitul\Generator\Generators\API;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class APIControllerGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	private $repoNamespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_api_controller', app_path('Http/Controllers/API/'));
		$this->namespace = Config::get('generator.namespace_api_controller', 'App\Http\Controllers\API');
		$this->repoNamespace = Config::get('generator.namespace_repository', 'App\Libraries\Repositories');
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("ControllerRepo", "API");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . "APIController.php";

		if(!file_exists($this->path))
			mkdir($this->path, 0755, true);

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nAPI Controller created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
		$templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

		$templateData = str_replace('$REPO_NAMESPACE$', $this->repoNamespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

		return $templateData;
	}
}