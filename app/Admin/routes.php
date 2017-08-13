<?php

use Illuminate\Routing\Router;
use App\Http\Middleware\CheckPermission;

Admin::registerHelpersRoutes();

Route::group([
    'prefix'        => config('admin.prefix'),
    'namespace'     => Admin::controllerNamespace(),
    'middleware'    => ['web', 'admin'],
], function (Router $router) {
    $router->get('auth/login', 'AuthController@getLogin');
    $router->post('auth/login', 'AuthController@postLogin');
    $router->get('auth/register', 'AuthController@register');
    $router->post('auth/register', 'AuthController@postRegister');
    $router->get('register/confirm/{token}', 'AuthController@confirmEmail')->name('confirm_email');

    $router->get('/', 'HomeController@index');

    $router->get('projects', 'ProjectsController@index');
    $router->get('projects/create', 'ProjectsController@create');
    $router->post('projects', 'ProjectsController@store');
    $router->get('projects/{id}/edit', 'ProjectsController@edit')->middleware(CheckPermission::class);
    $router->put('projects/{id}', 'ProjectsController@update')->middleware(CheckPermission::class);
    $router->delete('projects/{id}', 'ProjectsController@destroy')->middleware(CheckPermission::class);
    $router->get('projects/{id}/setting', 'ProjectsController@showSettingView')->middleware(CheckPermission::class);
    $router->post('projects/{id}/setting', 'ProjectsController@setting')->middleware(CheckPermission::class);
    // $router->post('projects/{id}/notification/{type}', 'ProjectsController@notification');

    $router->get('notificationlogs', 'NotificationLogsController@index');

    //oauth
    $router->get('oauths', 'OauthsController@index');
    $router->get('oauths/{id}', 'OauthsController@oauth');
    $router->get('unoauths/{id}', 'OauthsController@unoauth');
    $router->get('oauth', 'OauthsController@authTeambition');

    $router->get('getTaskList/{pid}/{id}', 'TeambitionController@getTaskList');
    $router->get('getPerson/{pid}/{id}', 'TeambitionController@getPerson');

    $router->resource('auth/users', 'UsersController');

    //log
    $router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
