<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 19:01
 */

namespace app\lib\exception;

class ThemeException extends BaseException
{
    public $code = 404;
    public $msg = '指定主题不存在，请检查主题ID';
    public $errorCode = 30000;
}