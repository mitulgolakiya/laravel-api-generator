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

	function __construct($commandData, $isScaffold = false)
	{
		$this->commandData = $commandData;
		$this->isScaffold = $isScaffold;
		$this->path = Config::get('generator.path_routes', app_path('Http/routes.php'));
	}

	public function generate()
	{
		$routeContents = $this->commandData->fileHelper->getFileContents($this->path);

		$routeContents .= "\n\nRoute::resource('" . $this->commandData->modelNamePluralCamel . "', '" . $this->commandData->modelName . "Controller');";

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
