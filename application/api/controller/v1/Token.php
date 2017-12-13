<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/13
 * Time: 14:50
 */

namespace app\api\controller\v1;


use app\api\service\UserToken;
use app\api\validate\TokenGet;

class Token
{
    public function getToken($code='') {
        (new TokenGet())->goCheck();
        $ut = new UserToken($code);
        // 通过get方法直接拿到的是字符串，在客户端不要返回字符串，而应该是json形式
        // 这时我们可以通过返回一个数组['token'=> $token]的方式，TP5会默认转换成json格式
        $token = $ut->get();
//        return $token;
        return [
            'token' => $token
        ];
    }
}