<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/* Authentication Module Start */
 Route::get('/', ['as' => 'login', 'uses' => 'App\Http\Controllers\Auth\LoginController@login']);
//Route::get('login', 'App\Http\Controllers\Auth\LoginController@login')->name('login');
Route::get('logout', 'App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::post('login', 'App\Http\Controllers\Auth\LoginController@postLogin')->name('login');
Route::get('check_user_password', 'App\Http\Controllers\Auth\LoginController@CheckUserPassword');
// Route::post('change_user_password', 'App\Http\Controllers\Auth\LoginController@ChangeUserPassword');
Route::any('/store-in-session', 'App\Http\Controllers\Auth\LoginController@storeInSession');

Route::any('dashboard', 'App\Http\Controllers\DashboardController@dashboard')->name('dashboard');
Route::any('production_dashboard', 'App\Http\Controllers\ProductionController@dashboard')->name('production_dashboard');
Route::any('clients', 'App\Http\Controllers\ProductionController@clients')->name('clients');
Route::any('sub_projects', 'App\Http\Controllers\ProductionController@getSubProjects')->name('subProjects');
Route::any('clients/handle_row', 'App\Http\Controllers\ProductionController@handleRowClick')->name('client.handleRow');
Route::any('projects/{clientName}', 'App\Http\Controllers\ProductionController@clientTabs')->name('client.tabs');
Route::any('projects_assigned/{clientName}/{subProjectName}', 'App\Http\Controllers\ProductionController@clientAssignedTab')->name('clientAssigned');
Route::any('projects_pending/{clientName}/{subProjectName}', 'App\Http\Controllers\ProductionController@clientPendingTab')->name('clientPending');
Route::any('projects_hold/{clientName}/{subProjectName}', 'App\Http\Controllers\ProductionController@clientHoldTab')->name('clientHold');
Route::any('projects_completed/{clientName}/{subProjectName}', 'App\Http\Controllers\ProductionController@clientCompletedTab')->name('clientCompleted');
Route::any('projects_rework/{clientName}/{subProjectName}', 'App\Http\Controllers\ProductionController@clientReworkTab')->name('clientRework');
Route::any('projects_duplicate/{clientName}/{subProjectName}', 'App\Http\Controllers\ProductionController@clientDuplicateTab')->name('clientDuplicate');
Route::any('clients_duplicate_status', 'App\Http\Controllers\ProductionController@clientsDuplicateStatus');
Route::any('form_creation', 'App\Http\Controllers\FormController@formCreationIndex')->name('formCreationIndex');
Route::any('form_configuration_store', 'App\Http\Controllers\FormController@formConfigurationStore')->name('formConfigurationStore');
Route::any('sub_project_list', 'App\Http\Controllers\FormController@getSubProjectList')->name('subProjectList');
Route::any('form_configuration_list', 'App\Http\Controllers\FormController@formConfigurationList')->name('formConfigurationList');
Route::any('form_edit/{project_id}/{sub_project_id}', 'App\Http\Controllers\FormController@formEdit')->name('formEdit');
Route::any('form_configuration_update', 'App\Http\Controllers\FormController@formConfigurationUpdate')->name('formConfigurationUpdate');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
