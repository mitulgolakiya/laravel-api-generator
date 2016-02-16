Laravel API/Scaffold/CRUD Generator
=======================
[![Latest Stable Version](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/v/stable)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Total Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/downloads)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Monthly Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/d/monthly)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Daily Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/d/daily)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Latest Unstable Version](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/v/unstable)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![License](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/license)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator)

### Version Compability

 Laravel  | Branch 
:---------|:------------
 5.0      | [1.3](https://github.com/mitulgolakiya/laravel-api-generator/tree/1.3)
 5.1.*    | [1.4](https://github.com/mitulgolakiya/laravel-api-generator/tree/1.4)
 5.2.*    | [master](https://github.com/mitulgolakiya/laravel-api-generator)
 
I enjoy creating API's and I have worked on many projects that required them. But the problem I always faced was setting up all the boilerplate code. For example each end point needs a migration, model, controller, repository, and on and on. I wanted a way to streamline this process and that is how this package was born.

This API generator allows you to use artisan commands to automatically generate all these files saving you time. Not only does it auto generate the files but it will set the namespaces. 

The artisan command can generate the following items:
  * Migration File
  * Model
  * Repository
  * Controller
  * View
    * index.blade.php
    * table.blade.php
    * show.blade.php
    * show_fields.blade.php
    * create.blade.php
    * edit.blade.php
    * fields.blade.php
  * adjusts routes.php

And your simple CRUD and APIs are ready in mere seconds.

Here is the full documentation.

[Upgrade Guide](https://github.com/mitulgolakiya/laravel-api-generator/blob/master/Upgrade_Guide.md).

# Documentation is in process...

Documentation
--------------

1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Publish & Initialization](#publish--initialization)
4. [Generator](#generator)
5. [Supported Field Types](#supported-field-types)
5. [Customization](#customization)
	1. [Base Controller](#base-controller)
	2. [Customize Templates](#customize-templates)
	3. [Dingo API Integration](#dingo-api-integration)
6. [Options](#options)
	1. [Paginate Records](#paginate-records)
	2. [Model Soft Deletes](#model-soft-deletes)
	3. [Fields From File](#fields-from-file)
	4. [Custom Table Name](#custom-table-name)
	5. [Skip Migration](#skip-migration)
	6. [Remember Token](#remember-token)
7. [Generator from existing tables](#generator-from-existing-tables)

## Installation

1. Add this package to your composer.json:
  
        "require": {
            "laracasts/flash": "~1.3",
            "laravelcollective/html": "5.2.*",
            "bosnadev/repositories": "dev-master",
            "mitulgolakiya/laravel-api-generator": "dev-master"
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>
   As we are using these two packages [laravelcollective/html](https://github.com/LaravelCollective/html) & [laracasts/flash](https://github.com/laracasts/flash) as a dependency.<br>
   so we need to add those ServiceProviders as well.

		Collective\Html\HtmlServiceProvider::class,
		Laracasts\Flash\FlashServiceProvider::class,
		Mitul\Generator\GeneratorServiceProvider::class,
        
   Also for convenience, add these facades in alias array in ```config/app.php```.

		'Form'      => Collective\Html\FormFacade::class,
		'Html'      => Collective\Html\HtmlFacade::class,
		'Flash'     => Laracasts\Flash\Flash::class

## Configuration

Publish Configuration file ```generator.php```.

        php artisan vendor:publish --provider="Mitul\Generator\GeneratorServiceProvider"
        
Config file (```config/generator.php```) contains path for all generated files

```base_controller``` - Base Controller for all Controllers<br>

```path_migration``` - Path where Migration file to be generated<br>
```path_model``` - Path where Model file to be generated<br>
```path_repository``` - Path where Repository file to be generated<br>
```path_controller``` - Path where Controller file to be generated<br>
```path_api_controller``` - Path where API Controller file to be generated<br>
```path_views``` - Path where views will be created<br>
```path_request``` -  Path where request file will be created<br>
```path_routes``` - Path of routes.php (if you are using any custom routes file)<br>
```path_api_routes``` - Path of api_routes.php (this file will contain all api routes)<br>

```namespace_model``` - Namespace of Model<br>
```namespace_repository``` - Namespace of Repository<br>
```namespace_controller``` - Namespace of Controller<br>
```namespace_api_controller``` - Namespace of API Controller<br>
```namespace_request``` - Namespace for Request<br>

```model_extend_class``` - Extend class of Models<br>

```api_prefix``` - API Prefix
```api_version``` - API Version

```use_dingo_api``` - Integrate APIs with dingo/api package

## Publish & Initialization

Mainly, we need to do three basic things to get started.
1. Publish some common views like ```errors.blade.php``` & ```paginate.blade.php```.
2. Publish ```api_routes.php``` which will contain all our api routes.
3. Init ```routes.php``` for api routes. We need to include ```api_routes.php``` into main ```routes.php```.

        php artisan mitul.generator:publish

## Generator

Fire artisan command to generate API, Scaffold with CRUD views or both API as well as CRUD views.

Generate API:

        php artisan mitul.generator:api ModelName
    
Generate CRUD Scaffold:
 
        php artisan mitul.generator:scaffold ModelName
        
Generate CRUD Scaffold with API:
        
        php artisan mitul.generator:scaffold_api ModelName
        
e.g.
    
    php artisan mitul.generator:api Project
    php artisan mitul.generator:api Post

    php artisan mitul.generator:scaffold Project
    php artisan mitul.generator:scaffold Post

    php artisan mitul.generator:scaffold_api Project
    php artisan mitul.generator:scaffold_api Post

Here is the sample [fields input json](https://github.com/mitulgolakiya/laravel-api-generator/blob/master/samples/fields.json)

## Supported HTML Field Types

Here is the list of supported field types with options:
  * text
  * textarea
  * password
  * email
  * file
  * checkbox
  * radio:male,female,option3,option4
  * number
  * date
  * select:India,USA

## Customization

### Base Controller

If you want to use your own base controller or want to extend/modify default AppBaseController then you can have following options:

1. If you want to use another controller (recommended to extends AppBaseController with new controller) as base controller then modify ```base_controller``` value in ```config/generator.php```

2. If you want to modify AppBaseController then,

    1. Publish AppBaseController in your controllers path
    
        php artisan mitul.generator:publish --baseController
        
    2. Modify the content of ```AppBaseController.php``` and set it as a ```base_controller``` in ```config/generator.php```

### Customize Templates

To use your own custom templates,

1. Publish templates to  ```/resources/api-generator-templates```

        php artisan mitul.generator:publish --templates

2. Leave only those templates that you want to change. Remove the templates that do not plan to change.

## Options

### Paginate Records

To paginate records, you can specify paginate option,
e.g.

        php artisan mitul.generator:api Post --paginate=10

### Model Soft Deletes

To use SoftDelete, use softDelete option,

        php artisan mitul.generator:api Post --softDelete

### Fields From File

If you want to pass fields from file then you can create fields json file and pass it via command line. Here is the sample [fields.json](https://github.com/mitulgolakiya/laravel-api-generator/blob/master/samples/fields.json)

You have to pass option ```--fieldsFile=absolute_file_path_or_path_from_base_directory``` with command. e.g.

         php artisan mitul.generator:scaffold_api Post --fieldsFile="/Users/Mitul/laravel-api-generator/fields.json"
         php artisan mitul.generator:scaffold_api Post --fieldsFile="fields.json"

### Custom Table Name

You can also specify your own custom table name by,

        php artisan mitul.generator:api Post --tableName=custom_table_name

### Skip Migration

You can also skip migration generation,

        php artisan mitul.generator:api Post --skipMigration

### Remember Token

To generate rememberToken field in migration file,

        php artisan mitul.generator:api Post --rememberToken

## Generator from existing tables

To use generator with existing table, you can specify ```--fromTable``` option. ```--tableName``` option is required and you need to specify table name.

Just make sure, you have installed ```doctrine/dbal``` package.

**Limitation:** As of now it is not fully working (work is in progress). It will not create migration file. You need to tweak some of the things in your generated files like timestamps, primary key etc. 

        php artisan mitul.generator:api Post --fromTable --tableName=posts

Credits
--------

This API Generator is created by [Mitul Golakiya](https://github.com/mitulgolakiya).

**Bugs & Forks are welcomed :)**
