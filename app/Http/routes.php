<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'IndexController@index');

// Login
//Route::get('login', 'LoginController@login_get'); // not done
//Route::post('login', 'LoginController@login_post'); // not done

// Profiles
Route::get('profile', 'ProfileController@profile_get'); // not done
Route::post('profile', 'ProfileController@profile_post'); // not done
Route::get('profile/{name}', 'ProfileController@profile_view'); // not done

// Locales
Route::get('locales', [ 'as' => 'locales', 'uses' => 'LocaleController@index' ]); // not done
Route::get('locales/{locale}', [ 'as' => 'locale', 'uses' => 'LocaleController@single' ]); // not done
Route::get('locales/{locale}/{slug}', 'LocaleController@single'); // not done

// Translation sets
$set = 'projects/{project}/{locale}/{set}';
Route::post($set . '/-bulk', 'TranslationController@bulk_post'); // not done
Route::get($set . '/import-translations', 'TranslationController@import_translations_get'); // not done
Route::post($set . '/import-translations', 'TranslationController@import_translations_post'); // not done
Route::post($set . '/-discard-warning', 'TranslationController@discard_warning'); // not done
Route::post($set . '/-set-status', 'TranslationController@set_status'); // not done
Route::match(['get', 'post'], $set . '/export-translations', 'TranslationController@export_translations_get'); // not done

// keep this below all URLs ending with a literal string, because it may catch one of them
Route::get($set, [ 'as' => 'translation-set', 'uses' => 'TranslationController@translations_get' ]); // not done
Route::post($set, 'TranslationController@translations_post'); // not done

// Projects
Route::get('projects/{project}/import-originals', 'ProjectController@import_originals_get'); // not done
Route::post('projects/{project}/import-originals', 'ProjectController@import_originals_post'); // not done

Route::get('projects/{project}/-edit', 'ProjectController@edit_get'); // not done
Route::post('projects/{project}/-edit', 'ProjectController@edit_post'); // not done

Route::get('projects/{project}/-delete', 'ProjectController@delete_get'); // not done
Route::post('projects/{project}/-delete', 'ProjectController@delete_post'); // not done

Route::post('projects/{project}/-personal', 'ProjectController@personal_options_post'); // not done

Route::get('projects/{project}/-permissions', 'ProjectController@permissions_get'); // not done
Route::post('projects/{project}/-permissions', 'ProjectController@permissions_post'); // not done
Route::get('projects/{project}/-permissions/-delete', 'ProjectController@permissions_delete'); // not done

Route::get('projects/{project}/-mass-create-sets', 'ProjectController@mass_create_sets_get'); // not done
Route::post('projects/{project}/-mass-create-sets', 'ProjectController@mass_create_sets_post'); // not done
Route::post('projects/{project}/-mass-create-sets/preview', 'ProjectController@mass_create_sets_preview_post'); // not done

Route::get('projects/{project}/-branch', 'ProjectController@branch_project_get'); // not done
Route::post('projects/{project}/-branch', 'ProjectController@branch_project_post'); // not done

Route::get('projects', [ 'as' => 'projects', 'uses' => 'ProjectController@index' ]); // not done
Route::get('projects/-new', 'ProjectController@new_get'); // not done
Route::post('projects/-new', 'ProjectController@new_post'); // not done

Route::get('projects/{project}', [ 'as' => 'project', 'uses' => 'ProjectController@single' ]); // not done


Route::controllers([
	'password' => 'Auth\PasswordController',
	''         => 'Auth\AuthController',
]);


/*

62	                        "get:/$set/glossary" => array('GP_Route_Glossary_Entry', 'glossary_entries_get'),
63	                        "post:/$set/glossary" => array('GP_Route_Glossary_Entry', 'glossary_entries_post'),
64	                        "post:/$set/glossary/-new" => array('GP_Route_Glossary_Entry', 'glossary_entry_add_post'),
65	                        "post:/$set/glossary/-delete" => array('GP_Route_Glossary_Entry', 'glossary_entry_delete_post'),
66	                        "get:/$set/glossary/-export" => array('GP_Route_Glossary_Entry', 'export_glossary_entries_get'),
67	                        "get:/$set/glossary/-import" => array('GP_Route_Glossary_Entry', 'import_glossary_entries_get'),
68	                        "post:/$set/glossary/-import" => array('GP_Route_Glossary_Entry', 'import_glossary_entries_post'),
69	
108	
109	                        "get:/sets/-new" => array('GP_Route_Translation_Set', 'new_get'),
110	                        "post:/sets/-new" => array('GP_Route_Translation_Set', 'new_post'),
111	                        "get:/setprojectss/$id" => array('GP_Route_Translation_Set', 'single'),
112	                        "get:/sets/$id/-edit" => array('GP_Route_Translation_Set', 'edit_get'),
113	                        "post:/sets/$id/-edit" => array('GP_Route_Translation_Set', 'edit_post'),
114	
115	                        "get:/glossaries/-new" => array('GP_Route_Glossary', 'new_get'),
116	                        "post:/glossaries/-new" => array('GP_Route_Glossary', 'new_post'),
117	                        "get:/glossaries/$id/-edit" => array('GP_Route_Glossary', 'edit_get'),
118	                        "post:/glossaries/$id/-edit" => array('GP_Route_Glossary', 'edit_post'),
119	
120	                        "post:/originals/$id/set_priority" => array('GP_Route_Original', 'set_priority'),

*/