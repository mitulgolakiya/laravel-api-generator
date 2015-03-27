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

	/** @var bool */
	private $isScaffold = false;

	/** @var bool */
	private $isScaffoldAPI = false;

	private $apiPrefix = 'api';

	private $apiNamespace;

	function __construct($commandData, $isScaffold = false , $isScaffoldAPI = false)
	{
		$this->commandData = $commandData;
		$this->isScaffold = $isScaffold;
		$this->isScaffoldAPI = $isScaffoldAPI;
		$this->path = Config::get('generator.path_routes', app_path('Http/routes.php'));
		$this->apiPrefix = Config::get('generator.api_prefix', 'api');
		$this->apiNamespace = Config::get('generator.namespace_api_controller', 'API');
	}

	public function generate()
	{
		$routeContents = $this->commandData->fileHelper->getFileContents($this->path);

		$routeContents .= "\n\nRoute::resource('" . $this->commandData->modelNamePluralCamel . "', '" . $this->commandData->modelName . "Controller');";

		if($this->isScaffoldAPI)
		{
			$routeContents .= "\n\nRoute::group(['prefix' => '". $this->apiPrefix  ."','namespace' => '". $this->apiNamespace ."'],function(){";
			$routeContents .= "\n\n\t\tRoute::resource('" . $this->commandData->modelNamePluralCamel . "', '" . $this->commandData->modelName . "Controller');";
			$routeContents .= "\n\n});";
		}

		if($this->isScaffold)
		{
			$deleteRoutes = $this->commandData->templatesHelper->getTemplate("routes", "Scaffold");

			$deleteRoutes = $this->fillTemplate($deleteRoutes);

			$routeContents .= "\n\n".$deleteRoutes;
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

}
