<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Model\Usermodel;

class LoginController extends Controller
{
    //

    public function apiLogin(Request $request)
    {
        $u = $request->input('u');
        $p = $request->input('p');

        $u_info = Usermodel::where(['email'=>$u])->first();


        if($u_info){
            if(password_verify($p,$u_info->pass)){

                //echo '<pre>';print_r($u_info->toArray());echo '</pre>';
                $response = [
                    'errno' => 0,
                    'msg'   => 'ok',
                    'data'  => [
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

        echo json_encode($response);
    }
}
