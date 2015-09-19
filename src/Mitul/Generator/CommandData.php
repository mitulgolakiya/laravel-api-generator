<?php

namespace Mitul\Generator;

use Config;
use Illuminate\Support\Str;
use Mitul\Generator\Commands\APIGeneratorCommand;
use Mitul\Generator\File\FileHelper;
use Mitul\Generator\Utils\GeneratorUtils;

class CommandData
{
    public $modelName;
    public $modelNamePlural;
    public $modelNameCamel;
    public $modelNamePluralCamel;
    public $modelNamespace;

    public $tableName;
    public $fromTable;
    public $skipMigration;
    public $inputFields;

    /** @var  string */
    public $commandType;

    /** @var  APIGeneratorCommand */
    public $commandObj;

    /** @var FileHelper */
    public $fileHelper;

    /** @var TemplatesHelper */
    public $templatesHelper;

    /** @var  bool */
    public $useSoftDelete;

    /** @var  bool */
    public $paginate;

    /** @var  string */
    public $rememberToken;

    /** @var  string */
    public $fieldsFile;

    /** @var array */
    public $dynamicVars = [];

    public static $COMMAND_TYPE_API = 'api';
    public static $COMMAND_TYPE_SCAFFOLD = 'scaffold';
    public static $COMMAND_TYPE_SCAFFOLD_API = 'scaffold_api';

    public function __construct($commandObj, $commandType)
    {
        $this->commandObj = $commandObj;
        $this->commandType = $commandType;
        $this->fileHelper = new FileHelper();
        $this->templatesHelper = new TemplatesHelper();
    }

    public function initVariables()
    {
        $this->modelNamePlural = Str::plural($this->modelName);
        $this->modelNameCamel = Str::camel($this->modelName);
        $this->modelNamePluralCamel = Str::camel($this->modelNamePlural);
        $this->initDynamicVariables();
    }

    public function getInputFields()
    {
        $fields = [];

        $this->commandObj->info('Specify fields for the model (skip id & timestamp fields, will be added automatically)');
        $this->commandObj->info('Enter exit to finish');

        while (true) {
            $fieldInputStr = $this->commandObj->ask('Field: (field_name:field_database_type)', '');

            if (empty($fieldInputStr) || $fieldInputStr == false || $fieldInputStr == 'exit') {
                break;
            }

            if (!GeneratorUtils::validateFieldInput($fieldInputStr)) {
                $this->commandObj->error('Invalid Input. Try again');
                continue;
            }

            $type = $this->commandObj->ask('Enter field html input type (text): ', 'text');

            $validations = $this->commandObj->ask('Enter validations: ', false);

            $validations = ($validations == false) ? '' : $validations;

            $fields[] = GeneratorUtils::processFieldInput($fieldInputStr, $type, $validations);
        }

        return $fields;
    }

    public function initDynamicVariables()
    {
        $this->dynamicVars = self::getConfigDynamicVariables();

        $this->dynamicVars = array_merge($this->dynamicVars, [
            '$MODEL_NAME$'              => $this->modelName,

            '$MODEL_NAME_CAMEL$'        => $this->modelNameCamel,

            '$MODEL_NAME_PLURAL$'       => $this->modelNamePlural,

            '$MODEL_NAME_PLURAL_CAMEL$' => $this->modelNamePluralCamel,
        ]);

        if ($this->tableName) {
            $this->dynamicVars['$TABLE_NAME$'] = $this->tableName;
        } else {
            $this->dynamicVars['$TABLE_NAME$'] = $this->modelNamePluralCamel;
        }
    }

    public function addDynamicVariable($name, $val)
    {
        $this->dynamicVars[$name] = $val;
    }

    public static function getConfigDynamicVariables()
    {
        return [

            '$BASE_CONTROLLER$'          => Config::get('generator.base_controller', 'Mitul\Controller\AppBaseController'),

            '$NAMESPACE_CONTROLLER$'     => Config::get('generator.namespace_controller', 'App\Http\Controllers'),

            '$NAMESPACE_API_CONTROLLER$' => Config::get('generator.namespace_api_controller', 'App\Http\Controllers\API'),

            '$NAMESPACE_REQUEST$'        => Config::get('generator.namespace_request', 'App\Http\Requests'),

            '$NAMESPACE_REPOSITORY$'     => Config::get('generator.namespace_repository', 'App\Libraries\Repositories'),

            '$NAMESPACE_MODEL$'          => Config::get('generator.namespace_model', 'App\Models'),

            '$NAMESPACE_MODEL_EXTEND$'   => Config::get('generator.model_extend_class', 'Illuminate\Database\Eloquent\Model'),

            '$SOFT_DELETE_DATES$'        => "\n\tprotected \$dates = ['deleted_at'];\n",

            '$SOFT_DELETE$'              => "use SoftDeletes;\n",

            '$SOFT_DELETE_IMPORT$'       => "use Illuminate\\Database\\Eloquent\\SoftDeletes;\n",

            '$API_PREFIX$'               => Config::get('generator.api_prefix', 'api'),

            '$API_VERSION$'              => Config::get('generator.api_version', 'v1'),

            '$PRIMARY_KEY$'              => 'id',
        ];
    }
}
