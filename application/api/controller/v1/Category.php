<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/13
 * Time: 10:46
 */

namespace app\api\controller\v1;

use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    public function getAllCategories() {

        // 这里的all方法与下面的with+select方法等同
        $categories = CategoryModel::all([], 'img');

//        $categories = CategoryModel::with('img')
//            ->select();
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }
}