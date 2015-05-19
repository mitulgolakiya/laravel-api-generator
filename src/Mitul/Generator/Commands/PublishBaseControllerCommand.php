<?php

namespace Mitul\Generator\Commands;

use Illuminate\Console\Command;
use Mitul\Generator\File\FileHelper;
use Mitul\Generator\TemplatesHelper;
use Symfony\Component\Console\Input\InputArgument;

class PublishBaseControllerCommand extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mitul.generator.publish:base_controller';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Create a full CRUD API for given model';

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$namespace = $this->argument('namespace');

		$templateHelper = new TemplatesHelper();
		$templateData = $templateHelper->getTemplate('AppBaseController', 'Controller');

		$templateData = str_replace('$$BASE_NAMESPACE$$', $namespace, $templateData);

		$fileName = "AppBaseController.php";

		$filePath = __DIR__ . "/../../Controller/";

		$fileHelper = new FileHelper();
		$fileHelper->writeFile($filePath . $fileName, $templateData);
		$this->comment('AppBaseController generated');
		$this->info($fileName);
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			['namespace', InputArgument::REQUIRED, 'Base Controller namespace']
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	public function getOptions()
	{
		return [];
	}
}
