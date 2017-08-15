<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Illuminate\Http\Request;
use App\Models\Oauths;
use App\Models\UserOauths;
use Encore\Admin\Facades\Admin;

class OauthsController extends Controller
{
    use ModelForm;

    public function index ()
    {
        $oauthArr = UserOauths::where('user_id', Admin::user()->id)->pluck('oauth_id')->toArray();
        $services = Oauths::all();

        $authService = [];
        $unauthService = [];
        foreach ($services as $service) {
            if (in_array($service->id, $oauthArr)) 
                $authService[] = $service;
            else 
                $unauthService[] = $service;
        }

    	return view('oauths.index', compact("authService", 'unauthService'));
    }

    public function oauth ($id)
    {
        $oauth = Oauths::findOrfail($id);
        if ('Teambition' == $oauth->name) {
            return $this->jumpTeambitionAuthUrl();
        } else {
            admin_toastr('暂未接入，敬请期待');
            return redirect('oauths');
        }
    }

    public function unoauth ($id)
    {
        $user_id = Admin::user()->id;
        if ($oauth = UserOauths::where('user_id', $user_id)->where('oauth_id', $id)->first()) {
            $oauth->delete();
        }
        admin_toastr('取消授权成功');
        return $this->index();
    }

    public function jumpTeambitionAuthUrl()
    {
    	$params = array(
            'client_id' => config('services.teambition.app_key'),
            'redirect_uri' => url('oauth')
        );
        $get_code_url = config('services.teambition.auth_domain') . "/oauth2/authorize?" . http_build_query($params);
        return redirect($get_code_url);
    }

    public function authTeambition(Request $request)
    {
		$params = array(
            'client_id' => config('services.teambition.app_key'),
            'client_secret' => config('services.teambition.app_secret'),
            'code' => $request->code,
            'grant_type' => 'code'
        );
        $url = config('services.teambition.auth_domain') . '/oauth2/access_token';
        $result = curl_post($url, $params);
        
        $jsonResult = json_decode($result);
        if($jsonResult && isset($jsonResult->access_token)){
            $user_id = Admin::user()->id;
            if($auth = UserOauths::where('user_id', $user_id)->where('oauth_id', 1)->first()){
                $auth->update([$jsonResult->access_token]);
            } else {
                UserOauths::create([
                    'user_id' => $user_id,
                    'oauth_id' => 1,
                    'token' => $jsonResult->access_token
                ]);
            }  
            admin_toastr('授权成功'); 
        } else
            admin_toastr('授权失败');    	
    	return redirect('oauths');
    }
}
