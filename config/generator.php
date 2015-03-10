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

	'path_controller' => app_path('HTTP/Controllers/'),

	'path_views' => base_path('resources/views'),

	'path_request' => app_path('Http/Requests/'),

	'path_routes' => app_path('HTTP/routes.php'),


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

];