<?php
use Illuminate\Support\Facades\DB;

if (!function_exists('tb_auth')) {
	function tb_auth() {
		$params = array(
            'client_id' => config('services.teambition.app_key'),
            'redirect_uri' => url('test/oauth')
        );
        $get_code_url = config('services.teambition.auth_domain') . "/oauth2/authorize?" . http_build_query($params);
        return redirect($get_code_url);
	}	
}

if (!function_exists('curl_post')) {
	function curl_post($url, $params, $header=false) {
		$ch = curl_init();
        $timeout = 5000;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
	}
}


if (!function_exists('getTbProjectList')) {
	function getTbProjectList($token) {
        $url = config('services.teambition.api_domain') . '/api/projects/?'.http_build_query($token);
        $result = file_get_contents($url);
        $jsonResult = json_decode($result);

        return $jsonResult;
    }
}

if (!function_exists('getTbTaskList')) {
	function getTbTaskList($project_id, $token) {
        $url = config('services.teambition.api_domain') . "/api/projects/{$project_id}/tasklists?".http_build_query($token);
        $result = file_get_contents($url);
        $jsonResult = json_decode($result);

        return $jsonResult;
    }
}

if (!function_exists('getTbPerson')) {
	function getTbPerson($project_id, $token) {
        $url = config('services.teambition.api_domain') . "/api/v2/projects/{$project_id}/members?". http_build_query($token);
        $result = file_get_contents($url);
        $jsonResult = json_decode($result);

        return $jsonResult;
    }
}

if (!function_exists('getTbProjectRoom')) {
	function getTbProjectRoom($project_id, $token) {
        $url = config('services.teambition.api_domain') . "/api/rooms/projects/{$project_id}?". http_build_query($token);
        $result = file_get_contents($url);
        $jsonResult = json_decode($result);

        return $jsonResult;
    }
}

if (!function_exists('SendTbRoomMsg')) {
    function SendTbRoomMsg($params, $token) {
        $url = config('services.teambition.api_domain') . "/api/rooms/{$params['_id']}/activities";
        $header[] = "Authorization: OAuth2 " . $token;            
        $result = curl_post($url, $params, $header);
        Log::info('condig 消息推送结果：'.$result);
        return $result;
    }
}

if (!function_exists('getTbToken')) {
    function getTbToken($project) {
        return DB::table('user_oauths')->where('user_id', $project->user_id)->where('oauth_id', 1)->value('token');
    }
}
