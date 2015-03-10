<?php

namespace Mitul\APIGenerator;

use Illuminate\Support\ServiceProvider;
use Mitul\APIGenerator\Commands\APIGeneratorCommand;
use Mitul\APIGenerator\Commands\ScaffoldGeneratorCommand;

class APIGeneratorServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		$configPath = __DIR__ . '/../../../config/generator.php';
		$this->publishes([$configPath => config_path('generator.php')], 'config');
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

		$this->app->singleton(
			'Illuminate\Contracts\Debug\ExceptionHandler',
			'Mitul\APIGenerator\Exceptions\APIExceptionsHandler'
		);

		$this->commands(['mitul.generator.api', 'mitul.generator.scaffold']);
	}

}
