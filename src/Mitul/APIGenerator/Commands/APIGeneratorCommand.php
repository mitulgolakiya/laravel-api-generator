<?php

namespace Mitul\APIGenerator\Commands;

use Illuminate\Console\Command;
use Mitul\APIGenerator\CommandData;
use Mitul\APIGenerator\Generators\ControllerGenerator;
use Mitul\APIGenerator\Generators\MigrationGenerator;
use Mitul\APIGenerator\Generators\ModelGenerator;
use Mitul\APIGenerator\Generators\RepoControllerGenerator;
use Mitul\APIGenerator\Generators\RepositoryGenerator;
use Mitul\APIGenerator\Generators\RoutesGenerator;
use Symfony\Component\Console\Input\InputArgument;

class APIGeneratorCommand extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mitul.generator:api';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a full CRUD API for given model';


	public $commandData;

	/**
	 * Create a new command instance.
	 *
	 */
	public function __construct()
	{
		parent::__construct();

		$this->commandData = new CommandData($this);
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
		$this->commandData->inputFields = $this->getInputFields();

		$followRepoPattern = $this->confirm("\nDo you want to generate repository ? (y|N)", false);

		$migrationGenerator = new MigrationGenerator($this->commandData);
		$migrationGenerator->generate();

		$modelGenerator = new ModelGenerator($this->commandData);
		$modelGenerator->generate();

		if($followRepoPattern)
		{
			$repositoryGenerator = new RepositoryGenerator($this->commandData);
			$repositoryGenerator->generate();

			$repoControllerGenerator = new RepoControllerGenerator($this->commandData);
			$repoControllerGenerator->generate();
		}
		else
		{
			$controllerGenerator = new ControllerGenerator($this->commandData);
			$controllerGenerator->generate();
		}

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

	private function getInputFields()
	{
		$fields = [];

		$this->info("Specify fields for the model (skip timestamp fields, will ask for it later)");
		$this->info("Currently Supported Types: boolean, int, float, string, text, timestamp, datetime");

		$isPrimaryTaken = false;

		while(true)
		{
			$fieldName = $this->ask("Field Name:");
			$fieldType = $this->askWithCompletion('Field Type:', ['boolean', 'int', 'float', 'string', 'text', 'timestamp, datetime']);

			if(!$isPrimaryTaken)
			{
				$isPrimary = $this->confirm("Is primary Key? [y|N]", false);
				$isPrimaryTaken = $isPrimary;
			}
			else
				$isPrimary = false;

			if(in_array($fieldType, ['int', 'string']))
				$validations = $this->ask("Enter validations: ");
			else
				$validations = "";

			$field = [
				'fieldName'   => $fieldName,
				'fieldType'   => $fieldType,
				'isPrimary'   => $isPrimary,
				'validations' => $validations
			];

			$fields[] = $field;

			if(!$this->confirm("Do you want to add more fields ? [Y|n]", true))
				break;
		}

		if($this->confirm("Do you want to add timestamps? [Y|n]", true))
		{
			$fields[] = [
				'fieldName' => 'Timestamps',
				'fieldType' => 'defaultTimestamps',
				'isPrimary' => false
			];
		}

		return $fields;
	}
}
