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

/* Can not use closures with caching
Route::get('/', function () {
    return redirect('login');
});
*/
Route::get('/', 'HomeController@index');

/*
// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');
*/

// Authentication
/*
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
*/

Route::post('login', 'Auth\LoginController@login');
Route::post('register', 'Auth\RegisterController@register');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Projects

Route::get('projects', 'ProjectsController@index');
Route::post('projects', 'ProjectsController@store');
Route::get('projects/new', 'ProjectsController@create');
Route::post('projects/search', 'ProjectsController@search');
Route::get('projects/{id}', 'ProjectsController@dashboard');
Route::delete('api/projects/{id}/leave', 'ProjectsController@leave');
Route::delete('api/projects/{id}/delete', 'ProjectsController@destroy');

// Project Settings

Route::get('api/projects/{id}/settings', 'ProjectSettingsController@show');
Route::put('api/projects/{id}/settings', 'ProjectSettingsController@update');
Route::get('api/projects/{id}/members', 'ProjectSettingsController@members');
Route::post('projects/{id_project}/add', 'ProjectSettingsController@addMember');
Route::delete('projects/{id_project}/remove', 'ProjectSettingsController@removeMember');

// Tasks

Route::get('api/projects/{id_project}/tasks/{id_task}', 'TasksController@retrieve');
Route::put('api/projects/{id_project}/tasks/{id_task}', 'TasksController@update');
Route::post('api/projects/{id_project}/tasks', 'TasksController@store');

Route::put('api/projects/{id_project}/tasks/{id_task}/listName', 'TasksController@changeList');

// SubTasks

Route::post('api/projects/{id_project}/tasks/{id_task}/subtasks', 'SubTasksController@store');
Route::delete('api/projects/{id_project}/tasks/{id_task}/subtasks/{id_subtask}', 'SubTasksController@destroy');

// Forums

Route::get('projects/{id}/forums', 'ForumsController@forums');
Route::get('projects/{id}/forums/{forum_id}', 'ForumsController@forum');
Route::post('projects/{id}/forums/create_forum', 'ForumsController@store');
Route::post('projects/{id_project}/forums/{id_forum}/create_comment', 'ForumCommentsController@store');
Route::delete('projects/{id_project}/forums/{id_forum}/{id_forum_comment}', 'ForumCommentsController@destroy');
Route::put('projects/{id_project}/forums/{id_forum}/{id_forum_comment}', 'ForumCommentsController@update');

// Profile

Route::get('profile', 'ProfileController@index');
Route::get('profile/edit', 'ProfileController@edit');
Route::patch('profile', 'ProfileController@update');
Route::get('profile/{id_member}', 'ProfileController@show');

// Member

Route::get('projects/{id}/members', 'MemberController@index');

// Notification

Route::get('api/notifications', 'NotificationsController@index');

// Admin

Route::get('admin', 'AdminController@index');
