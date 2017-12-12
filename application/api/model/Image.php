<?php

namespace app\api\model;

class Image extends BaseModel {

    protected $hidden = ['id', 'from', 'delete_time', 'update_time'];

    // 在具体的model里面定义读取器，getUrlAttr可以自动被TP5读取
    function getUrlAttr($value, $data) {
        return $this->prefixImgUrl($value, $data);
    }
}
