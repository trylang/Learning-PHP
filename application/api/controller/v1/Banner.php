<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/8
 * Time: 11:09
 */

namespace app\api\controller\v1;

use app\api\validate\IDMustBePostiveInt;
use app\api\model\Banner as BannerModel;
use app\lib\exception\BannerMissException;
use think\Exception;

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

        // AOP 面向切面编程
        (new IDMustBePostiveInt())->goCheck();

//        $banner = new BannerModel();
//        $banner = $banner->get($id);
        $banner = BannerModel::getBannerByID($id);

//        // 隐藏返回字段的一种办法
//        $banner->hidden(['update_time', 'delete_time']);

        if (!$banner) {
            //BannerMissException 必须是Exception类，否则会报错
            // 如果想要让BannerMissException智能感知，就需要在BaseException中继承Exception类才可以
//            throw new BannerMissException();
//            throw new Exception('内部错误');
            throw new BannerMissException();
        }
//        return $banner;
        $imagesUrl = config('setting.img_prefix');
        return json($banner);

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
















