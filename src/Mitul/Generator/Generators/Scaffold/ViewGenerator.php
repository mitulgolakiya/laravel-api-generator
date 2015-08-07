<?php

namespace Mitul\Generator\Generators\Scaffold;

use Config;
use Illuminate\Support\Str;
use Mitul\Generator\CommandData;
use Mitul\Generator\FormFieldsGenerator;
use Mitul\Generator\Generators\GeneratorProvider;
use Mitul\Generator\Utils\GeneratorUtils;

class ViewGenerator implements GeneratorProvider
{
    /** @var  CommandData */
    private $commandData;

    /** @var string */
    private $path;

    /** @var string */
    private $viewsPath;

    public function __construct($commandData)
    {
        $this->commandData = $commandData;
        $this->path = Config::get('generator.path_views', base_path('resources/views')).'/'.$this->commandData->modelNamePluralCamel.'/';
        $this->viewsPath = 'scaffold/views';
    }

    public function generate()
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0755, true);
        }

        $this->commandData->commandObj->comment("\nViews created: ");
        $this->generateFields();
        $this->generateShowFields();
        $this->generateTable();
        $this->generateIndex();
        $this->generateShow();
        $this->generateCreate();
        $this->generateEdit();
    }

    private function generateFields()
    {
        $fieldTemplate = $this->commandData->templatesHelper->getTemplate('field.blade', $this->viewsPath);

        $fieldsStr = '';

        foreach ($this->commandData->inputFields as $field) {
            switch ($field['type']) {
                case 'text':
                    $fieldsStr .= FormFieldsGenerator::text($fieldTemplate, $field)."\n\n";
                    break;
                case 'textarea':
                    $fieldsStr .= FormFieldsGenerator::textarea($fieldTemplate, $field)."\n\n";
                    break;
                case 'password':
                    $fieldsStr .= FormFieldsGenerator::password($fieldTemplate, $field)."\n\n";
                    break;
                case 'email':
                    $fieldsStr .= FormFieldsGenerator::email($fieldTemplate, $field)."\n\n";
                    break;
                case 'file':
                    $fieldsStr .= FormFieldsGenerator::file($fieldTemplate, $field)."\n\n";
                    break;
                case 'checkbox':
                    $fieldsStr .= FormFieldsGenerator::checkbox($fieldTemplate, $field)."\n\n";
                    break;
                case 'radio':
                    $fieldsStr .= FormFieldsGenerator::radio($fieldTemplate, $field)."\n\n";
                    break;
                case 'number':
                    $fieldsStr .= FormFieldsGenerator::number($fieldTemplate, $field)."\n\n";
                    break;
                case 'date':
                    $fieldsStr .= FormFieldsGenerator::date($fieldTemplate, $field)."\n\n";
                    break;
                case 'select':
                    $fieldsStr .= FormFieldsGenerator::select($fieldTemplate, $field)."\n\n";
                    break;
            }
        }

        $templateData = $this->commandData->templatesHelper->getTemplate('fields.blade', $this->viewsPath);

        $templateData = str_replace('$FIELDS$', $fieldsStr, $templateData);

        $fileName = 'fields.blade.php';

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info('field.blade.php created');
    }

    private function generateShowFields()
    {
        $fieldTemplate = $this->commandData->templatesHelper->getTemplate('show_field.blade', $this->viewsPath);

        $fieldsStr = '';

        foreach ($this->commandData->inputFields as $field) {
            $singleFieldStr = str_replace('$FIELD_NAME_TITLE$', Str::title(str_replace('_', ' ', $field['fieldName'])), $fieldTemplate);
            $singleFieldStr = str_replace('$FIELD_NAME$', $field['fieldName'], $singleFieldStr);
            $singleFieldStr = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $singleFieldStr);

            $fieldsStr .= $singleFieldStr."\n\n";
        }

        $fileName = 'show_fields.blade.php';

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $fieldsStr);
        $this->commandData->commandObj->info('show-field.blade.php created');
    }

    private function generateIndex()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate('index.blade', $this->viewsPath);

        $templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

        if ($this->commandData->paginate) {
            $paginateTemplate = $this->commandData->templatesHelper->getTemplate('paginate.blade', 'scaffold/views');

            $paginateTemplate = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $paginateTemplate);

            $templateData = str_replace('$PAGINATE$', $paginateTemplate, $templateData);
        } else {
            $templateData = str_replace('$PAGINATE$', '', $templateData);
        }

        $fileName = 'index.blade.php';

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info('index.blade.php created');
    }

    private function generateTable()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate('table.blade', $this->viewsPath);

        $templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

        $fileName = 'table.blade.php';

        $headerFields = '';

        foreach ($this->commandData->inputFields as $field) {
            $headerFields .= '<th>'.Str::title(str_replace('_', ' ', $field['fieldName']))."</th>\n\t\t\t";
        }

        $headerFields = trim($headerFields);

        $templateData = str_replace('$FIELD_HEADERS$', $headerFields, $templateData);

        $tableBodyFields = '';

        foreach ($this->commandData->inputFields as $field) {
            $tableBodyFields .= '<td>{!! $'.$this->commandData->modelNameCamel.'->'.$field['fieldName']." !!}</td>\n\t\t\t";
        }

        $tableBodyFields = trim($tableBodyFields);

        $templateData = str_replace('$FIELD_BODY$', $tableBodyFields, $templateData);

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info('table.blade.php created');
    }

    private function generateShow()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate('show.blade', $this->viewsPath);

        $templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

        $fileName = 'show.blade.php';

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info('show.blade.php created');
    }

    private function generateCreate()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate('create.blade', $this->viewsPath);

        $templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

        $fileName = 'create.blade.php';

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info('create.blade.php created');
    }

    private function generateEdit()
    {
        $templateData = $this->commandData->templatesHelper->getTemplate('edit.blade', $this->viewsPath);

        $templateData = GeneratorUtils::fillTemplate($this->commandData->dynamicVars, $templateData);

        $fileName = 'edit.blade.php';

        $path = $this->path.$fileName;

        $this->commandData->fileHelper->writeFile($path, $templateData);
        $this->commandData->commandObj->info('edit.blade.php created');
    }
}
