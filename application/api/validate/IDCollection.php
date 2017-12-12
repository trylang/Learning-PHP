<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 17:08
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{
    protected $rule = [
        'ids' => 'require|checkIDs'
    ];

    protected $message = [
        'ids' => 'ids参数必须是以逗号分隔的多个正整数'
    ];

    protected function checkIDs($value) {

        // ids = id1, id2 ...
        $values = explode(',', $value);
        if(empty($values)) {
            return false;
        }
        foreach ($values as $id) {
            if(!$this->isPositiveInteger($id)) {
                return false;
            }
        }
        return true;
    }
}










