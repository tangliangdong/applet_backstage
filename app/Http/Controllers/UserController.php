<?php
/**
 * Created by PhpStorm.
 * User: tangliangdong
 * Date: 2017/10/18
 * Time: 12:48
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller{

    private $appId = 'wx2ebe56119c49465b';
    private $secret = 'ec1f364a3bf69be1ddd7514328196c2d';
    private $grant_type = 'authorization_code';

    public function login(Request $request){
        $code = $request->input('code');
        $api_url = sprintf("https://api.weixin.qq.com/sns/jscode2session?appid=%s&secret=%s&js_code=%s&grant_type=%s",
            $this->appId, $this->secret, $code, $this->grant_type);
        $resp_contents = file_get_contents($api_url);
        $data = json_decode($resp_contents, TRUE);
        $user = DB::table('user')
            ->where('open_id',$data['openid'])
            ->first();
        if($user){
            $res = ['status'=>1,'userId'=>$user->id];
            return json_encode($res);
        }else{
            $time = time();
            $num = DB::table('user')->insertGetId(
                ['nikename' => 'Hello World', 'add_time'=>$time,'open_id'=>$data['openid']]
            );
            if ($num>0){
                $res = ['status'=>1];
            }else{
                $res = ['status'=>0];
            }
            return json_encode($res);
        }

    }
}