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
	public $modelConnection;
	public $modelTableName;
	public $modelTimestamps;

	public $viewDateranger;

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

		$this->modelConnection = $this->commandObj->ask("DB_CONNECTION:");
		if (empty($this->modelConnection)) {
			$this->commandObj->error("我死了！");
			exit();
		}
		$this->tableName = $this->modelTableName = $this->commandObj->ask("DB_TABLE_NAME:");
		if (empty($this->modelTableName)) {
			$this->commandObj->error("我死了！");
			exit();
		}
		$this->modelTimestamps = $this->commandObj->confirm("Does table has created_at and updated_at columns ? (Y|N)", false);
		$useSoftDelete = $this->commandObj->confirm("Do you want to use softDelete (need a deleted_at column at table, no need set in model.txt)? (Y|N)", false);
		$this->useSoftDelete = $useSoftDelete ? 'true' : 'false';
		$this->viewDateranger = $this->commandObj->confirm("Do you want to use dateranger plugin with search? (Y|N)", false);
	}

	public function getInputFields()
	{
		$fields = [];

		$this->commandObj->info("Specify [fields describtion file name] for the model (skip id & timestamp fields, will be added automatically)");
		$this->commandObj->info("Doc: http://laravel.com/docs/5.0/schema");

		$fieldInputStr = $this->commandObj->ask("File(Default:model.txt):");
		$fieldInputStr = $fieldInputStr ? $fieldInputStr : 'model.txt';
		$lines = file($fieldInputStr, FILE_IGNORE_NEW_LINES);

		if (count($lines)) {
			foreach ($lines as $key => $value) {
				$field = explode(' ', $value);
				$fields[] = [
					'fieldInput'  => $value,
					'fieldName'   => $field[0],
					'filedType'   => $field[1],
					'validations' => isset($field[2]) ? $field[2] : '',
				];
			}
			d($fields);
			return $fields;
		} else {
			$this->commandObj->error($fieldInputStr . '有问题！');

			exit();
		}
	}
}
