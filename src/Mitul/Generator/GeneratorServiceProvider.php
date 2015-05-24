<?php

namespace Mitul\Generator;

use Illuminate\Support\ServiceProvider;
use Mitul\Generator\Commands\APIGeneratorCommand;
use Mitul\Generator\Commands\PublishBaseControllerCommand;
use Mitul\Generator\Commands\ScaffoldAPIGeneratorCommand;
use Mitul\Generator\Commands\ScaffoldGeneratorCommand;

class GeneratorServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../../../config/generator.php';

		$this->publishes([
			$configPath                 => config_path('generator.php'),
			__DIR__ . '/../../../views' => base_path('resources/views'),
		], 'config');

		$this->publishes([
			__DIR__ . '/Templates' => base_path('resources/api-generator-templates'),
		], 'templates');
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->singleton('mitul.generator.api', function ($app)
		{
			return new APIGeneratorCommand();
		});

		$this->app->singleton('mitul.generator.scaffold', function ($app)
		{
			return new ScaffoldGeneratorCommand();
		});

		$this->app->singleton('mitul.generator.scaffold_api', function ($app)
		{
			return new ScaffoldAPIGeneratorCommand();
		});

		$this->app->singleton('mitul.generator.publish.base_controller', function ($app)
		{
			return new PublishBaseControllerCommand();
		});

		$this->commands(['mitul.generator.api', 'mitul.generator.scaffold', 'mitul.generator.scaffold_api', 'mitul.generator.publish.base_controller']);
	}
}
