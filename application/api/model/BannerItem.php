<?php

namespace app\api\model;

class BannerItem extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time'];
    public function img() {
        // belongsTo 一对多的关系
        return $this->belongsTo('Image', 'img_id', 'id');
    }
}
