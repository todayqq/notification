<?php

use Illuminate\Routing\Router;

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
    $router->resource('auth/users', 'UsersController');

    $router->resource('projects', ProjectsController::class);
    $router->get('projects/{id}/setting', 'ProjectsController@showSettingView');
    $router->post('projects/{id}/setting', 'ProjectsController@setting');
    $router->post('projects/{id}/notification/{type}', 'ProjectsController@notification');

    $router->get('notificationlogs', 'NotificationLogsController@index');

    //oauth
    $router->get('oauths', 'OauthsController@index');
    $router->get('oauths/{id}', 'OauthsController@oauth');
    $router->get('unoauths/{id}', 'OauthsController@unoauth');
    $router->get('oauth', 'OauthsController@authTeambition');

    $router->get('getTaskList/{pid}/{id}', 'TeambitionController@getTaskList');
    $router->get('getPerson/{pid}/{id}', 'TeambitionController@getPerson');
});
