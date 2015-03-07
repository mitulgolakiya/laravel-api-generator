Laravel API Generator
=======================

I am fan of creating APIs. Laravel provides really good and handy commands to setup your all required files like Controller, Model, Migration etc.

But we need to generate it step by step. so it was little bit time consuming for me to create those all things to setup basic CRUD api for one model and repeat the same steps again for the new model.

So I have created one command where you just need to add fields as we are adding when creating migration and all rest things are created automatically and placed in our configured folders with given namespaces as well.

This command Generator generates following things:
  - Migration File
  - Model
  - Repository (optional)
  - Controller
  - updates routes.php

And your simple CURD API is ready in less than 1 minute.

Here is the full documentation.

Steps to Get Started
----------------------

1. Require this package with composer using the following command:
  
        composer require mitulgolakiya/laravel-api-generator
  
2. Run composer update

        composer update
    
3. add the ServiceProvider to the providers array in config/app.php

        'Mitul\APIGenerator\APIGeneratorServiceProvider'

4. Publish generator.php

        php artisan vendor:publish --provider='Mitul\APIGenerator\APIGeneratorServiceProvider'

5. Fire the artisan command

        php artisan mitul.generator:api ModelName
        
    e.g.
    
        php artisan mitul.generator:api Project
        php artisan mitul.generator:api Post
 
6. Enter the fields with options<br><br>

7. And You are ready to go. :)


Screen shots
------------

### Command Execution
![Image of Command Execution]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RbTRvTEswQ0tfOEU)

### Generated Files & routes.php
![Image of Generated Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RZ1VMcXlsM1Z2MDg)

### Migration File
![Image of Generated Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RMWtnN1RxUzdmTUE)

### Model File
![Image of Generated Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RRUJfdHE4MVRaeXM)

### Repository File
![Image of Generated Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7ROUdNVTVORm5nQ1E)

### Controller File
![Image of Generated Files]
(http://drive.google.com/uc?export=view&id=0B5kWGBdVjC7RREVacVlOZDhxNDQ)


Documentation
--------------

### Generator Config file

Config file (```config/generator.php```) contains path for all generated files

```path_migration``` - Path where Migration file to ge generated<br>
```path_model``` - Path where Model file to ge generated<br>
```path_repository``` - Path where Repository file to ge generated<br>
```path_controller``` - Path where Controller file to ge generated<br>
```path_routes``` - Path of routes.php (if you are using any custom routes file)<br>

```namespace_model``` - Namespace of Model<br>
```namespace_repository``` - Namespace of Repository<br>
```namespace_controller``` - Namespace of Controller<br>


### Supported Fields

 * boolean
 * int
 * float
 * string
 * text
 * timestamp
 * datetime
 * Default Timestamps (```created_at``` & ```updated_at```)
 
If you want to add more types, skip the migration at last and add fields to your migration file manually, and then run migration command. 

### Response Structure
 
**Remember: This response structure is based on the most of my API response structure, you can change it to your API response after file generation in controller.**
 
**Success**

```
{
"flag":true,
"message":"success message",
"data":{}
}
```

data can be anything as per response.

**Failure**

```
{
"flag":false,
"message":"failure message",
"code": 0
"data":{}
}
```

data will be optional. And code will be error code.


Directory Structure
--------------------

```
app
|-- Http
    |-- Controllers
        |-- AppBaseController.php - Base controller for all controllers
|-- Libraries - Custom Library Folder
    |-- Constants
        |-- Constants.php - All Constants goes here
    |-- Exceptions
        |-- AppValidationException.php - Validation failed exception
        |-- RecordNotFoundException.php - Record not found exception
    |-- Mitul - API Generator Files
    |-- Repositories - Contains all repositories
    |-- Utils
        |-- CommonAppUtils.php - Common Utils
        |-- ResponseManager.php - Response Prepare manager
|-- Models - Contains all Models
```

Credits
--------

This API Generator is created by [Mitul Golakiya](https://github.com/mitulgolakiya).