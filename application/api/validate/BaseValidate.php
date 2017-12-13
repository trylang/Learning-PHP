<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/8
 * Time: 16:12
 */

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck() {
        // 获取http传入的参数
        // 对这些参数做校验
        $request = Request::instance();
        $params = $request->param();

        // batch()方法是批量处理数据
        $result = $this->batch()->check($params);
        if(!$result) {
            $e = new ParameterException([
                'msg' => $this->error
            ]);
            throw $e;
//            $error = $this->error;
//            throw new Exception($error);
        }
        else {
            return true;
        }

    }

    protected function isPositiveInteger($value, $rule='', $data='', $field='') {
        if(is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        }
        else {
            echo($value);
            return false;
        }
    }

    protected function isNotEmpty($value, $rule='', $data='', $field='') {
        if(empty($value)) {
            return false;
        }else {
            return true;
        }
    }
}






















