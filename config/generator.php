<?php

return [

	/*
	|--------------------------------------------------------------------------
	| Path for classes
	|--------------------------------------------------------------------------
	|
	| All Classes will be created on these relevant path
	|
	*/

	'path_migration' => base_path('database/migrations/'),

	'path_model' => app_path('Models/'),

	'path_repository' => app_path('Libraries/Repositories/'),

	'path_controller' => app_path('Http/Controllers/'),

	// specify API path in case you want to generate API`s controller along with Scaffold controller
	'path_api_controller' => app_path('Http/Controllers/API/'),

	'path_views' => base_path('resources/views'),

	'path_request' => app_path('Http/Requests/'),

	'path_routes' => app_path('Http/routes.php'),




	/*
	|--------------------------------------------------------------------------
	| Namespace for classes
	|--------------------------------------------------------------------------
	|
	| All Classes will be created with these namespaces
	|
	*/

	'namespace_model' => 'App\Models',

	'namespace_repository' => 'App\Libraries\Repositories',

	'namespace_controller' => 'App\Http\Controllers',

	// specify API namespace in case you want to generate API`s controller along with Scaffold controller
	// this path is relative to namespace_controller
	'namespace_api_controller' => 'API',

	'namespace_request' => 'App\Http\Requests',

	/*
	|--------------------------------------------------------------------------
	| Model extend
	|--------------------------------------------------------------------------
	|
	| Configuration for model extend.
	| By default Eloquent model will be used
	|
	*/

	// if false will use Eloquent model
	'model_extend' => false,

	// Namespace of extended model
	// eg. Illuminate\Database\Eloquent\Model
	// eg. Illuminate\Database\Eloquent\Model as Model
	'model_extend_namespace' => 'Illuminate\Database\Eloquent\Model',

	// Class name of extended class
	'model_extend_class' => 'Model',


	/*
	|--------------------------------------------------------------------------
	| API folder name and prefix for routes when Scaffold and API generated to gather
	|--------------------------------------------------------------------------
	|
	| Configuration api prefix and api folder name.
	| By default api will be prefix with
	|
	*/

	// this will generate api prefix when you are creating scaffold with API
	'api_prefix'	=>   'api',

];
