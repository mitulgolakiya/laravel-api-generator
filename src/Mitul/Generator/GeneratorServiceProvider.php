<?php

namespace Mitul\Generator;

use Illuminate\Support\ServiceProvider;
use Mitul\Generator\Commands\APIGeneratorCommand;
use Mitul\Generator\Commands\ScaffoldGeneratorCommand;
use Mitul\Generator\Commands\ScaffoldAPIGeneratorCommand;
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

		$this->app->singleton('mitul.generator.scaffoldAPI', function ($app)
		{
			return new ScaffoldAPIGeneratorCommand();
		});

		$this->app->singleton(
			'Illuminate\Contracts\Debug\ExceptionHandler',
			'Mitul\Generator\Exceptions\APIExceptionsHandler'
		);

		$this->commands(['mitul.generator.api', 'mitul.generator.scaffold' , 'mitul.generator.scaffoldAPI' ]);
	}

}
