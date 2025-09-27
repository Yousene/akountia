<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PublicReviewController;
use App\Http\Controllers\CertificateController;


Auth::routes();

// Quicky Routes

Route::any('/admin', 'AdminController@index')->name('admin.admin')->middleware('check-perm');


Route::any('/', 'HomeController@index')->name('home');

Route::any('/dashboard', 'AdminController@index')->name('admin')->middleware('check-perm');

//
Route::resource('user', 'UserController')->except(['show']);
Route::any('user/profil', 'UserController@myProfil')->name('user.profil');
Route::get('user/data', 'UserController@data')->name('user.data');

// role
Route::any('/role/list', 'RoleController@list')->name('role_list');
Route::any('/role/create', 'RoleController@create')->name('role_create')->middleware('check-perm');
Route::any('/role/update/{role}', 'RoleController@update')->name('role_update');
Route::any('/role/delete/{role}', 'RoleController@delete')->name('role_delete');

// ressource
Route::any('/ressource/list', 'RessourceController@list')->name('ressource_list');
Route::any('/ressource/create', 'RessourceController@create')->name('ressource_create');
Route::any('/ressource/update/{ressource}', 'RessourceController@update')->name('ressource_update');
Route::any('/ressource/delete/{ressource}', 'RessourceController@delete')->name('ressource_delete');

// fonctionnalite
Route::any('/fonctionnalite/list', 'FonctionnaliteController@list')->name('fonctionnalite_list');
Route::any('/fonctionnalite/create', 'FonctionnaliteController@create')->name('fonctionnalite_create');
Route::any('/fonctionnalite/update/{fonctionnalite}', 'FonctionnaliteController@update')->name('fonctionnalite_update');
Route::any('/fonctionnalite/delete/{fonctionnalite}', 'FonctionnaliteController@delete')->name('fonctionnalite_delete');

// apparence
Route::any('/apparence/list', 'ApparenceController@list')->name('apparence_list');
Route::any('/apparence/create', 'ApparenceController@create')->name('apparence_create');
Route::any('/apparence/update/{apparence}', 'ApparenceController@update')->name('apparence_update');
Route::any('/apparence/delete/{apparence}', 'ApparenceController@delete')->name('apparence_delete');

// quickyproject
Route::resource('quickyproject', 'QuickyprojectController')->except(['show']);
Route::get('quickyproject/data', 'QuickyprojectController@data')->name('quickyproject.data');

// menu
Route::any('/menu/list', 'MenuController@list')->name('menu_list');
Route::any('/menu/create', 'MenuController@create')->name('menu_create');
Route::any('/menu/update/{menu}', 'MenuController@update')->name('menu_update');
Route::any('/menu/delete/{menu}', 'MenuController@delete')->name('menu_delete');
Route::post('/menu/updateOrder', 'MenuController@updateOrder')->name('update_menus_drag');

// permission
Route::resource('permission', 'PermissionController')->except(['show']);
Route::get('permission/data', 'PermissionController@data')->name('permission.data');
Route::post('/permissions/refresh', 'PermissionController@refresh')->name('permissions.refresh');

// rolepermission
Route::resource('rolepermission', 'RolepermissionController')->except(['show']);
Route::get('rolepermission/data', 'RolepermissionController@data')->name('rolepermission.data');

// company
Route::resource('company', 'CompanyController')->except(['show']);
Route::get('company/data', 'CompanyController@data')->name('company.data');

// search bar
Route::get('searchbar/data', [SearchController::class, 'getSearchData'])->name('search.data');

// Generated Routes



// category
Route::resource('category', 'CategoryController')->except(['show']);
Route::get('category/data', 'CategoryController@data')->name('category.data');

// course
Route::resource('course', 'CourseController')->except(['show']);
Route::get('course/data', 'CourseController@data')->name('course.data');





// client
Route::resource('client', 'ClientController')->except(['show']);
Route::get('client/data', 'ClientController@data')->name('client.data');

// contact
Route::resource('contact', 'ContactController')->except(['show']);
Route::get('contact/data', 'ContactController@data')->name('contact.data');

// statut
Route::resource('statut', 'StatutController')->except(['show']);
Route::get('statut/data', 'StatutController@data')->name('statut.data');

// lead
Route::resource('lead', 'LeadController')->except(['show']);
Route::get('lead/data', 'LeadController@data')->name('lead.data');

// review
Route::resource('review', 'ReviewController')->except(['show']);
Route::get('review/data', 'ReviewController@data')->name('review.data');

// Routes pour les avis publics
Route::get('/avis/nouveau', [PublicReviewController::class, 'create'])->name('public.review.create');
Route::post('/avis/enregistrer', [PublicReviewController::class, 'store'])->name('public.review.store');

// Routes pour les certificats
Route::get('/certificate', 'CertificateController@index')->name('certificate.index');
