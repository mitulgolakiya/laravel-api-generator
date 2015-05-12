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
		$fieldStr = "\t\t\t\$table->" . $field['fieldType'] . "('" . $field['fieldName'] . "'";

		if(!empty($field['fieldTypeParams']))
		{
			foreach($field['fieldTypeParams'] as $param)
			{
				$fieldStr .= ", " . $param;
			}
		}

		$fieldStr .= ")";

		if(count($field['fieldInputs']) > 1)
		{
            array_shift($field['fieldInputs']);
			foreach($field['fieldInputs'] as $option)
			{
				if(strstr($option,',')){
                    $params = explode(',',$option);
                    $fieldStr .= "->".$params[0]."(";
                    array_shift($params);
                    foreach($params as $param)
                    {
                        if(is_numeric($param)){
                            $fieldStr .= $param. ", " ;
                        }
                        else{
                            $fieldStr .= "'".$param."', " ;
                        }
                    }
                    $fieldStr = substr($fieldStr, 0, -2);
                    $fieldStr .= ")";
                }
				else

					$fieldStr .= "->" . $option."()";
			}
		}

		if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}
}