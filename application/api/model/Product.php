<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 15:55
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden = [
        'delete_time', 'main_img_id', 'pivot', 'from', 'category_id',
        'create_time', 'update_time'];

    protected function getMainImgUrlAttr($value, $data){
        return $this->prefixImgUrl($value, $data);
    }

    public static function getMostRecent($count) {

        // limit 指定数量
        $products = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $products;
    }

    public static function getProductsByCategoryID($categoryID) {
        // 查询条件用where
        $products = self::where('category_id', '=', $categoryID)
            ->select();
        return $products;
    }

    public static function getProductDetail($id) {

    }
}