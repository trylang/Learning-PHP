<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/19
 * Time: 16:26
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单不存在，请检查ID';
    public $errorCode = 80000;
}