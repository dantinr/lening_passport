<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

use App\Model\Usermodel;

class LoginController extends Controller
{
    //

    /**
     * 登录页面
     */
    public function login()
    {
        $data = [];
        return view('web.login');
    }

    /**
     * 登录逻辑
     */
    public function loginDo(Request $request)
    {
        echo '<pre>';print_r($_POST);echo '</pre>';

        $u = $request->input('u_name');
        $p = $request->input('u_pass');

        echo 'u: '.$u;echo '</br>';
        echo 'p: '.$p;echo '</br>';

        $u = UserModel::where(['email'=>$u])->first();

        if($u){
            if( password_verify($p,$u->pass) ){

                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('uid',$u->uid,time()+86400,'/','shop.com',false,true);
                setcookie('token',$token,time()+86400,'/','shop.com',false,true);

                $request->session()->put('u_token',$token);
                $request->session()->put('uid',$u->uid);

                //记录web登录token
                $redis_key_web_token = 'str:u:token:web:'.$u->uid;
                Redis::set($redis_key_web_token,$token);
                Redis::expire($redis_key_web_token,86400);

                header("Refresh:3;url=/user/center");
                echo "登录成功";
            }else{
                die("密码不正确");
            }
        }else{
            die("用户不存在");
        }

    }

    public function uCenter()
    {
        echo "个人中心";
    }
}
