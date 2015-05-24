<?php

namespace Mitul\Generator\Generators\Common;

use Config;
use Mitul\Generator\CommandData;
use Mitul\Generator\Generators\GeneratorProvider;
use Mitul\Generator\SchemaCreator;

class MigrationGenerator implements GeneratorProvider
{
	/** @var  CommandData */
	private $commandData;

	private $path;

	function __construct($commandData)
	{
		$this->commandData = $commandData;
		$this->path = Config::get('generator.path_migration', base_path('database/migrations/'));
	}

	public function generate()
	{
		$templateData = $this->commandData->templatesHelper->getTemplate("Migration", "Common");

		$templateData = $this->fillTemplate($templateData);

		$fileName = date('Y_m_d_His') . "_" . "create_" . $this->commandData->tableName . "_table.php";

		$path = $this->path . $fileName;

		$this->commandData->fileHelper->writeFile($path, $templateData);
		$this->commandData->commandObj->comment("\nMigration created: ");
		$this->commandData->commandObj->info($fileName);
	}

	private function fillTemplate($templateData)
	{
		$templateData = str_replace('$MODEL_NAME_PLURAL$', $this->commandData->modelNamePlural, $templateData);

		$templateData = str_replace('$TABLE_NAME$', $this->commandData->tableName, $templateData);

		$templateData = str_replace('$FIELDS$', $this->generateFieldsStr(), $templateData);

		return $templateData;
	}

	private function generateFieldsStr()
	{
		$fieldsStr = "\$table->increments('id');\n";

		foreach($this->commandData->inputFields as $field)
		{
			$fieldsStr .= SchemaCreator::createField($field['fieldInput']);
		}

		$fieldsStr .= "\t\t\t\$table->timestamps();";

		if($this->commandData->useSoftDelete)
			$fieldsStr .= "\n\t\t\t\$table->softDeletes();";

		return $fieldsStr;
	}
}