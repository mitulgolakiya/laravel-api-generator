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
		$fieldInputs = explode(':', $field);

		$fieldName = array_shift($fieldInputs);

		$fieldTypeInputs = array_shift($fieldInputs);

		$fieldTypeInputs = explode(",", $fieldTypeInputs);

		$fieldType = array_shift($fieldTypeInputs);

		$fieldStr = "\t\t\t\$table->" . $fieldType . "('" . $fieldName . "'";

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
            foreach($fieldInputs as $input) {

                $optionsInput = explode(",", $input);

                $fieldStr .= '->' . $optionsInput[0] . '(';
                unset($optionsInput[0]);

                if (sizeof($optionsInput) > 0) {

                    foreach ($optionsInput as $param) {
                        $fieldStr .= "'" . $param . "', ";
                    }
                    $fieldStr = substr($fieldStr, 0, strlen($fieldStr) - 2);
                }

                $fieldStr .= ")";
            }
        }

        if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}
}