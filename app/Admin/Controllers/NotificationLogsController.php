<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Models\NotificationLogs;
use App\Models\Projects;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;

class NotificationLogsController extends Controller
{
    use ModelForm;

    public function index()
    {
	    return Admin::content(function (Content $content) {
            $content->header('最新通知 Log');
            $content->description('列表');

            $grid = Admin::grid(NotificationLogs::class, function (Grid $grid) {
                if(!Admin::user()->isAdministrator()){
                    $pid = Projects::where('user_id', Admin::user()->id)->pluck('id')->toArray();
                    $grid->model()->whereIn('pid', $pid);
                }

                $grid->model()->orderBy('id', 'DESC');
                $grid->id('ID')->sortable();
                $grid->name();
                $grid->info();
                $grid->content()->display(function($text) {
                    $content = json_decode($text);
                    if ($content && 'github' == $content->info) {
                        return json_decode($content->payload);
                    } 
                    return $content;
                });
                $grid->created_at(trans('admin::lang.created_at'));

                $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableEdit();
                });

                $grid->disableCreation();
            });

            $content->body($grid);
        });
	}

	public function destroy($id)
    {
        $ids = explode(',', $id);

        if (NotificationLogs::destroy(array_filter($ids))) {
            return response()->json([
                'status'  => true,
                'message' => trans('admin::lang.delete_succeeded'),
            ]);
        } else {
            return response()->json([
                'status'  => false,
                'message' => trans('admin::lang.delete_failed'),
            ]);
        }
    }
}
