<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;

class TeambitionController extends Controller
{
    use ModelForm;

    public function getTaskList($project_id, Request $request)
    {
    	$tbToken = array(
            'access_token' => $request->token
        );
    	return getTeambitionTaskList($project_id, $tbToken);
    }

    public function getPerson($project_id, Request $request)
    {
    	$tbToken = array(
            'access_token' => $request->token
        );
    	return getTeambitionPerson($project_id, $tbToken);
    }
}
