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

<<<<<<< HEAD
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

=======
		if(!empty($field['fieldOptions']))
		{
			foreach($field['fieldOptions'] as $option)
			{
				if($option == 'primary')
					$fieldStr .= "->primary()";
				elseif($option == 'unique')
					$fieldStr .= "->unique()";
				else
					$fieldStr .= "->" . $option;
>>>>>>> origin/1.3
			}
		}

		if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}
}