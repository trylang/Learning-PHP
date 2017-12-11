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
use think\Model;

class Banner extends Model
{
    // 受保护的成员变量，如此thinkPHP就知道查询的是哪张表。如果不写，则thinkPHP默认认为表名与类名Banner相同
//    protected $table = 'category';

    // 这里做关联的函数items要作为属性返回其banner_item的数据，在controller中通过with('items')调用
    public function items() {
        // $this 指的是Banner这个类（当前模型）。hasMany方法传入参数：1.BannerItem模型，banner_id是关联模型BannerItem的外键，
        // id是Banner当前模型的主键
        return $this->hasMany('BannerItem', 'banner_id', 'id');
    }
    public static function getBannerByID($id) {

        // 第一种查询数据库方式，直接使用sql语句
//        $result = Db::query(
//            'select * from banner_item where banner_id=?', [$id]
//        );
        // 第二种方法使用Db，where 表达式法('字段名', '表达式', '查询条件');
//        $result = Db::table('banner_item')
//            ->where('banner_id', '=', $id)
//            ->select();
        //where 闭包法
        $result = Db::table('banner_item')
//            -> fetchSql() 如果使用fetchSql方法，则$result只会返回sql语句，而不会返回数据库数据
            -> where(function($query) use ($id) {
               $query->where('banner_id', '=', $id);
            })
            -> select();
        return $result;
    }
}