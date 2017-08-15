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

    $router->resource('projects', 'ProjectsController');
    $router->get('projects/{project}/setting', 'ProjectsController@showSettingView');
    $router->post('projects/{project}/setting', 'ProjectsController@setting');

    $router->get('notificationlogs', 'NotificationLogsController@index');

    //oauth
    $router->get('oauths', 'OauthsController@index');
    $router->get('oauths/{id}', 'OauthsController@oauth');
    $router->get('unoauths/{id}', 'OauthsController@unoauth');
    $router->get('oauth', 'OauthsController@authTeambition');

    $router->get('teambition/{teambition_project_id}/getTaskList', 'TeambitionController@getTaskList');
    $router->get('teambition/{teambition_project_id}/getPerson', 'TeambitionController@getPerson');

    $router->resource('auth/users', 'UsersController');

    //log
    $router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

});
