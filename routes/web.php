<?php

Route::post('webhook/{webhook}', 'NotificationController@listenWebhook');
