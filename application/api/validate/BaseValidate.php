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
}






















