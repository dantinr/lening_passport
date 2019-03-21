<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(isset($_COOKIE['uid']) && isset($_COOKIE['token'])){
            //验证用户token
            $redis_key = 'str:u:token:web:'.$_COOKIE['uid'];
            $r_token = $_COOKIE['token'];
            $token = Redis::get($redis_key);

            if($r_token == $token){
                //TODO token验证通过
                //echo 'OK';
            }else{
                //TODO token验证失败
                header("Refresh:3;url=/login");
                echo 'Invalid Token!!';
                die;
            }
        }

        return $next($request);
    }
}
