<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use App\Models\Projects;
use App\Models\NotificationLogs;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Encore\Admin\Facades\Admin;
use App\Models\AdminUsers;

class NotificationController extends Controller
{
    public function listenWebhook($webhook, Request $request)
    {
    	// Log::info($request->all());
        $project = Projects::where('webhook', $webhook)->first();
        if (!$project) {
            return response('未授权', 403);
        }

        NotificationLogs::create([
            'pid' => $project->id,
            'name' => $project->name,
            'info' => $request->info,
            'content' => json_encode($request->all())
        ]);

        if ('coding' == $request->info) {
            if ($project && $project->coding_msg_status) {
                return $this->sendCodingMessage($project, $request->all());
            }
        } else if ('sentry' == $request->info && $project->tb_pid && $project->tb_tasklistid) {
    	    return $this->createTeambitionTask($project, $request->all());
        } else if ('github' == $request->info) {
            return $this->sendGithubMessage($project, $request->all());
        }
    }

    protected function sendMessageEmail($email_userids, $msg)
    {
        foreach ($email_userids as $user_id) {
            $title = 'Notification';
            $email = AdminUsers::findOrfail($user_id)->email;
            if ($email) {
                Mail::raw($msg, function ($m) use($email, $title) {
                    $m->subject($title);
                    $m->to($email);
                });
            }
        }
    }

    protected function sendCodingMessage($project, $message)
    {
        if (!isset($message['commits'])) {
            return response('success', 200);
        }

        $msg = "Coding 提交信息
项目: {$project->name},
分支: {$project->ref},
User: {$message['user']['name']},
event: {$message['event']},
Description: {@$message['commits'][0]['short_message']}";        
        if ($project->email_status && 0 != count($project->send_email_users)) {
            $this->sendMessageEmail($project->send_email_users, $msg);
        }

        $params = array(
            '_id' => $project->tb_roomid,
            'content' => $msg
        );
        return SendTeambitionRoomMessage($params, getTeambitionToken($project));
    }

    protected function sendGithubMessage($project, $message)
    {
        $content = json_decode($message['payload']);
        $commits = $content->commits[0];

        $msg = "GitHub 提交信息
项目: {$project->name},
用户: {$commits->author->name},
提交分支: {$content->ref},
提交时间: {$commits->timestamp},
修改信息: {$commits->message},
详情连接: {$commits->url}";

        if ($project->email_status && 0 != count($project->send_email_users)) {
            $this->sendEmails($project->send_email_users, $msg);
        }

        $params = array(
            '_id' => $project->tb_roomid,
            'content' => $msg
        );
        $result = SendTeambitionRoomMessage($params, getTeambitionToken($project));
        Log::info('GitHub 消息推送结果：' . $result);
    }

    protected function createTeambitionTask($project, $content)
    {
        $msg = "Sentry 报警
项目: {$project->name},
错误简要：{$content['message']}
查看详细信息请点击：{$content['url']}";

        if ($project->email_status && 0 != count($project->send_email_users)) {
            $this->sendEmails($project->send_email_users, $msg);
        }

        if ($project->sentry_msg_status) {
            $params = array(
                '_id' => $project->tb_roomid,
                'content' => $msg
            );
            $result = SendTeambitionRoomMessage($params, getTeambitionToken($project));
            Log::info('Sentry 消息推送结果：' . $result);
        }

        $params = array(
            '_tasklistId' => $project->tb_tasklistid,
            '_stageId' => $project->tb_stageid,
            '_executorId' => $project->tb_executorid,
            "involveMembers" => $project->tb_personid,
            'content' => $content['message'],
            'note' =>  '查看详细信息请点击：'. $content['url']
        );
        $url = config('services.teambition.api_domain') . '/api/tasks';

        $header[] = "Authorization: OAuth2 " . getTeambitionToken($project); 

        $result = curl_post($url, $params, $header);
        Log::info('Sentry 错误创建 Bug 任务结果：'.$result);
        return $result;
    }
}
