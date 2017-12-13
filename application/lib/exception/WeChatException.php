<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/13
 * Time: 16:21
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $msg = '微信服务器接口调用失败';
    public $errorCode = 999;
}