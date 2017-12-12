<?php
/**
 * Created by PhpStorm.
 * User: jane
 * Date: 2017/12/12
 * Time: 23:20
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = [
        'count' => 'isPositiveInteger|between:1,15'
    ];
}