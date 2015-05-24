<?php

namespace Mitul\Generator\Generators\Scaffold;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class ViewControllerGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	private $repoNamespace;

	private $requestNamespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_controller', app_path('Http/Controllers/'));
		$this->namespace = Config::get('generator.namespace_controller', 'App\Http\Controllers');
		$this->repoNamespace = Config::get('generator.namespace_repository', 'App\Libraries\Repositories');
		$this->requestNamespace = Config::get('generator.namespace_request', 'App\Http\Requests');
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("ControllerRepo", "Scaffold");

		$templateData = $this->fillTemplate($templateData);

		$fileName = $this->commandData->modelName . "Controller.php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nController created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
		$templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

		$templateData = str_replace('$REPO_NAMESPACE$', $this->repoNamespace, $templateData);
		$templateData = str_replace('$REQUEST_NAMESPACE$', $this->requestNamespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

		return $templateData;
	}
}
