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
use app\lib\exception\ThemeException;

class Theme
{
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();

        $ids = explode(',', $ids);
        $result = ThemeModel::with(['topicImg', 'headImg'])
            ->select($ids);

        if(!$result) {
            throw new ThemeException();
        }
        // 返回的是一个数据集
        return $result;
    }
}