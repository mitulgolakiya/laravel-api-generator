<?php

namespace Mitul\Generator\Commands;

use Config;
use Illuminate\Console\Command;
use Mitul\Generator\File\FileHelper;
use Mitul\Generator\TemplatesHelper;

class InitAppCommand extends Command
{

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mitul.generator:init';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Initialize your application to be used with generator.';

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$this->initAPIRoutes();
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [];
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
