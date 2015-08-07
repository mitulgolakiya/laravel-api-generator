<?php

namespace Mitul\Generator\Utils;

class GeneratorUtils
{
    public static function validateFieldInput($fieldInputStr)
    {
        $fieldInputs = explode(':', $fieldInputStr);

        if (count($fieldInputs) < 2) {
            return false;
        }

        return true;
    }

    public static function processFieldInput($fieldInputStr, $type, $validations)
    {
        $fieldInputs = explode(':', $fieldInputStr);

        $fieldName = $fieldInputs[0];

        $fieldTypeOptions = explode(',', $fieldInputs[1]);
        $fieldType = $fieldTypeOptions[0];
        $fieldTypeParams = [];
        if (count($fieldTypeOptions) > 1) {
            for ($i = 1; $i < count($fieldTypeOptions); $i++) {
                $fieldTypeParams[] = $fieldTypeOptions[$i];
            }
        }

        $fieldOptions = [];
        if (count($fieldInputs) > 2) {
            $fieldOptions[] = $fieldInputs[2];
        }

        $typeOptions = explode(':', $type);
        $type = $typeOptions[0];
        if (count($typeOptions) > 1) {
            $typeOptions = $typeOptions[1];
        } else {
            $typeOptions = [];
        }

        return [
            'fieldName'       => $fieldName,
            'type'            => $type,
            'typeOptions'     => $typeOptions,
            'fieldInput'      => $fieldInputStr,
            'fieldType'       => $fieldType,
            'fieldTypeParams' => $fieldTypeParams,
            'fieldOptions'    => $fieldOptions,
            'validations'     => $validations,
        ];
    }

    public static function validateFieldsFile($fields)
    {
        $fieldsArr = [];

        foreach ($fields as $field) {
            if (!self::validateFieldInput($field['field'])) {
                throw new \RuntimeException('Invalid Input '.$field['field']);
            }

            if (isset($field['type'])) {
                $type = $field['type'];
            } else {
                $type = 'text';
            }

            if (isset($field['validations'])) {
                $validations = $field['validations'];
            } else {
                $validations = [];
            }

            $fieldsArr[] = self::processFieldInput($field['field'], $type, $validations);
        }

        return $fieldsArr;
    }

    public static function fillTemplate($variables, $template)
    {
        foreach ($variables as $variable => $value) {
            $template = str_replace($variable, $value, $template);
        }

        return $template;
    }
}
