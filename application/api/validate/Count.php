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
        // 后面字符串不要随便加空格，否则规则不生效
        'count' => 'isPositiveInteger|between:1,15'
    ];
}