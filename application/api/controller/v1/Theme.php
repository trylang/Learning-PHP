<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 15:54
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;

use app\api\model\Theme as ThemeModel;
use app\api\validate\IDMustBePostiveInt;
use app\lib\exception\ThemeException;

class Theme
{
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();

        $ids = explode(',', $ids);
        $result = ThemeModel::with(['topicImg', 'headImg'])
            ->select($ids);

        if($result->isEmpty()) {
            throw new ThemeException();
        }
        // 返回的是一个数据集
        return $result;
    }

    public function getComplexOne($id) {
        (new IDMustBePostiveInt())->goCheck();
        $theme = ThemeModel::getThemeWithProducts($id);
        return $theme;
    }
}