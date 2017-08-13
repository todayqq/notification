<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\InfoBox;
use Encore\Admin\Widgets\Tab;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationLogs;

class HomeController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('首页');

            $user_id = Admin::user()->id;
            if(!Admin::user()->isAdministrator()){
                $project_count = DB::table('projects')->where('user_id', $user_id)->count();
                $user_count = DB::table('admin_users')->where('pid', $user_id)->count();

                $pid = DB::table('projects')->where('user_id', Admin::user()->id)->pluck('id')->toArray();
                $rows = NotificationLogs::whereIn('pid', $pid)->get()->toArray();
            } else {
                $project_count = DB::table('projects')->count();
                $user_count = DB::table('admin_users')->count();
                $rows = NotificationLogs::all()->toArray();
            }

            $content->row(function ($row) use($project_count, $user_count, $rows) {
                $row->column(3, new InfoBox('Projects', 'product-hunt', 'aqua', '/projects', $project_count));
                $row->column(3, new InfoBox('Users', 'users', 'green', '/auth/users', $user_count));
                $row->column(3, new InfoBox('NotificationLogs', 'commenting', 'yellow', 'notificationlogs', count($rows)));
                $row->column(3, new InfoBox('Oauths', 'key', 'red', 'oauths', 2));
            });

            $headers = ['Id', 'Name', 'Info', 'Content', 'Created_at'];
            foreach ($rows as &$row) {
                $row['content'] = str_limit($row['content'], 100, '...');
            }
            $content->row((new Box('最新通知 Log', new Table($headers, $rows)))->style('info')->solid());
        });
    }
}
