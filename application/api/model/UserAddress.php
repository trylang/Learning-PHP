<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/14
 * Time: 19:01
 */

namespace app\api\model;


class UserAddress extends BaseModel
{
    protected $hidden =['id', 'delete_time', 'user_id'];

}