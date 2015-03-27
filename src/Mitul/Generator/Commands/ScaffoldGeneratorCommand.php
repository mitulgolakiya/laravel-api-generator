<?php

namespace Mitul\Generator\Commands;

use Illuminate\Console\Command;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\Common\MigrationGenerator;
use Mitul\Generator\Generators\Common\ModelGenerator;
use Mitul\Generator\Generators\Common\RepositoryGenerator;
use Mitul\Generator\Generators\Common\RequestGenerator;
use Mitul\Generator\Generators\Common\RoutesGenerator;
use Mitul\Generator\Generators\Scaffold\RepoViewControllerGenerator;
use Mitul\Generator\Generators\Scaffold\ViewControllerGenerator;
use Mitul\Generator\Generators\Scaffold\ViewGenerator;
use Symfony\Component\Console\Input\InputArgument;

class ScaffoldGeneratorCommand extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mitul.generator:scaffold';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a full CRUD for given model with initial views';

	/**
	 * The command Data
	 *
	 * @var CommandData
	 */
	public $commandData;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->commandData = new CommandData($this, CommandData::$COMMAND_TYPE_SCAFFOLD);
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->commandData->modelName = $this->argument('model');
		$this->commandData->initVariables();
		$this->commandData->inputFields = $this->commandData->getInputFields();

		$followRepoPattern = $this->confirm("\nDo you want to generate repository ? (y|N)", false);

		$migrationGenerator = new MigrationGenerator($this->commandData);
		$migrationGenerator->generate();

		$modelGenerator = new ModelGenerator($this->commandData);
		$modelGenerator->generate();

		$requestGenerator = new RequestGenerator($this->commandData);
		$requestGenerator->generate();

		if($followRepoPattern)
		{
			$repositoryGenerator = new RepositoryGenerator($this->commandData);
			$repositoryGenerator->generate();

			$repoControllerGenerator = new RepoViewControllerGenerator($this->commandData);
			$repoControllerGenerator->generate();
		}
		else
		{
			$controllerGenerator = new ViewControllerGenerator($this->commandData);
			$controllerGenerator->generate();
		}

		$viewsGenerator = new ViewGenerator($this->commandData);
		$viewsGenerator->generate();

		$routeGenerator = new RoutesGenerator($this->commandData);
		$routeGenerator->generate();

		if($this->confirm("\nDo you want to migrate database? [y|N]", false))
			$this->call('migrate');
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['model', InputArgument::REQUIRED, 'Singular Model name']
		];
	}
}
