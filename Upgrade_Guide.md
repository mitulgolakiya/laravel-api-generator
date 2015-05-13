Laravel API/Scaffold/CRUD Generator Upgrade Guide (Laravel5)
=======================

Upgrade Guide from 1.2 to 1.3
-------------------------------------

We are no longer using our own ```APIExceptionsHandler``` to send API fail responses and using Laravel's own ```HttpResponseException``` to overcome ```App\Exceptions\Handler``` overwrite problem.

So we removed all extra Exception files. so you need to remove those things from your API Controllers.

1. In all your API Controllers and find ```throw new RecordNotFoundException```.

2. Replace it with ```$this->throwRecordNotFoundException```.

3. Remove use statements

        use Mitul\Generator\Exceptions\AppValidationException;
        use Mitul\Generator\Exceptions\RecordNotFoundException;

4. Remove throw statement from PHPDoc Blocks of functions

        @throws AppValidationException
        @throws RecordNotFoundException

5. Enjoy Upgrade :)

Upgrade Guide from 1.0 to 1.1 or 1.2
-------------------------------------

1. Take a backup of your ```config/generator.php```

2. Delete your ```config/generator.php```

3. Change version in composer.json

        "require": {
            "mitulgolakiya/laravel-api-generator": "1.2.*"
        }

4. Run composer update.

5. Run publish command again.

        php artisan vendor:publish --provider="Mitul\Generator\GeneratorServiceProvider"

6. Replace your custom paths again in ```config/generator.php```.

7. Enjoy Upgrade :)
