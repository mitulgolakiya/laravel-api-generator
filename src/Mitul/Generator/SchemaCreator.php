<?php
/**
 * User: Mitul
 * Date: 14/02/15
 * Time: 5:04 PM
 */

namespace Mitul\Generator;


class SchemaCreator
{
	public static function createField($field)
	{
		$fieldInputs = explode(' ', $field);
		$fieldName = array_shift($fieldInputs);

		$fieldTypeInputs = array_shift($fieldInputs);

		$fieldTypeInputs = explode(",", $fieldTypeInputs);

		$fieldType = array_shift($fieldTypeInputs);

		$fieldStr = "\t\t\t\t\$table->" . $fieldType . "('" . $fieldName . "'";

		if(sizeof($fieldTypeInputs) > 0)
		{
			foreach($fieldTypeInputs as $param)
			{
				$fieldStr .= ", " . $param;
			}
		}

		$fieldStr .= ")";

		if(sizeof($fieldInputs) > 0)
		{
			$fieldInputs = explode('|', array_shift($fieldInputs));
			foreach($fieldInputs as $input)
			{
				if (strpos($input, '(') && strpos($input, ')')) {
					$fieldStr .= '->' . $input;
				} else {
					$input = explode(":", $input);

					$option = array_shift($input);

					$fieldStr .= '->' . $option . '(';

					if(sizeof($input) > 0)
					{
						foreach($input as $param)
						{
							$fieldStr .= "'" . $param . "', ";
						}

						$fieldStr = substr($fieldStr, 0, strlen($fieldStr) - 2);
					}

					$fieldStr .= ")";
				}
			}
		}

        if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}
}
