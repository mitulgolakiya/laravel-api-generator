<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 6:00 PM
 */

namespace Mitul\APIGenerator\Generators\Scaffold;


use Config;
use Mitul\APIGenerator\CommandData;
use Mitul\APIGenerator\Generators\GeneratorProvider;

class RequestGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $namespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_request', app_path('HTTP/Requests/'));
		$this->namespace = Config::get('generator.namespace_request', 'App\Http\Requests');
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Request", "Scaffold");

		$templateData = $this->fillTemplate($templateData);

		$fileName = "Create".$this->commandData->modelName . "Request.php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nRequest created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$NAMESPACE$', $this->namespace, $templateData);
		$templateData = str_replace('$MODEL_NAMESPACE$', $this->commandData->modelNamespace, $templateData);

		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$MODEL_NAME_CAMEL$', $this->commandData->modelNameCamel, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

		return $templateData;
	}
}