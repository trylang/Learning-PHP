<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/15
 * Time: 16:31
 */

namespace app\lib\exception;

class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10002;
}