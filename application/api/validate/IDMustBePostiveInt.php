<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/8
 * Time: 16:18
 */

namespace app\api\validate;


class IDMustBePostiveInt extends BaseValidate
{
    // 这里的$rule, $message不能改成其他字段，是TP5默认的
    protected $rule = [
        'id' => 'require|isPositiveInteger'
    ];

    protected $message = [
      'id' => '必须是正整数'
    ];

    // 由于关于ID的验证是通用的，这就需要将这个方法放到基类里，供其他验证子类调用，这里就注释掉了，在基类里继承
//    protected function isPositiveInteger($value, $rule='',
//        $data='', $field='') {
//        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
//            return true;
//        }
//        else {
//            return $field.'必须是正整数';
//        }
//    }
}