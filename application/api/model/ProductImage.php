<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/14
 * Time: 10:39
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ['img_id', 'delete_time', 'product_id'];
    public function imgUrl() {
        return $this->belongsTo('Image','img_id', 'id');
    }
}