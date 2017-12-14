<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/13
 * Time: 15:03
 */

namespace app\api\model;


class User extends BaseModel
{
    public function address() {
        return $this->hasOne('UserAddress', 'user_id', 'id');
    }

    public static function getByUserID($openid) {
        $user = self::where('openid','=', $openid)
            ->find();
        return $user;
    }
}