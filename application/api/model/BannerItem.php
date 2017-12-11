<?php

namespace app\api\model;

use think\Model;

class BannerItem extends Model
{
    public function img() {
        // belongsTo 一对多的关系
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}
