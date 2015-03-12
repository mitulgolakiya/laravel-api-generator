Laravel API/Scaffold/CRUD Generator (Laravel5)
=======================
[![Total Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/downloads.svg)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator)

I am fan of creating APIs. I have worked on so many projects of creating APIs. Laravel provides really good and handy commands to setup your all required files like Controller, Model, Migration etc.

But the problem that I was facing was, while starting any new project, I have to setup too many things step by step for creating basic CRUD API. Like create migration, model, controller, repository etc.
So it was little bit time consuming for me to create those all things to setup basic CRUD api for one model and repeat the same steps again for the another model.

So I have created one command where you just need to add fields as we are adding when creating migration and all rest things are created automatically and placed in our configured folders with given namespaces as well.

This command Generator generates following things:
  * Migration File
  * Model
  * Repository (optional)
  * Controller
  * View
    * index.blade.php
    * show.blade.php
    * create.blade.php
    * edit.blade.php
    * fields.blade.php
  * updates routes.php

And your simple CURD API is ready in less than 1 minute.

Here is the full documentation.

Steps to Get Started
----------------------

1. Add this package to your composer.json:
  
        "require": {
            "mitulgolakiya/laravel-api-generator": "dev-master"
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>
As we are using these two packages [illuminate/html](https://github.com/illuminate/html) & [laracasts/flash](https://github.com/laracasts/flash) as a dependency.<br>
so we need to add those ServiceProviders as well.

        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Laracasts\Flash\FlashServiceProvider'
        'Mitul\Generator\GeneratorServiceProvider'
        
Also for convenience, add these facades in alias array in ```config/app.php```.

		'Form'  => 'Illuminate\Html\FormFacade',
		'HTML'  => 'Illuminate\Html\HtmlFacade',
		'Flash' => 'Laracasts\Flash\Flash'

4. Publish generator.php

        php artisan vendor:publish --provider='Mitul\Generator\GeneratorServiceProvider'

5. Fire the artisan command to generate API for Model, or to generate scaffold with views for web applications

        php artisan mitul.generator:api ModelName
        php artisan mitul.generator:scaffold ModelName
        
    e.g.
    
        php artisan mitul.generator:api Project
        php artisan mitul.generator:api Post
 
        php artisan mitul.generator:scaffold Project
        php artisan mitul.generator:scaffold Post
 
6. Enter the fields with options<br>

7. And You are ready to go. :)


Documentation
--------------

### Generator Config file

Config file (```config/generator.php```) contains path for all generated files

```path_migration``` - Path where Migration file to ge generated<br>
```path_model``` - Path where Model file to ge generated<br>
```path_repository``` - Path where Repository file to ge generated<br>
```path_controller``` - Path where Controller file to ge generated<br>
```path_views``` - Path where views will be created<br>
```path_request``` -  Path where request file will be created<br>
```path_routes``` - Path of routes.php (if you are using any custom routes file)<br>

```namespace_model``` - Namespace of Model<br>
```namespace_repository``` - Namespace of Repository<br>
```namespace_controller``` - Namespace of Controller<br>
```namespace_request``` - Namespace for Request<br>

### Field Input

Here is the input for the fields by which you can specify Input.

        fieldName:fieldType,options:fieldOptions
        
e.g.,

        email:string:unique
        email:string:unique,default('me@mitul.me')
        title:string,100
        price:flat,8,4

Parameters will be in the same sequence as ```Blueprint``` class function for all types.
Option will be printed as it is given in input except unique & primary.

### API Response Structure
 
**Remember: This response structure is based on the most of my API response structure, you can change it to your API response after file generation in controller.**
 
**Success**

        {
            "flag":true,
            "message":"success message",
            "data":{}
        }


data can be anything as per response.

**Failure**

        {
            "flag":false,
            "message":"failure message",
            "code": 0
            "data":{}
        }

data will be optional. And code will be error code.

### Generated Views

While generating scaffold, all views are created with basic CRUD functionality. (**currently delete is not working**)

Views will be created in ```resources/views/modelName``` folder,

        index.blade.php - Main Index file for listing records
        create.blade.php - To insert a new record
        edit.blade.php - To edit a record
        fields.blade.php - Common file of all model fields, which will be used create and edit record
        show.blade.php - To display a record

Credits
--------

This API Generator is created by [Mitul Golakiya](https://github.com/mitulgolakiya).

**Bugs & Forks are welcomed :)**

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