<?php

namespace app\api\model;

use think\Model;

class BaseModel extends Model
{
    // 1. 定义一个基类继承于Model，如此基类里的方法，会对所有继承于积累的model都生效
    // 2. 如果读取器getUrlAttr只在Image的model里引用的话，其他model也有url这个字段需要读取时，读取器的函数名是一致的，
    //    这样在Image的model里就不起作用了。
    // 3. 如此，我们就将关于url字段的读取器放到基类BaseModel中，由Image的model继承这个基类，这个关于字段url的读取器就会很通用
    // 4. 但这里还有一个问题，有关urlzi字段的处理不一定就是这么处理，所以在基类里面使用普通函数进行定义，而在image具体的model中使用getUrlAttr()
    //    自动读取，定义一个普通的函数，其他model中需要读取时，再调用。

//    public function getUrlAttr($value, $data) {
//        $finalUrl = $value;
//        if($data['from'] == 1) {
//            $finalUrl = config('setting.img_prefix').$value;
//        }
//        return $finalUrl;
//    }

// 处理image路径函数
    protected function prefixImgUrl($value, $data) {
        $finalUrl = $value;
        if($data['from'] == 1) {
            $finalUrl = config('setting.img_prefix').$value;
        }
        return $finalUrl;
    }

}
