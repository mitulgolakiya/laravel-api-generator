<?php

namespace Mitul\Generator;

class SchemaGenerator
{
    public static function createField($field)
    {
        $fieldInputs = explode(':', $field);

        $fieldName = array_shift($fieldInputs);

        $fieldTypeInputs = array_shift($fieldInputs);

        $fieldTypeInputs = explode(',', $fieldTypeInputs);

        $fieldType = array_shift($fieldTypeInputs);

        $fieldStr = "\t\t\t\$table->".$fieldType."('".$fieldName."'";

        if (count($fieldTypeInputs) > 0) {
            foreach ($fieldTypeInputs as $param) {
                $fieldStr .= ', '.$param;
            }
        }

        $fieldStr .= ')';

        if (count($fieldInputs) > 0) {
            foreach ($fieldInputs as $input) {
                $input = explode(',', $input);

                $option = array_shift($input);

                $fieldStr .= '->'.$option.'(';

                if (count($input) > 0) {
                    foreach ($input as $param) {
                        $fieldStr .= "'".$param."', ";
                    }

                    $fieldStr = substr($fieldStr, 0, strlen($fieldStr) - 2);
                }

                $fieldStr .= ')';
            }
        }

        if (!empty($fieldStr)) {
            $fieldStr .= ";\n";
        }

        return $fieldStr;
    }
}
