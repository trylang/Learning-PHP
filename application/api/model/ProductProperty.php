<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/14
 * Time: 13:50
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{
    protected $hidden=['product_id', 'delete_time', 'id'];
}