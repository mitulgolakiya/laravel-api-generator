Laravel API/Scaffold/CRUD Generator (Laravel5.1)
=======================
[![Latest Stable Version](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/v/stable)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Total Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/downloads)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Monthly Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/d/monthly)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Daily Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/d/daily)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![Latest Unstable Version](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/v/unstable)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator) [![License](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/license)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator)

I enjoy creating API's and I have worked on many projects that required them. But the problem I always faced was setting up all the boilerplate code. For example each end point needs a migration, model, controller, repository, and on and on. I wanted a way to streamline this process and that is how this package was born.

This API generator allows you to use artisan commands to automatically generate all these files saving you time. Not only does it auto generate the files but it will set the namespaces. 

The artisan command can generate the following items:
  * Migration File
  * Model
  * Repository
  * Controller
  * View
    * index.blade.php
    * show.blade.php
    * create.blade.php
    * edit.blade.php
    * fields.blade.php
  * adjusts routes.php

And your simple CRUD API is ready in mere seconds.

Here is the full documentation.

[Upgrade Guide](https://github.com/mitulgolakiya/laravel-api-generator/blob/1.3/Upgrade_Guide.md).

Steps to Get Started
---------------------

1. Add this package to your composer.json:
  
        "require": {
            "mitulgolakiya/laravel-api-generator": "dev-master",
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>
   As we are using these two packages [illuminate/html](https://github.com/illuminate/html) & [laracasts/flash](https://github.com/laracasts/flash) as a dependency.<br>
   so we need to add those ServiceProviders as well.

		Collective\Html\HtmlServiceProvider::class,
		Laracasts\Flash\FlashServiceProvider::class,
		Mitul\Generator\GeneratorServiceProvider::class,
        
   Also for convenience, add these facades in alias array in ```config/app.php```.

		'Form'      => Collective\Html\FormFacade::class,
		'Html'      => Collective\Html\HtmlFacade::class,
		'Flash'     => Laracasts\Flash\Flash::class

4. Publish ```generator.php```

        php artisan vendor:publish --provider="Mitul\Generator\GeneratorServiceProvider"
        
5. Publish generator stuff

        php artisan mitul.generator:publisher

6. Fire artisan command to generate API, Scaffold with CRUD views or both API as well as CRUD views.

        php artisan mitul.generator:api ModelName
        php artisan mitul.generator:scaffold ModelName
        php artisan mitul.generator:scaffold_api ModelName
        
    e.g.
    
        php artisan mitul.generator:api Project
        php artisan mitul.generator:api Post
 
        php artisan mitul.generator:scaffold Project
        php artisan mitul.generator:scaffold Post
 
        php artisan mitul.generator:scaffold_api Project
        php artisan mitul.generator:scaffold_api Post
 
6. If you want to use SoftDelete trait with your models then you can specify softDelete option.
 
        php artisan mitul.generator:api ModelName --softDelete
        
    e.g.
    
        php artisan mitul.generator:api Post --softDelete
        
7. Enter the fields with options<br>

8. And you are ready to go. :)


# Full Documentation is Coming soon...

Documentation
--------------

### Generator Config file

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

### Field Input

Here is the input for the fields by which you can specify Input.

        fieldName:fieldType,options:fieldOptions
        
e.g.,

        email:string:unique
        email:string:default('me@mitul.me')
        title:string,100
        price:flat,8,4

Parameters will be in the same sequence as ```Blueprint``` class function for all types.
Option will be printed as it is given in input except unique & primary.

Screenshots
------------

### Command Execution
![Image of Command Execution]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RbTRvTEswQ0tfOEU)

### Generated Files & routes.php
![Image of Generated Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RZ1VMcXlsM1Z2MDg)

### Migration File
![Image of Migration File]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RMWtnN1RxUzdmTUE)

### Model File
![Image of Model File]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RRUJfdHE4MVRaeXM)

### Repository File
![Image of Repository File]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7ROUdNVTVORm5nQ1E)

### Controller File
![Image of Controller File]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RREVacVlOZDhxNDQ)

### View Files
![Image of View Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RQW5FOXExOFhEbms)


Credits
--------

This API Generator is created by [Mitul Golakiya](https://github.com/mitulgolakiya).

**Bugs & Forks are welcomed :)**
