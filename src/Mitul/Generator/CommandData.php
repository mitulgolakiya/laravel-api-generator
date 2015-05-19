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
use Mitul\Generator\TemplatesHelper;

class CommandData
{
	public $modelName;
	public $modelNamePlural;
	public $modelNameCamel;
	public $modelNamePluralCamel;
	public $modelNamespace;

	public $tableName;
	public $inputFields;

	/** @var  string */
	public $commandType;

	/** @var  APIGeneratorCommand */
	public $commandObj;

	/** @var FileHelper */
	public $fileHelper;

	/** @var TemplatesHelper */
	public $templatesHelper;

	/** @var  bool */
	public $useSoftDelete;

	public static $COMMAND_TYPE_API = 'api';
	public static $COMMAND_TYPE_SCAFFOLD = 'scaffold';
	public static $COMMAND_TYPE_SCAFFOLD_API = 'scaffold_api';

	function __construct($commandObj, $commandType)
	{
		$this->commandObj = $commandObj;
		$this->commandType = $commandType;
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

	public function getInputFields()
	{
		$fields = [];

		$this->commandObj->info("Specify fields for the model (skip id & timestamp fields, will be added automatically)");
		$this->commandObj->info("Left blank to finish");

		while(true)
		{
			$fieldInputStr = $this->commandObj->ask("Field:");

			if(empty($fieldInputStr))
				break;

			$fieldInputs = explode(":", $fieldInputStr);

			if(sizeof($fieldInputs) < 2)
			{
				$this->commandObj->error("Invalid Input. Try again");
				continue;
			}

			$fieldName = $fieldInputs[0];

			$validations = $this->commandObj->ask("Enter validations: ");

			$field = [
				'fieldName'   => $fieldName,
				'fieldInput'  => $fieldInputStr,
				'validations' => $validations,

			];

			$fields[] = $field;
		}

		return $fields;
	}
}