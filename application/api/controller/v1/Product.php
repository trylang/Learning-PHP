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
use app\lib\exception\ProductException;

class Product
{
    public function getRecent($count = 15) {
        (new Count())->goCheck();

        $products = ProductModel::getMostRecent($count);
        if(!$products) {
            throw new ProductException();
        }

        return $products;
    }
}