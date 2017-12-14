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

    // 图片属性
     public function imgs() {
        return $this->hasMany('ProductImage','product_id', 'id');
    }

    public function properties() {
        return $this->hasMany('ProductProperty','product_id','id');
    }

    protected function getMainImgUrlAttr($value, $data){
        return $this->prefixImgUrl($value, $data);
    }

    protected function productImg() {
        return $this->hasMany('product_image', 'product_id', 'id');
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
        //Query
        $product = self::with([
            // 对关联字段img进行order升序排列
            'imgs' => function($query) {
                $query->with(['imgUrl'])
                    ->order('order', 'asc');
            }
        ])
            ->with(['properties'])
            ->find($id);
        return $product;

    }
}