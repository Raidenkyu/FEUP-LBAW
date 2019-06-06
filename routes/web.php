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
Route::put('api/projects/{id_project}/tasks/{id_task}/subtasks/{id_subtask}', 'SubTasksController@update');

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
Route::get('profile/{id}/image', 'ImageController@getImageJSON');
Route::delete('api/profile/{id_member}/delete', 'ProfileController@delete');

// Member

Route::get('projects/{id}/members', 'MemberController@index');

// Notification

Route::get('api/notifications', 'NotificationsController@index');
Route::delete('api/notifications/{id}', 'NotificationsController@destroy');
Route::post('api/notifications/{id}/interact', 'NotificationsController@interact');


// Admin

Route::get('admin', 'AdminController@index');

// Admin Auth
Route::get('admin/login', 'Auth\AdminLoginController@showLoginForm');
Route::post('admin/login', ['as'=>'admin-login','uses'=>'Auth\AdminLoginController@login']);
Route::get('admin/logout', 'Auth\AdminLoginController@logout');

// Admin API 
Route::put('api/users/{id_user}/ban','AdminController@ban');
Route::put('api/users/{id_user}/unban','AdminController@unban');


Route::put('api/projects/{id_project}/delete','AdminController@deleteProject');
Route::put('api/projects/{id_project}/restore','AdminController@restoreProject');