Laravel API/Scaffold/CRUD Generator (Laravel5)
=======================
[![Total Downloads](https://poser.pugx.org/mitulgolakiya/laravel-api-generator/downloads.svg)](https://packagist.org/packages/mitulgolakiya/laravel-api-generator)

I enjoy creating API's and I have worked on many projects that required them. But the problem I always faced was setting up all the boilerplate code. For example each end point needs a migration, model, controller, repository, and on and on. I wanted a way to streamline this process and that is how this package was born. 

This API generator allows you to use artisan commands to automatically generate all these files saving you time. Not only does it auto generate the files but it will set the namespaces. 

The artisan command can generate the following items:
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
  * adjusts routes.php

And your simple CRUD API is ready in mere seconds.

Here is the full documentation.

Steps to Get Started
----------------------

1. Add this package to your composer.json:
  
        "require": {
            "mitulgolakiya/laravel-api-generator": "~1.0"
        }
  
2. Run composer update

        composer update
    
3. Add the ServiceProviders to the providers array in ```config/app.php```.<br>
As we are using these two packages [illuminate/html](https://github.com/illuminate/html) & [laracasts/flash](https://github.com/laracasts/flash) as a dependency.<br>
so we need to add those ServiceProviders as well.

        'Illuminate\View\ViewServiceProvider',
        'Illuminate\Html\HtmlServiceProvider',
        'Laracasts\Flash\FlashServiceProvider',
        'Mitul\Generator\GeneratorServiceProvider'
        
Also for convenience, add these facades in alias array in ```config/app.php```.

		'Form'  => 'Illuminate\Html\FormFacade',
		'HTML'  => 'Illuminate\Html\HtmlFacade',
		'Flash' => 'Laracasts\Flash\Flash'

4. Publish generator.php

        php artisan vendor:publish --provider="Mitul\Generator\GeneratorServiceProvider"

5. Fire the artisan command to generate API or to generate scaffold with views for web applications or both.

        php artisan mitul.generator:api ModelName
        php artisan mitul.generator:scaffold ModelName
        php artisan mitul.generator:scaffoldAPI ModelName
        
    e.g.
    
        php artisan mitul.generator:api Project
        php artisan mitul.generator:api Post
 
        php artisan mitul.generator:scaffold Project
        php artisan mitul.generator:scaffold Post
        
        php artisan mitul.generator:scaffoldAPI Project
        php artisan mitul.generator:scaffoldAPI Post
 
6. Enter the fields with options<br>

7. And you are ready to go. :)


Documentation
--------------

### Generator Config file

Config file (```config/generator.php```) contains path for all generated files

```path_migration``` - Path where Migration file to be generated<br>
```path_model``` - Path where Model file to be generated<br>
```path_repository``` - Path where Repository file to be generated<br>
```path_controller``` - Path where Controller file to be generated<br>
```path_api_controller``` - Path where API Controller file to be generated in case of scaffoldAPI(folder must me created)<br> 
```path_views``` - Path where views will be created<br>
```path_request``` -  Path where request file will be created<br>
```path_routes``` - Path of routes.php (if you are using any custom routes file)<br>

```namespace_model``` - Namespace of Model<br>
```namespace_repository``` - Namespace of Repository<br>
```namespace_controller``` - Namespace of Controller<br>
```namespace_api_controller``` - Namespace of API Controller in case of scaffoldAPI(path is relative to ```namespace_controller```)<br>
```namespace_request``` - Namespace for Request<br>


```model_extend``` - Use custom Model extend<br>
```model_extend_namespace``` - Namespace of custom extended model<br>
```model_extend_class``` - Class name to extend<br>


```api_prefix``` - prefix url for apis in case of scaffoldAPI

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

While generating scaffold, all views are created with basic CRUD functionality.

Views will be created in ```resources/views/modelName``` folder,

        index.blade.php - Main Index file for listing records
        create.blade.php - To insert a new record
        edit.blade.php - To edit a record
        fields.blade.php - Common file of all model fields, which will be used create and edit record
        show.blade.php - To display a record
        
While generating scaffold with APIs, repository will be generated, Controllers for view will be generated in Controller folder and Controller for API will be generated in specified in API Controller folder.


url for api is generated with api_prefix value i.e

        if api_prefix is api then url is like htttp://example.com/api/model 
        

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
