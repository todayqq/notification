<?php

namespace App\Admin\Controllers;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('项目');
            $content->description('列表');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('项目');
            $content->description('编辑');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('项目');
            $content->description('创建');

            $content->body($this->form());
        });
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $post = $request->all();
        $post['webhook'] = md5(time().$this->randString(10));
        $post['user_id'] = Admin::user()->id;
        if (Projects::create($post)) {
            admin_toastr('操作成功');
            return redirect('projects');
        }
    }

    protected function randString($length) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[rand(0, $max)];
        }
        return $result;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Projects::class, function (Grid $grid) {
            if(!Admin::user()->isAdministrator())
                $grid->model()->where('user_id', Admin::user()->id);
            $grid->id('ID')->sortable();
            $grid->column('name');
            $grid->description()->display(function($text) {
                if (null == $text) return '';
                return str_limit($text, 30, '...');
            });

            $grid->actions(function ($actions) {
                $actions->prepend('<a href="'. url('projects/'. $actions->getKey() .'/setting') .'"><i class="fa fa-cog"></i></a>');
            });
            $grid->created_at();

            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('name', 'Name');
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Projects::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name')->rules('required|min:2|max:50');
            $form->textarea('description')->rows(3);
        });
    }

    public function showSettingView($id)
    {
        $project = Projects::find((int)$id);
        $tbToken = array(
            'access_token' => getTbToken($project)
        );

        $tbProjectList = getTbProjectList($tbToken);
        if(!Admin::user()->isAdministrator()){
            $userEmails = DB::table('admin_users')->select('id', 'email')->where('pid', Admin::user()->id)->get()->toArray();
            $userEmails[] = (object)[
                "id" => Admin::user()->id,
                "email" => Admin::user()->email 
            ];
            // dd($userEmails);
        } else {
            $userEmails = DB::table('admin_users')->select('id', 'email')->get();
        }

        $tb_pid = $project->tb_pid;
        
        if ($tb_pid && null != $tbToken['access_token']) {
            $tbTasklist = getTbTaskList($tb_pid, $tbToken);
            $tbPerson = getTbPerson($tb_pid, $tbToken);
            return view('projects.setting', compact('project','tbProjectList', 'tbTasklist', 'tbPerson', 'userEmails', 'tbToken'));
        }
        return view('projects.setting', compact('project','tbProjectList', 'userEmails', 'tbToken'));
    }

    public function setting($id, Request $request)
    {
        $project = Projects::findOrFail($id); 
        $content = $request->all();
        if(isset($content['tb_pid']) && isset($content['coding_msg_status'])) {
            $tbToken = array(
                'access_token' => getTbToken($project)
            );
            if ($room = getTbProjectRoom($content['tb_pid'], $tbToken)) {
                $content['tb_roomid'] = $room->_id;
            }
        }  
        if ($project->update($content)) {
            admin_toastr('设置成功');
            return redirect('projects');
        }
        admin_toastr('设置失败');
        return back();
    }

    public function notification($id, $type)
    {
        
    }
}
