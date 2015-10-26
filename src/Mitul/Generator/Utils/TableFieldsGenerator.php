<?php

namespace Mitul\Generator\Utils;

use DB;

class TableFieldsGenerator
{
    /** @var  string */
    public $tableName;

    /** @var \Doctrine\DBAL\Schema\AbstractSchemaManager  */
    public $schema;

    /** @var \Doctrine\DBAL\Schema\Table  */
    public $table;

//	/** @var array  */
//	public $dates = [];
//
//	/** @var array  */
//	public $uniqueFields = [];

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
        $this->schema = DB::getDoctrineSchemaManager($tableName);
//		$this->table = $this->schema->listTableDetails($tableName);

//		$this->analyzeIndexes();
    }

//	private function analyzeIndexes()
//	{
//		$indexes = $this->table->getIndexes();
//
//		$this->uniqueFields = [];
//
//		foreach($indexes as $index)
//		{
//			if($index->isPrimary())
//			{
//				$columns = $index->getColumns();
//
//				if(sizeof($columns) == 1)
//				{
//					$this->primaryKey = $columns[0];
//				}
//			}
//
//			if($index->isUnique())
//			{
//				$columns = $index->getColumns();
//
//				if(sizeof($columns) == 1)
//				{
//					$column = $columns[0];
//					if($column != $this->primaryKey)
//					{
//						$this->uniqueFields[] = $column;
//					}
//				}
//			}
//		}
//	}

    public function generateFieldsFromTable()
    {
        $this->schema->getDatabasePlatform()->registerDoctrineTypeMapping('enum', 'string');
        $columns = $this->schema->listTableColumns($this->tableName);

        $fields = [];

        foreach ($columns as $column) {
            switch ($column->getType()->getName()) {
                case 'integer':
                    $fieldInput = $this->generateIntFieldInput($column->getName(), 'integer', $column);
                    $type = 'number';
                    break;
                case 'smallint':
                    $fieldInput = $this->generateIntFieldInput($column->getName(), 'smallInteger', $column);
                    $type = 'number';
                    break;
                case 'bigint':
                    $fieldInput = $this->generateIntFieldInput($column->getName(), 'bigInteger', $column);
                    $type = 'number';
                    break;
                case 'boolean':
                    $fieldInput = $this->generateSingleFieldInput($column->getName(), 'boolean');
                    $type = 'text';
                    break;
                case 'datetime':
                    $fieldInput = $this->generateSingleFieldInput($column->getName(), 'dateTime');
                    $type = 'date';
                    break;
                case 'datetimetz':
                    $fieldInput = $this->generateSingleFieldInput($column->getName(), 'dateTimeTz');
                    $type = 'date';
                    break;
                case 'date':
                    $fieldInput = $this->generateSingleFieldInput($column->getName(), 'date');
                    $type = 'date';
                    break;
                case 'time':
                    $fieldInput = $this->generateSingleFieldInput($column->getName(), 'time');
                    $type = 'text';
                    break;
                case 'decimal':
                    $fieldInput = $this->generateDecimalInput($column, 'decimal');
                    $type = 'number';
                    break;
                case 'float':
                    $fieldInput = $this->generateFloatInput($column);
                    $type = 'number';
                    break;
                case 'string':
                    $fieldInput = $this->generateStringInput($column);
                    $type = 'text';
                    break;
                case 'text':
                    $fieldInput = $this->generateTextInput($column);
                    $type = 'textarea';
                    break;
                default:
                    $fieldInput = $this->generateTextInput($column);
                    $type = 'text';
            }

            if (strtolower($column->getName()) == 'password') {
                $type = 'password';
            } elseif (strtolower($column->getName()) == 'email') {
                $type = 'email';
            }

            if (!empty($fieldInput)) {
                //				$fieldInput .= $this->checkForDefault($column);
//				$fieldInput .= $this->checkForNullable($column);
//				$fieldInput .= $this->checkForUnique($column);
                $fields [] = GeneratorUtils::processFieldInput($fieldInput, $type, '');
            }
        }

        return $fields;
    }

    /**
     * @param string                       $name
     * @param string                       $type
     * @param \Doctrine\DBAL\Schema\Column $column
     *
     * @return string
     */
    private function generateIntFieldInput($name, $type, $column)
    {
        $fieldInput = "$name:$type";

        if ($column->getAutoincrement()) {
            $fieldInput .= ',true';
        }

        if ($column->getUnsigned()) {
            $fieldInput .= ',true';
        }

        return $fieldInput;
    }

    private function generateSingleFieldInput($name, $type)
    {
        $fieldInput = "$name:$type";

        return $fieldInput;
    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     *
     * @return string
     */
    private function generateDecimalInput($column)
    {
        $fieldInput = $column->getName().':decimal,'.$column->getPrecision().','.$column->getScale();

        return $fieldInput;
    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     *
     * @return string
     */
    private function generateFloatInput($column)
    {
        $fieldInput = $column->getName().':float,'.$column->getPrecision().','.$column->getScale();

        return $fieldInput;
    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     * @param int                          $length
     *
     * @return string
     */
    private function generateStringInput($column, $length = 255)
    {
        $fieldInput = $column->getName().':string,'.$length;

        return $fieldInput;
    }

    /**
     * @param \Doctrine\DBAL\Schema\Column $column
     *
     * @return string
     */
    private function generateTextInput($column)
    {
        $fieldInput = $column->getName().':text';

        return $fieldInput;
    }

//	/**
//	 * @param \Doctrine\DBAL\Schema\Column $column
//	 *
//	 * @return string
//	 */
//	private function checkForNullable($column)
//	{
//		if(!$column->getNotnull())
//			return ":nullable";
//
//		return '';
//	}
//
//	/**
//	 * @param \Doctrine\DBAL\Schema\Column $column
//	 *
//	 * @return string
//	 */
//	private function checkForDefault($column)
//	{
//		if($column->getDefault())
//			return ":default," . $column->getDefault();
//
//		return '';
//	}
//
//	/**
//	 * @param \Doctrine\DBAL\Schema\Column $column
//	 *
//	 * @return string
//	 */
//	private function checkForUnique($column)
//	{
//		if(in_array($column->getName(), $this->uniqueFields))
//			return ":unique";
//
//		return '';
//	}
}
