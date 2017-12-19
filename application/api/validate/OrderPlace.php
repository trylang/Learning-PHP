<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/18
 * Time: 17:01
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    // 验证项代码示例：
    protected $products = [
        [
            'product_id' => 1,
            'count' => 3
        ], [
            'product_id' => 5,
            'count' => 7
        ], [
            'product_id' => 3,
            'count' => 2
        ]
    ];

    protected $rule = [
      'products' => 'checkProducts'
    ];

    protected $singleRule = [
      'product_id' => 'require|isPositiveInteger',
      'count' => 'require|isPositiveInteger'
    ];

    protected function checkProducts($values) {
        if(!is_array($values)){
            throw new ParameterException([
                'msg' => '商品参数不正确'
            ]);
        }

        if(empty($values)){
            throw new ParameterException([
               'msg' => '商品列表不能为空'
            ]);
        }

        foreach ($values as $value) {
            $this->checkProduct($value);
        }
        return true;
    }

    // 只有$rule是可以自动触发，而自己自定义的规则需要手动触发，触发函数checkProduct
    private function checkProduct($value) {
        $validate = new BaseValidate($this->singleRule);
        $result = $validate->check($value); // check是TP5自带检测方法
        if(!$result) {
            throw new ParameterException([
               'msg' => '商品列表参数错误'
            ]);
        }
    }

}