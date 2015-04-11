<?php
/**
 * User: Mitul
 * Date: 11/04/15
 * Time: 1:21 PM
 */

namespace Mitul\Generator\Commands;

use Illuminate\Console\Command;
use Mitul\Generator\CommandData;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class BaseCommand extends Command
{
	/**
	 * The command Data
	 *
	 * @var CommandData
	 */
	public $commandData;

	public function handle()
	{
		$this->commandData->modelName = $this->argument('model');
		$this->commandData->useSoftDelete = $this->option('softDelete');
		$this->commandData->initVariables();
		$this->commandData->inputFields = $this->commandData->getInputFields();
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

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return [
			['softDelete', null, InputOption::VALUE_NONE, 'Use Soft Delete trait']
		];
	}
}