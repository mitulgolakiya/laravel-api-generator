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
			}
		}

		if(!empty($fieldStr))
			$fieldStr .= ";\n";

		return $fieldStr;
	}
}