<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/13
 * Time: 18:16
 */

namespace app\api\service;


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
}