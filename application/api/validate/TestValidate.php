<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/8
 * Time: 14:16
 */

namespace app\api\validate;

use think\Validate;


class TestValidate extends Validate
{
    protected $rule = [
        'name' => 'require|max:10',
        'email' => 'email'
    ];
}