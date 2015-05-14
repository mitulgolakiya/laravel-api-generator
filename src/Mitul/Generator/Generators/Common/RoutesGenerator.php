<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 6:06 PM
 */

namespace Mitul\Generator\Generators\Common;


use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;

class RoutesGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	private $apiPrefix;

	private $apiNamespace;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_routes', app_path('Http/routes.php'));
		$this->apiPrefix = Config::get('generator.api_prefix', 'api');
		$this->apiNamespace = Config::get('generator.namespace_api_controller', 'App\Http\Controllers\API');
	}

	public function generate()
	{
		$routeContents = $this->commandData->fileHelper->getFileContents($this->path);

		if($this->commandData->commandType == CommandData::$COMMAND_TYPE_API)
		{
			$routeContents .= $this->generateAPIRoutes();
		}
		else if($this->commandData->commandType == CommandData::$COMMAND_TYPE_SCAFFOLD)
		{
			$routeContents .= $this->generateScaffoldRoutes();
		}
		else if($this->commandData->commandType == CommandData::$COMMAND_TYPE_SCAFFOLD_API)
		{
			$routeContents .= $this->generateAPIRoutes();
			$routeContents .= $this->generateScaffoldRoutes();
		}

		$this->commandData->fileHelper->writeFile($this->path, $routeContents);
		$this->commandData->commandObj->comment("\nroutes.php modified:");
		$this->commandData->commandObj->info("\"" . $this->commandData->modelNamePluralCamel . "\" route added.");
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$MODEL_NAME$', $this->commandData->modelName, $templateData);
		$templateData = str_replace('$MODEL_NAME_PLURAL_CAMEL$', $this->commandData->modelNamePluralCamel, $templateData);

		return $templateData;
	}

	private function generateAPIRoutes()
	{
		$apiNamespacePostfix = substr($this->apiNamespace, strlen('App\Http\Controllers\\'));

		return "\n\nRoute::resource('" . $this->apiPrefix . "/" . $this->commandData->modelNamePluralCamel . "', '" . $apiNamespacePostfix . "\\" . $this->commandData->modelName . "APIController');";
	}

	private function generateScaffoldRoutes()
	{

		$routes = $this->commandData->templatesHelper->getTemplate("routes", "Scaffold");

		$routes = $this->fillTemplate($routes);

		return $routes;
	}

}
