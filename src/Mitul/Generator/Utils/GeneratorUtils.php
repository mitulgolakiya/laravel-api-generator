<?php

namespace Mitul\Generator\Utils;

class GeneratorUtils
{
	public static function validateFieldInput($fieldInputStr)
	{
		$fieldInputs = explode(":", $fieldInputStr);

		if(sizeof($fieldInputs) < 2)
			return false;

		return true;
	}

	public static function processFieldInput($fieldInputStr, $validations)
	{
		$fieldInputs = explode(":", $fieldInputStr);

		$fieldName = $fieldInputs[0];

		$fieldTypeOptions = explode(",", $fieldInputs[1]);
		$fieldType = $fieldTypeOptions[0];
		$fieldTypeParams = [];
		if(sizeof($fieldTypeOptions) > 1)
		{
			for($i = 1; $i < sizeof($fieldTypeOptions); $i++)
				$fieldTypeParams[] = $fieldTypeOptions[$i];
		}

		$fieldOptions = [];
		if(sizeof($fieldInputs) > 2)
			$fieldOptions[] = $fieldInputs[2];

		return [
			'fieldName'       => $fieldName,
			'fieldInput'      => $fieldInputStr,
			'fieldType'       => $fieldType,
			'fieldTypeParams' => $fieldTypeParams,
			'fieldOptions'    => $fieldOptions,
			'validations'     => $validations
		];
	}

	public static function validateFieldsFile($fields)
	{
		$fieldsArr = [];

		foreach($fields as $field)
		{
			if(!self::validateFieldInput($field['field']))
				throw new \RuntimeException('Invalid Input ' . $field['field']);

			if(isset($field['validations']))
				$validations = $field['validations'];
			else
				$validations = [];

			$fieldsArr[] = self::processFieldInput($field['field'], $validations);
		}

		return $fieldsArr;
	}
}