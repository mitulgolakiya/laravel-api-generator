<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 5:04 PM
 */

namespace Mitul\Generators;


class SchemaCreator
{

	public static function createField($field)
	{
		switch($field['fieldType'])
		{
			case 'boolean':
				$fieldStr = self::generateBooleanField($field);
				break;
			case 'int':
				$fieldStr = self::generateIntField($field);
				break;
			case 'float':
				$fieldStr = self::generateFloatField($field);
				break;
			case 'string':
				$fieldStr = self::generateStringField($field);
				break;
			case 'text':
				$fieldStr = self::generateTextField($field);
				break;
			case 'timestamp':
				$fieldStr = self::generateTimestampField($field);
				break;
			case 'datetime':
				$fieldStr = self::generateDateTimeField($field);
				break;
			case 'defaultTimestamps':
				$fieldStr = self::generateDefaultTimestampsField();
				break;
			default:
				$fieldStr = "";
		}

		if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}

	private static function generateBooleanField($field)
	{
		return sprintf("\$table->boolean('%s')", $field['fieldName']);
	}

	private static function generateIntField($field)
	{
		if($field['isPrimary'])
			return sprintf("\$table->increments('%s')", $field['fieldName']);
		else
			return sprintf("\$table->integer('%s')", $field['fieldName']);
	}

	private static function generateFloatField($field)
	{
		return sprintf("\$table->float('%s')", $field['fieldName']);
	}

	private static function generateStringField($field)
	{
		$str = sprintf("\$table->string('%s', 255)", $field['fieldName']);

		if($field['isPrimary'])
			$str .= "->primary()";

		return $str;
	}

	private static function generateTextField($field)
	{
		return sprintf("\$table->text('%s')", $field['fieldName']);
	}

	private static function generateTimestampField($field)
	{
		return sprintf("\$table->timestamp('%s')", $field['fieldName']);
	}

	private static function generateDateTimeField($field)
	{
		return sprintf("\$table->datetime('%s')", $field['fieldName']);
	}

	private static function generateDefaultTimestampsField()
	{
		return "\$table->timestamps()";
	}

}