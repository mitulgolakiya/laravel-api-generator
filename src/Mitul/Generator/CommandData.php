<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 4:15 PM
 */

namespace Mitul\Generator;


use Config;
use Illuminate\Support\Str;
use Mitul\Generator\Commands\APIGeneratorCommand;
use Mitul\Generator\File\FileHelper;
use Mitul\Generator\Templates\TemplatesHelper;

class CommandData
{
	public $modelName;
	public $modelNamePlural;
	public $modelNameCamel;
	public $modelNamePluralCamel;
	public $modelNamespace;

	public $tableName;
	public $inputFields;

	/** @var  APIGeneratorCommand */
	public $commandObj;

	/** @var FileHelper */
	public $fileHelper;

	/** @var TemplatesHelper */
	public $templatesHelper;

	function __construct($commandObj)
	{
		$this->commandObj = $commandObj;
		$this->fileHelper = new FileHelper();
		$this->templatesHelper = new TemplatesHelper();
	}

	public function initVariables()
	{
		$this->modelNamePlural = Str::plural($this->modelName);
		$this->tableName = strtolower(Str::snake($this->modelNamePlural));
		$this->modelNameCamel = Str::camel($this->modelName);
		$this->modelNamePluralCamel = Str::camel($this->modelNamePlural);
		$this->modelNamespace = Config::get('generator.namespace_model', 'App') . "\\" . $this->modelName;
	}
}