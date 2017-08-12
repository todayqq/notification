<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Projects;

class TeambitionController extends Controller
{
    use ModelForm;

    public function getTaskList($pid, $project_id)
    {
    	$tbToken = array(
            'access_token' => getTbToken(Projects::findOrfail($pid))
        );
    	return getTbTaskList($project_id, $tbToken);
    }

    public function getPerson($pid, $project_id)
    {
    	$tbToken = array(
            'access_token' => getTbToken(Projects::findOrfail($pid))
        );
    	return getTbPerson($project_id, $tbToken);
    }

}
