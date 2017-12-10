<?php
/**
 * Created by PhpStorm.
 * User: jane
 * Date: 2017/12/10
 * Time: 12:59
 */

namespace app\api\model;


use think\Db;
use think\Exception;

class Banner
{
    public static function getBannerByID($id) {

        // 第一种查询数据库方式，直接使用sql语句
        $result = Db::query(
            'select * from banner_item where banner_id=?', [$id]
        );
        return $result;
    }
}