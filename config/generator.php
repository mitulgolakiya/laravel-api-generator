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
];
