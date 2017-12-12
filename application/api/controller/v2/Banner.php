<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/8
 * Time: 11:09
 */

namespace app\api\controller\v2;

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
        $banner = BannerModel::getBannerByID($id);
        if (!$banner) {
            throw new BannerMissException();
        }
        return json($banner);
    }
}
















