<?php
/**
 * Created by PhpStorm.
 * User: jane
 * Date: 2017/12/10
 * Time: 20:56
 */

namespace app\lib\exception;


class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = 10000;
}