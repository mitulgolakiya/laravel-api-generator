<?php

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
        $api_prefix = $this->apiPrefix
            ? "    'prefix' => '" . $this->apiPrefix . "'," . PHP_EOL
            : '';

        return "
/*
|--------------------------------------------------------------------------
| Dingo/api and Mitul/laravel-api-generator for {$this->commandData->modelName}
|--------------------------------------------------------------------------
*/
\$api = app('api.router');

\$api->group([
    'version' => 'v1',
{$api_prefix}    'namespace' => 'App\\Http\\Controllers\\API',
], function (\$api) {
    \$api->resource('{$this->commandData->modelNamePluralCamel}', '{$this->commandData->modelName}APIController');
    \$api->get('errors/{id}', function(\$id) {
        return \\Mitul\\Generator\\Errors::getErrors([\$id]);
    });
    \$api->get('errors', function() {
        return \\Mitul\\Generator\\Errors::getErrors([], [], true);
    });
    \$api->get('/', function() {
        \$links = \\App\\Http\\Controllers\\API\\{$this->commandData->modelName}ApiController::getHATEOAS();

        return ['links' => \$links];
    });
});
";
	}

	private function generateScaffoldRoutes()
	{
		$routes = "\n\nRoute::resource('" . $this->commandData->modelNamePluralCamel . "', '" . $this->commandData->modelName . "Controller');";

		$deleteRoutes = $this->commandData->templatesHelper->getTemplate("routes", "Scaffold");

		$deleteRoutes = $this->fillTemplate($deleteRoutes);

		return $routes . "\n\n" . $deleteRoutes;
	}

}
