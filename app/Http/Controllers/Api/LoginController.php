<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Usermodel;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    //

    public function apiLogin(Request $request)
    {
        $u = $request->input('u');
        $p = $request->input('p');
        $c = $request->input('c');          // 客户端类型 1:Android 2:Iphone 3:IPAD

        $u_info = Usermodel::where(['email'=>$u])->first();


        if($u_info){
            if(password_verify($p,$u_info->pass)){
                $uid = $u_info->uid;

                //生成token
                $token = substr(md5($u_info->uid . mt_rand(11111,99999). time()),5,16);

                $key = 'str:token:app:'.$c. ':uid:'.$uid;
                Redis::set($key,$token);
                Redis::expire($key,604800);     // 3600 * 24 * 7


                //返回用户信息,处理敏感数据
                unset($u_info->pass);

                $response = [
                    'errno' => 0,
                    'msg'   => 'ok',
                    'data'  => [
                        'token' => $token,
                        'u' => $u_info->toArray()
                    ]
                ];

            }else{
                // TODO 密码不正确
                $response = [
                    'errno' => 40001,
                    'msg'   => '用户名或密码不正确'
                ];
            }
        }else{
            //TODO 账户不存在
            $response = [
                'errno' => 40002,
                'msg'   => '用户名或密码不正确'
            ];
        }

        //echo '<pre>';print_r($response);echo '</pre>';
        echo json_encode($response);
    }
}
