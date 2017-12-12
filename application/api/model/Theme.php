<?php
/**
 * Created by PhpStorm.
 * User: Jane
 * Date: 2017/12/12
 * Time: 16:16
 */

namespace app\api\model;

class Theme extends BaseModel
{
    protected $hidden = ['delete_time', 'update_time', 'topic_img_id', 'head_img_id'];
    // $this->>hasOne();
    public function topicImg() {
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg() {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }
}