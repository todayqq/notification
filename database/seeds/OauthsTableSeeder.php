<?php

use Illuminate\Database\Seeder;
use App\Models\Oauths;

class OauthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Oauths::insert(
            $arr = array([
                "name" => 'Teambition',
                "description" => '将项目动态实时推送到指定 Teambition 讨论组，Sentry 报警信息自动创建任务指派给相关任务人',
                "auth_url" => 'oauths/teambition',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ], [
                "name" => '企业微信',
                "description" => '将项目动态实时推送到企业微信联系人，指定讨论组',
                "auth_url" => 'oauths/compony_wechat',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ])
        );
    }
}
