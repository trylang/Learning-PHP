<?php
/**
 * Created by PhpStorm.
 * User: jane
 * Date: 2017/12/12
 * Time: 23:18
 */

namespace app\api\controller\v1;

use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15) {
        (new Count())->goCheck();

        $products = ProductModel::getMostRecent($count);
        if($products->isEmpty()) {
            throw new ProductException();
        }
//        if(!$products) { 这样判断，是$products为数组，而不是数据集的判断方法
//            throw new ProductException();
//        }

        // 1. 使用collection方法转换成数据集，方便对数组数据做处理。直接是数组则没有一些办法来处理数组
        // 2. 当然还有第二种方式，就是在database.php配置表中，将字段‘resultset_type’设置成‘collection’。则直接数组就会转换成数据集
//        $collection  = collection($products);
        // 使用数据集里的hidden方法临时隐藏'summary'字段，如此就不会影响Product的模型里summary字段的显示
        $products = $products->hidden(['summary']);

        return $products;
    }

    public function getAllInCategory($id) {
        (new IDMustBePostiveInt())->goCheck();
        $products = ProductModel::getProductsByCategoryID($id);
        if($products->isEmpty()) {
            throw new ProductException();
        }
        $products = $products->hidden(['summary']);
        return $products;
    }
}