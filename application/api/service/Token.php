<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/13
 * Time: 18:16
 */

namespace app\api\service;


use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    // 用三组字符串，进行MD5加密
    public static function generateToken() {
        // 第一组：32个字符组成一组随机字符串
        $randChars = getRandChars(32);
        // 第二组：时间戳
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        // 第三组： salt: 盐
        $salt = config('secure.token_salt');
        // MD5加密
        return md5($randChars.$timestamp.$salt);
    }

    // 获取用户信息的通用方法
    public static function getCurrentTokenVar($key) {
        // 约定token令牌在request的头里存储，不能存储在body，这里获取到令牌token
        $token = Request::instance()
            ->header('token');
        // 通过token从缓存中取到用户信息
        $vars = Cache::get($token);
        if(!$vars) {
            throw new TokenException();
        }
        else {
            if(!is_array($vars)) {
                // $vars如果是按cache存储时，是存在于文件中，返回是字符串，转换成数组会好处理些
                $vars = json_decode($vars, true);
            }
            if(array_key_exists($key, $vars)) {
                return $vars[$key];
            }
            else {
                throw new Exception('尝试获取的Token变量不存在');
            }
        }
    }

    public static function getCurrentUID() {
        //token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
}