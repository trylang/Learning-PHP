<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/8
 * Time: 11:09
 */

namespace app\api\controller\v1;

//use think\Validate;
use app\api\validate\IDMustBePostiveInt;
//use app\api\validate\TestValidate;

class Banner
{
    /*
     * 获取指定id的banner信息
     * @url /banner/:id
     * @http GET
     * @id banner的id号
     *
     */
    public function getBanner($id) {
        (new IDMustBePostiveInt())->goCheck();

        // 独立验证
//        $data = [
//            'name' => 'vendor111121',
//            'email' => 'vendorqq.com'
//        ];

//        $validate = new Validate([
//            'name' => 'require|max:10',
//            'email' => 'email'
//        ]);
//        $validate = new TestValidate();
//        $result = $validate->batch()->check($data);
//        var_dump($validate->getError());
        // 验证器
        echo($id);
    }
}
















