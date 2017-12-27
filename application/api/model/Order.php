<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/26
 * Time: 17:31
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden = ['user_id', 'delete_time', 'update_time'];

    // 自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 读取器
    public function getSnapItemsAttr($value)
    {
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    // 读取器
    public function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode(($value));
    }

    // 订单历史记录分页
    public static function getSummaryByUser($uid, $page=1, $size=15) {
        $pagingData = self::where('user_id','=', $uid)
            ->order('create_time desc')
            ->paginate($size, true, ['page'=>$page]);
        return $pagingData;
    }

}


















