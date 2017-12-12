<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 15:54
 */

namespace app\api\controller\v1;

use app\api\validate\IDCollection;

class Theme
{
    public function getSimpleList($ids = '') {
        (new IDCollection())->goCheck();
        return 'sussess';
    }
}